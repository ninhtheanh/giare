<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_tour');
$pagetitle = 'Hướng dẫn mua hàng trên ' . $INI['system']['abbreviation'];
include template('help_tour');
