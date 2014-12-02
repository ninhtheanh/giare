<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('ask');

$id = abs(intval($_GET['id']));
Table::Delete('ask', $id);
Session::Set('notice', "Remove buy consultation({$id})Record Success");
redirect(udecode($_GET['r']));
