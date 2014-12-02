<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_job');
$pagetitle = "Tuyển dụng";
include template('about_job');
