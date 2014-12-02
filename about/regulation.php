<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'dealsoc_regulation');
$pagetitle = 'Quy chế sàn giao dịch TMĐT Dealsoc';
include template('about_regulation');
