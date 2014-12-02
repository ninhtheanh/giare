<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'quydinhdoivoinguoimua');
$pagetitle = "Ưu đãi hấp dẫn - tặng coupon 200k".$INI['system']['abbreviation'];
include template('atcontent');