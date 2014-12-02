<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_api');
$pagetitle = 'API';
include template('help_api');