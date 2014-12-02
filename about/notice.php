<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'dealsoc_notice');
$pagetitle = $INI['system']['abbreviation'].' - Thông báo';
include template('about_notice');
