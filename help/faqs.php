<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'help_faqs');
$pagetitle = 'Hỏi đáp';
include template('help_faqs');
