<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

$version = strval(SYS_VERSION);
$subversion = strval(SYS_SUBVERSION);
$action = strval($_GET['action']);

if ( 'db' == $action ) {
	$r = zuitu_upgrade($action, $version);
	Session::Set('notice', 'Structure of the database upgrade was successful, the database is already the newest version');
	redirect( WEB_ROOT . '/backend/system/upgrade.php' );
}
$version_meta = zuitu_version($version);
$newversion = $version_meta['version'];
$newsubversion = $version_meta['subversion'];
$software = $version_meta['software'];

$install = $version_meta['install'];
$patch = $version_meta['patch'];
$patchdesc = $version_meta['patchdesc'];
$upgrade = $version_meta['upgrade'];
$upgradedesc = $version_meta['upgradedesc'];

$isnew = ( $newversion==$version && $subversion == $newsubversion ) ;

include template('manage_system_upgrade');
