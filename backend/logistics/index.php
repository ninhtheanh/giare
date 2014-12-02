<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('logistics');

$like = strval($_GET['like']);
$fname = strval($_GET['fname']);

$condition = array();

/* filter */
if ($like) { 
	$condition[] = "shipper_tel like '%".mysql_escape_string($like)."%'";
}
if ($fname) {
	$condition[] = "shipper_name like '%".mysql_escape_string($fname)."%'";
}
/* end */

$count = Table::Count('shipper', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$shippers = DB::LimitQuery('shipper', array(
	'condition' => $condition,
	'order' => 'ORDER BY shipper_status ASC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('logistics/manage_shipper_index');
