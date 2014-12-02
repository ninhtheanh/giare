<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_contact');
$pagetitle = 'Liên hệ';
include template('about_contact');
