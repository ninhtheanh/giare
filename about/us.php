<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_us');
$pagetitle = 'Giới thiệu về ' . $INI['system']['abbreviation'];
include template('about_us');
