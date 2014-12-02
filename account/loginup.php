<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$pagetitle = "Đăng ký hoặc Đăng nhập vào ".$INI["system"]["abbreviation"];
include template('account_loginup');