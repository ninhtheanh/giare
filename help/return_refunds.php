<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'returns_refunds');
$pagetitle = 'Dealsoc FAQ Trả hàng & hoàn tiền';
include template('help_return_refunds');
