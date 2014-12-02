<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_privacy');
$pagetitle = 'Privacy statement';
include template('about_privacy');
