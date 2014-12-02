<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
need_manager();
need_auth('order');
$condition = array(
	/*"state IN ('delivered')",
	"team_id NOT IN ('22', '23', '25', '26', '15', '19', '24') AND id NOT IN (8956,8801,8729,8708,10141,7747,7744,7339,5669)",*/
	"id IN (6510,6024,8766,6007,5655,5606,6155,6490,6183,6337,7182,7987,7611,7962,7939,8160,7293,5665,7422,7630,7654,7981,7459,7239,7288,8247,7658,8164,8849,7355,7636,7665,7668,7274,7628,7656,7605,7285,7620,7365,7368,6527,7359,7660,7331,7537,7466,7599,7671,7540,6427,7419,7482,7503,7567,7586,7613,7640,7644,7651,7684,7740,7743,7871,7913,8008,8037,8045,8097,8122,8141,8150,8169,8177,8186,8212,8227,8239,8262,8268,8290,8309,8327,8337,8399,8452,8457,8489,8490,8514,8564,8591,8596,8631,8635,8650,8673,8762,8781,8799,6642,7372,7382,7389,7506,7512,7579,7627,7631,7643,7661,7680,7736,7760,7874,7954,7984,8068,8070,8071,8079,8158,8162,8173,8200,8210,8236,8255,8272,8277,8284,8313,8320,8368,8373,8406,8408,8424,8431,8443,8493,8511,8523,8567,8647,8651,8749,8756,8822,8833,6058,6269,6274,6279,6281,6310,6335,6344,6346,6375,6386,6399,6422,6451,6506,6512,6579,7043,7157,7261,7301,7531,7558,7667,7749,7807,7938,8142,8187,8197,8211,8226,8243,8303,8349,8354,8365,8544,8548,8583,8590,8593,8605,8620,8629,8655,8718,8722,8814,8816,5629,5658,5929,5962,6315,6474,6487,6500,6501,6504,6526,6563,6591,6592,6595,7025,7132,7223,7270,7423,7546,7629,7646,7648,7649,7669,7679,7784,7786,7861,7865,7890,7911,7925,8035,8036,8093,8146,8204,8208,8244,8301,8366,8370,8659,8693,8708,8725,8729,8801,5465,5533,5575,5634,5814,5823,6382,7330,7392,7410,7471,7538,7607,7609,7614,7619,7645,7657,7662,7689,7712,7792,7815,7828,7846,7858,7866,7867,7889,7892,7918,7934,7995,8055,8163,8231,8256,8281,8351,8357,8376,8458,8482,8537,8560,8606,8642,8644,8717,8850,6429,7262,7280,7320,7336,7412,7462,7464,7486,7544,7550,7576,7590,7625,7672,7776,7777,7796,7821,7837,7905,7914,7949,7965,7970,7979,8083,8086,8136,8175,8189,8253,8328,8344,8387,8423,8455,8469,8486,8584,8588,8619,8712,8721,8759,8776,8812,8825,8834,8847,5947,6146,6233,6434,6436,6541,7147,7443,7465,7681,7705,7719,7722,7781,7811,7849,7854,7899,7903,7924,7931,7943,7947,7991,7997,8027,8056,8096,8112,8116,8128,8221,8229,8254,8336,8384,8421,8422,8496,8521,8524,8526,8557,8600,8704,8727,8734,8797,8806,8838,5762,5849,6213,6366,6484,6499,6582,7209,7267,7278,7300,7319,7325,7326,7384,7431,7447,7468,7474,7511,7516,7578,7623,7653,7670,7766,7810,7836,7902,8024,8098,8167,8183,8193,8216,8371,8383,8395,8405,8417,8429,8447,8470,8565,8602,8703,8709,8728,8754,8780,5356,5563,6287,7341,7430,7561,7568,7577,7597,7610,7618,7676,7683,7697,7717,7723,7725,7733,7755,7761,7764,7767,7768,7794,7812,7813,7822,7831,7851,7864,7870,7955,7957,7998,8005,8015,8039,8103,8129,8190,8307,8352,8410,8432,8497,8572,8574,8677,8697,8707,6597,6613,6719,6965,7213,7254,7289,7305,7313,7473,7598,7624,8656,8680,8699)",
);
/*$ids = "6510,6024,8766,6007,5655,5606,6155,6490,6183,6337,7182,7987,7611,7962,7939,8160,7293,5665,7422,7630,7654,7981,7459,7239,7288,8247,7658,8164,8849,7355,7636,7665,7668,7274,7628,7656,7605,7285,7620,7365,7368,6527,7359,7660,7331,7537,7466,7599,7671,7540,6427,7419,7482,7503,7567,7586,7613,7640,7644,7651,7684,7740,7743,7871,7913,8008,8037,8045,8097,8122,8141,8150,8169,8177,8186,8212,8227,8239,8262,8268,8290,8309,8327,8337,8399,8452,8457,8489,8490,8514,8564,8591,8596,8631,8635,8650,8673,8762,8781,8799,6642,7372,7382,7389,7506,7512,7579,7627,7631,7643,7661,7680,7736,7760,7874,7954,7984,8068,8070,8071,8079,8158,8162,8173,8200,8210,8236,8255,8272,8277,8284,8313,8320,8368,8373,8406,8408,8424,8431,8443,8493,8511,8523,8567,8647,8651,8749,8756,8822,8833,6058,6269,6274,6279,6281,6310,6335,6344,6346,6375,6386,6399,6422,6451,6506,6512,6579,7043,7157,7261,7301,7531,7558,7667,7749,7807,7938,8142,8187,8197,8211,8226,8243,8303,8349,8354,8365,8544,8548,8583,8590,8593,8605,8620,8629,8655,8718,8722,8814,8816,5629,5658,5929,5962,6315,6474,6487,6500,6501,6504,6526,6563,6591,6592,6595,7025,7132,7223,7270,7423,7546,7629,7646,7648,7649,7669,7679,7784,7786,7861,7865,7890,7911,7925,8035,8036,8093,8146,8204,8208,8244,8301,8366,8370,8659,8693,8708,8725,8729,8801,5465,5533,5575,5634,5814,5823,6382,7330,7392,7410,7471,7538,7607,7609,7614,7619,7645,7657,7662,7689,7712,7792,7815,7828,7846,7858,7866,7867,7889,7892,7918,7934,7995,8055,8163,8231,8256,8281,8351,8357,8376,8458,8482,8537,8560,8606,8642,8644,8717,8850,6429,7262,7280,7320,7336,7412,7462,7464,7486,7544,7550,7576,7590,7625,7672,7776,7777,7796,7821,7837,7905,7914,7949,7965,7970,7979,8083,8086,8136,8175,8189,8253,8328,8344,8387,8423,8455,8469,8486,8584,8588,8619,8712,8721,8759,8776,8812,8825,8834,8847,5947,6146,6233,6434,6436,6541,7147,7443,7465,7681,7705,7719,7722,7781,7811,7849,7854,7899,7903,7924,7931,7943,7947,7991,7997,8027,8056,8096,8112,8116,8128,8221,8229,8254,8336,8384,8421,8422,8496,8521,8524,8526,8557,8600,8704,8727,8734,8797,8806,8838,5762,5849,6213,6366,6484,6499,6582,7209,7267,7278,7300,7319,7325,7326,7384,7431,7447,7468,7474,7511,7516,7578,7623,7653,7670,7766,7810,7836,7902,8024,8098,8167,8183,8193,8216,8371,8383,8395,8405,8417,8429,8447,8470,8565,8602,8703,8709,8728,8754,8780,5356,5563,6287,7341,7430,7561,7568,7577,7597,7610,7618,7676,7683,7697,7717,7723,7725,7733,7755,7761,7764,7767,7768,7794,7812,7813,7822,7831,7851,7864,7870,7955,7957,7998,8005,8015,8039,8103,8129,8190,8307,8352,8410,8432,8497,8572,8574,8677,8697,8707,6597,6613,6719,6965,7213,7254,7289,7305,7313,7473,7598,7624,8656,8680,8699";
$arr_id = explode(",",$ids);exit();
for($i=0; $i<count($arr_id); $i++){
	save_order_history($arr_id[$i],'delivered','CTY TNHH TM DV CITI');
}*/

