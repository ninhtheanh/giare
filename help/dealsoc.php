<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_dealsoc');
$pagetitle = "Giới thiệu ".$INI['system']['abbreviation'];
include template('help_dealsoc');