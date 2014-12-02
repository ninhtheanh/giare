<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$page = Table::Fetch('page', 'help_cooperation');
$pagetitle = "Hợp tác kinh doanh";
include template('help_cooperation');
