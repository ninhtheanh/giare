<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 've-cheapdeal');
$pagetitle = "Giới thiệu ".$INI['system']['abbreviation'];
include template('atcontent');