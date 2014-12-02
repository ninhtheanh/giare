<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$idcontent = $_GET['idcontent'];
//DB::$mDebug=true;
//echo $idcontent;

$page = Table::Fetch('page', $idcontent);
$pagetitle = "Hợp tác với Cheap Deal".$INI['system']['abbreviation'];

include template('atcontent'); //include/compiled/atcontent.php