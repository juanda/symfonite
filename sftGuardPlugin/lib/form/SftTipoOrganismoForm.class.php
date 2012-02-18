<?php

/**
 * SftTipoOrganismo form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class SftTipoOrganismoForm extends BaseSftTipoOrganismoForm
{

    public function configure()
    {
        EmbedI18n::aniadeTraducciones($this);
    }

}
