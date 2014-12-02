<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_terms');
$pagetitle = 'Điều khoản sử dụng';
include template('about_terms');
