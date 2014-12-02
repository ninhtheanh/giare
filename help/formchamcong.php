<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'chamcong');
$pagetitle = "Cham cong Nhan vien ".$INI['system']['abbreviation'];
include template('chamcong');