<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

/**
 * Validates a user login.
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php 30261 2010-07-16 14:06:36Z fabien $
 */
class sfGuardValidatorUser extends sfValidatorBase
{
    /**
     * Configures the user validator.
     *
     * Available options:
     *
     *  * username_field      Field name of username field (username by default)
     *  * password_field      Field name of password field (password by default)
     *  * throw_global_error  Throws a global error if true (false by default)
     *
     * @see sfValidatorBase
     */
    public function configure($options = array(), $messages = array())
    {
        $this->addOption('username_field', 'username');
        $this->addOption('password_field', 'password');
        $this->addOption('throw_global_error', false);

        $this->setMessage('invalid', 'The username and/or password is invalid.');
        $this->addMessage('inactive_user', 'Your account is inactive.');
        $this->addMessage('app_max_num_login_fails', 'The maximum number of login trials has been reached. Your account has been deactivated');

    }

    /**
     * @see sfValidatorBase
     */
    protected function doClean($values)
    {
       /*
        * No sé porqué, pero el método doClean es llamado dos veces en una
        * misma petición, con lo cual, cuando hay un fallo el contador de la base de datos
        * (campo num_login_fails) se incrementa en dos.
        * La solución a este problema (cutrona pero la mejor hasta el momento)
        * ha sido registrar el nº de veces que este método se llama y realizar cambios
        * (incrementar el contador) sólo en las llamadas impares
        */
        sfContext::getInstance() -> getUser() -> setAttribute('times_doClean_has_been_called',
                sfContext::getInstance() -> getUser() -> getAttribute('times_doClean_has_been_called',0) +1);

        // only validate if username and password are both present
        if (isset($values[$this->getOption('username_field')]) && isset($values[$this->getOption('password_field')]))
        {
            $username = $values[$this->getOption('username_field')];
            $password = $values[$this->getOption('password_field')];

            // user exists?
            if ($user = sfGuardUserPeer::retrieveByUsername($username))
            {
                // inactive user?
                if($user -> getIsActive() == 0)
                {
                    throw new sfValidatorError($this, 'inactive_user');
                }

                // max num of login fails reached?

                if(($user -> getNumLoginFails()) == sfConfig::get('app_max_num_login_fails', -1))
                {

                    $user -> setIsActive(0);
                    $user -> save();
                    throw new sfValidatorError($this, 'max_login_fails_reached');
                }

                if($user -> checkPassword($password))
                {
                    $user -> setNumLoginFails(0);
                    $user -> save();
                    return array_merge($values, array('user' => $user));
                }
                elseif((sfContext::getInstance() -> getUser() -> getAttribute('times_doClean_has_been_called')) % 2 != 0)
                {
                    $user -> setNumLoginFails($user -> getNumLoginFails() +1);
                    $user -> save();
                    throw new sfValidatorError($this, 'invalid');
                }

//                // password is ok?
//                if ($user->getIsActive() && $user->checkPassword($password))
//                {
//                    return array_merge($values, array('user' => $user));
//                }

            }

            if ($this->getOption('throw_global_error'))
            {
                throw new sfValidatorError($this, 'invalid');
            }

            throw new sfValidatorErrorSchema($this, array(
                    $this->getOption('username_field') => new sfValidatorError($this, 'invalid'),
            ));
        }

        // assume a required error has already been thrown, skip validation
        return $values;
    }
}
