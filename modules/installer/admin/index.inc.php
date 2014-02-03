<?php
if(!defined('CC_DS')) die('Access Denied');
$module		= new Module(__FILE__, 'installer', 'admin/index.tpl');
$language	= $module->module_language();

##############################################################################

$allowedTypes = array(
	'language'	=> 'language',
	'modules' => array(
		'affiliate',
		'gateway',
		'installer',	# Yes, a self-installing, self-updating module. Clever shit, eh?
		'plugins',
		'shipping',
	),
	'skin' => 'skins',
);
$installer = new Installer();

if (isset($_POST['install'])) {
	## Install the files
	if ($installer->install()) {
		$main->setNotify($lang['settings']['notify_module_install']);
	} else {
		$main->setError($lang['settings']['error_module_install']);
	}
} else if (isset($_POST['upload'])) {
	## Read the package information, and display it on a confirmation screen
	if ($install = (array)$installer->prepare($language)) {
		$module->assign('MODULE', $install);
		if ($install['compatible']) {
			## Proceed, and set the text on the action button to reflect the correct action
			$module->assign('BUTTON', array('name' => 'install', 'value' => $language[$install['status']]));
			$module->parse('main.action');
		} else {
			## Not compatible with this CC version - Display error message
			$message	= sprintf($language['incompatible_version'], $install['name']);
		}
		$module->assign('message', sprintf($language[$install['status'].'_text'], $install['name'], $install['version'], $install['installed']));
		$module->parse('main.prepare');
		$module->parse('main.cancel');
	}
} else {
	$module->assign('BUTTON', array('name' => 'upload', 'value' => $language['upload']));
	$module->parse('main.action');
	$module->parse('main.form');
}

$module->parse('main');
$module->out('main');

?>