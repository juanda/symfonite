<?php
include(dirname(__FILE__) . "/lib/vendor/phpPoA-2.3/PoA.php");
$poa = new PoA("symfonite");
$auth = $poa->authenticate();

echo 'auth:'.$auth.'<br/>';

if ($auth)
{
    echo OK;
    echo '<pre>';
    print_r($poa -> getAttributes());
    echo '</pre>';
} else
{
    echo NO_OK;
}