/*Order Pending*/
/*$ids = "7890,7684,8754,7697,8083,7610,7300,8193,7938,7336,8749,7157,8307,7794,8313,8376,7597,6501,7846,8189,8309";
$arr_id = explode(",",$ids);
for($i=0; $i<count($arr_id); $i++){
	Table::UpdateCache('order', $arr_id[$i], array(
		'state' => 'pending',
		'notes' => '',
		'admin_id'=>$login_user_id,
	));
	save_order_history($arr_id[$i],'pending','');
}*/
/*End*/

/*Order Id Cancel*/
/*$ids ="8619,8423,7669,8725,8370,7786,8141,7459,8008,7796,7957,7733,8158,8631,8039,7567,8255,8255,8357,8200,8097,8281,7305,7899,7465,8588,8759,8584,8410,6490,8262,6451,8093,8490,8277,8762,8320,6579,7625,7649,7743,8799,6512,6506,7043,8112,8212,7326,7473,7289,7598,8424,8822,8079,6183,8833,7864,8244,7662,7285,7466,8812,7619,7672,7821,5655,7679,8129,8387,8727,8229,6642,5962,5929,7025,7132,8405,8183,8590,8470,8210,7681,8239,8327,8651,7611,6582,8801, 8703";
$arr_id = explode(",",$ids);
for($i=0; $i<count($arr_id); $i++){
	Table::UpdateCache('order', $arr_id[$i], array(
		'state' => 'canceled',
		'notes' => 'Hủy bởi khách hàng',
		'admin_id'=>$login_user_id,
	));
	save_order_history($arr_id[$i],'canceled','','Hủy bởi khách hàng');
}*/
/*End*/

$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY dist_id ASC'));

$user_ids = Utility::GetColumn($orders, 'user_id');
$users = Table::Fetch('user', $user_ids);

$team_ids = Utility::GetColumn($orders, 'team_id');
$teams = Table::Fetch('team', $team_ids);

/*$orders = DB::GetQueryResult("SELECT
`order`.id,
partner.title,
order.quantity,
order.origin,
district.dist_name
FROM `order`
LEFT JOIN team ON team.id = order.team_id
LEFT JOIN partner ON team.partner_id = partner.id
LEFT JOIN district ON district.dist_id = order.dist_id
WHERE `order`.`state` IN ('confirmed','pending') AND `team_id` NOT IN ('22', '23', '25', '26', '15', '19') order by dist_name ASC");*/

include template('manage_order_delivery_other_shipper_1');
?>