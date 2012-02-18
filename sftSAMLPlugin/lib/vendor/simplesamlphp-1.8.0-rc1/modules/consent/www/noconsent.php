<?php
/**
 * This is the page the user lands on when choosing "no" in the consent form.
 *
 * @package simpleSAMLphp
 * @version $Id$
 */
if (!array_key_exists('StateId', $_REQUEST)) {
    throw new SimpleSAML_Error_BadRequest(
        'Missing required StateId query parameter.'
    );
}

$id = $_REQUEST['StateId'];
$state = SimpleSAML_Auth_State::loadState($id, 'consent:request');

$resumeFrom = SimpleSAML_Module::getModuleURL(
    'consent/getconsent.php',
    array('StateId' => $id)
);

$aboutService = null;
if (isset($state['Destination']['url.about'])) {
    $aboutService = $state['Destination']['url.about'];
}

$globalConfig = SimpleSAML_Configuration::getInstance();

$t = new SimpleSAML_XHTML_Template($globalConfig, 'consent:noconsent.php');
$t->data['dstMetadata'] = $state['Destination'];
$t->data['resumeFrom'] = $resumeFrom;
$t->data['aboutService'] = $aboutService;
$t->show();
