<?php
function leftMenuCategory($parent_id = 0){
	global $INI,$city;
	
	$categories = DB::LimitQuery('category', array(		
		'condition' => "display = 'Y' And zone = 'group' And parent = '$parent_id'",
		'order' => 'ORDER BY sort_order, name',
	));
	
	foreach($categories as $index=>$item)
	{
		$id = $item['id'];
		$name = $item['name'];
		//$icon_category = "/static/img/" . $item['icon_category'] . ".png";
		$icon_category = $item['icon_category'];
		$id_name = $item['id_name'];
		$parent = $item['parent']; 
		if( haveSubCategory($id) )
		{
			echo '<li class="parent">';	
				echo "<a href=\"" . "/tp-ho-chi-minh/" . $id_name . "\"><i class='icon' style='background: url({$icon_category}) no-repeat;'></i> " . $name . "</a>";
			echo '<ul class="submenu">';	
				leftMenuCategory($id);
			echo '</ul></li>';
		}
		else
		{
			echo "<li><a href=\"" . "/tp-ho-chi-minh/" . $id_name . "\"><i class='icon' style='background: url({$icon_category}) no-repeat;'></i> " . $name . "</a></li>";
		}		
	}
}
function haveSubCategory($id)
{
	$arrRows = DB::LimitQuery('category', array(		
		'condition' => "parent = '$id'",
	));	
	if(count($arrRows) > 0)
		return true;
		
	return false;
}
function at_current_top(){
	global $INI,$city;
	$a = array(
		"/tp-ho-chi-minh/ao-ao-khoac-nu/" => 'Áo – Áo khoác nữ',
		"/tp-ho-chi-minh/vay-dam-nu/" => 'Váy – Đầm nữ',
		"/tp-ho-chi-minh/do-the-thao-nam-nu/" => 'Đồ thể thao nam nữ',
		"/tp-ho-chi-minh/thoi-trang-nam/" => 'Thời trang nam',
		"/tp-ho-chi-minh/me-be/" => 'Mẹ - Bé',
		"/tp-ho-chi-minh/tui-xach-phu-kien/" => 'Túi xách – Phụ Kiện',
		"/tp-ho-chi-minh/suc-khoe-lam-dep/" => 'Sức khỏe _ Làm đẹp',
		"/tp-ho-chi-minh/gia-dung-cong-nghe/" => 'Gia dụng – công nghệ',
		"/tp-ho-chi-minh/hang-cao-cap/" => 'Hàng cao cấp',

/*"/{$city['slug']}/san-pham-khac/" => ' Sản phẩm khác', */
		/*'/blog/' => 'Blog',*/
	);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#lien-he#',$r)) $l = '/lien-he/';
	elseif (preg_match('#hoi-dap.html#',$r)) $l = '/hoi-dap.html';
        elseif (preg_match('#dealsoc-la-gi.html#',$r)) $l = '/hoi-dap.html';
        elseif (preg_match('#huong-dan-mua-hang.html#',$r)) $l = '/hoi-dap.html';
	elseif (preg_match('#subscribe#',$r)) $l = '/subscribe.php';
	else $l = '/';
	if(isset($_GET['gid'])){
		$l = "/{$city['slug']}/deal-du-lich/";
	}
	$icons = array(	'icon-dulich',
					'icon-giaitri',
					'icon-thoitrang',
					'icon-phukien',
					'icon-mebe',					
					'icon-suckhoe',
					'icon-giadung',
					'icon-congnghe',
					'icon-nhahang',
					);
	return at_current_link($l, $a, false, $icons);
}
function at_current_link($link, $links, $span=false,$icons=array()) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	$i=0;
	foreach($links AS $l=>$n) {		
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li class=\"current\"><a href=\"{$l}\"><i class='icon icon-mebe'></i> {$n}</a>{$span}</li>";
		}
		else $html .= "<li><a href=\"{$l}\"><i class='icon {$icons[$i]}'></i> {$n}</a>{$span}</li>";
		$i++;
	}
	return $html;
}

//---------------

function current_top(){
	global $INI,$city;
	$a = array(
		"/{$city['slug']}/" => 'Trang chủ',
		'/ve-cheapdeal.html'	=> 'Về Cheapdeal',
		'/huong-dan.html'	=> 'Hướng dẫn',
		'/nhan-uu-dai.html'	=> 'Nhận ưu đãi',
		/*'/blog/' => 'Blog',*/
	);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#lien-he#',$r)) $l = '/lien-he/';
	elseif (preg_match('#hoi-dap.html#',$r)) $l = '/hoi-dap.html';
        elseif (preg_match('#dealsoc-la-gi.html#',$r)) $l = '/hoi-dap.html';
        elseif (preg_match('#huong-dan-mua-hang.html#',$r)) $l = '/hoi-dap.html';
	elseif (preg_match('#subscribe#',$r)) $l = '/subscribe.php';
	else $l = '/';
	if(isset($_GET['gid'])){
		$l = "/{$city['slug']}/deal-du-lich/";
	}
	return current_link($l, $a);
}
function current_frontend() {
	global $INI,$city;	
	if($city['id']==11){
		$a = array(
			"/{$city['slug']}/" => 'Deal hôm nay',//{$city['slug']}/
			"/{$city['slug']}/deal-du-lich/" => 'Du lịch',
			//"/team/services.php" => 'Dịch vụ',
			"/{$city['slug']}/deal-dich-vu/" => 'Dịch vụ',
			//"/team/fashion.php" => 'Thời Trang-Mỹ Phẩm',
			"/{$city['slug']}/deal-thoi-trang-my-pham/" => 'Thời Trang-Mỹ Phẩm',
			//"/team/product.php" => 'Sản phẩm khác',
			"/{$city['slug']}/deal-san-pham-khac/" => 'Sản phẩm khác',
			/*"/{$city['slug']}/deal-ve-xe-tau-tet/" => 'Deal vé xe tết',*/
			"/{$city['slug']}/deal-gan-day/phieu-giam-gia-cuc-re-moi-ngay-trang1.html" => 'Deal đã bán',
		);
	}else{
		$a = array(
			"/{$city['slug']}/" => 'Deal hôm nay',
			"/{$city['slug']}/deal-du-lich/" => 'Du lịch',
			"/{$city['slug']}/deal-thoi-trang-my-pham/" => 'Thời Trang-Mỹ Phẩm',
			"/{$city['slug']}/deal-san-pham-khac/" => 'Sản phẩm khác',
			"/{$city['slug']}/deal-gan-day/phieu-giam-gia-cuc-re-moi-ngay-trang1.html" => 'Deal đã bán',
		);	
	}
	$r = $_SERVER['REQUEST_URI'];
	
	//if(preg_match("#/#", $r)) $l = "/";
	/*if (preg_match('#/deal/#',$r)) $l = '/team/index.php';
        else*/
	if(preg_match('#/team/resort.php#', $r)) $l = "/{$city['slug']}/deal-du-lich/";
	elseif(preg_match('#/team/transport.php#', $r)) $l = "/{$city['slug']}/deal-ve-xe-tau-tet/";
	elseif(preg_match('#/team/services.php#', $r)) $l = "/{$city['slug']}/deal-dich-vu/";
	elseif(preg_match('#/team/fashion.php#', $r)) $l = "/{$city['slug']}/deal-thoi-trang-my-pham/";
	elseif(preg_match('#/team/product.php#', $r)) $l = "/{$city['slug']}/deal-san-pham-khac/";
	elseif(preg_match('#/team/index.php#', $r)) $l = "/{$city['slug']}/deal-gan-day/phieu-giam-gia-cuc-re-moi-ngay-trang1.html";	
	//elseif(preg_match("#/#", $r)) $l = "{$city['slug']}";
	
	elseif (preg_match('#thao-luan#',$r)) $l = '/thao-luan/';
	elseif (preg_match('#hoi-dap.html#',$r)) $l = '/hoi-dap.html';
	elseif (preg_match('#dealsoc-la-gi.html#',$r)) $l = '/hoi-dap.html';
	elseif (preg_match('#huong-dan-mua-hang.html#',$r)) $l = '/hoi-dap.html';
	elseif (preg_match('#subscribe#',$r)) $l = '/subscribe.php';
	else $l = "/{$city['slug']}/";
	if(isset($_GET['gid'])){
		$l = "/{$city['slug']}/deal-du-lich/";
	}
	
	return current_link($l, $a, true);
}

function current_backend() {
	global $INI;
	if(intval($_SESSION['user_id'])!=1){
		$a = array(
			'/backend/misc/index.php' => 'Home',
			'/backend/team/index.php' => 'Deal',
			'/backend/order/index.php' => 'Order',
			/*'/backend/eorder/index.php' => 'E-Order',*/
			'/backend/shipping/ship_out.php' => 'Delivery',
			'/backend/logistics/index.php' => 'Payment-Shipping',
			'/backend/partner/index.php' => 'Partner',
			'/backend/system/page.php' => 'Setting', 
			'/backend/report/index.php' => 'Reports',
			'/backend/news/index.php' => 'News', 
		);
	}else{
		$a = array(
			'/backend/misc/index.php' => 'Home',
			'/backend/team/index.php' => 'Deal',
			'/backend/order/index.php' => 'Order',
			/*'/backend/eorder/index.php' => 'E-Order',*/
			'/backend/shipping/index.php' => 'Delivery',			
			'/backend/logistics/index.php' => 'Payment-Shipping',
			'/backend/coupon/index.php' => 'Voucher',
			'/backend/user/manager.php' => 'User',			
			'/backend/market/index.php' => 'Marketing',
			'/backend/category/index.php' => 'Category',			
			/*'/backend/vote/index.php' => 'Survey',*/
			'/backend/credit/index.php' => 'Credit',
			'/backend/system/index.php' => 'Setting',
			'/backend/tool/index.php' => 'Email Template',			
			'/backend/report/index.php' => 'Reports',
			'/backend/news/index.php' => 'News',
		); 
	}
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/backend/(\w+)/#',$r, $m)) {
		$l = "/backend/{$m[1]}/index.php";
	} else $l = '/backend/misc/index.php';
	return current_link($l, $a);
}

function current_biz() {
	global $INI;
	$a = array(
			'/biz/index.php' => 'Home',
			'/biz/settings.php' => 'Biz info',
			'/biz/coupon.php' => $INI['system']['couponname'] . 'list',
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/biz/coupon#',$r)) $l = '/biz/coupon.php';
	elseif (preg_match('#/biz/settings#',$r)) $l = '/biz/settings.php';
	else $l = '/biz/index.php';
	return current_link($l, $a);
}

function current_forum($selector='index') {
	global $city;
	$a = array(
			'/forum/index.php' => 'Tất cả',
			'/forum/city.php' => "Khu vực {$city['name']}",
			'/forum/public.php' => 'Thảo luận chung',
			);
	if (!$city) unset($a['/forum/city.php']);
	$l = "/forum/{$selector}.php";
	return current_link($l, $a, true);
}

function current_invite($selector='refer') {
	$a = array(
			'/account/refer.php' => 'Tất cả',
			'/account/referpending.php' => "Chờ mua",
			'/account/referdone.php' => 'Đã thanh toán',
			);
	$l = "/account/{$selector}.php";
	return current_link($l, $a, true);
}

function current_partner($gid='0') {
	$a = array(
			'/partner/index.php' => 'All',
			);
	foreach(option_category('partner') AS $id=>$name) {
		$a["/partner/index.php?gid={$id}"] = $name;
	}
	$l = "/partner/index.php?gid={$gid}";
	if (!$gid) $l = "/partner/index.php";
	return current_link($l, $a, true);
}
/*
function current_city($cename, $citys) {
	$link = "/city.php?ename={$cename}";
	$links = array();
	foreach($citys AS $city) {
		$links["/city.php?ename={$city['ename']}"] = $city['name'];
	}
	return current_link($link, $links);
}
*/
function current_city($id, $citys) {
	$link = "city.php?id={$id}";
	$links = array();
	foreach($citys AS $city) {
		//$links["/{$city['slug']}/"] = $city['name'];
		$links["/city.php?id={$city['id']}"] = $city['name'];
	}
	return current_link($link, $links);
}

function current_coupon_sub($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/coupon/index.php' => 'Còn giá trị',
		'/coupon/consume.php' => 'Đã sử dụng',
		'/coupon/expire.php' => 'Đã hết hạn',
	);
	$l = "/coupon/{$selector}.php";
	return current_link($l, $a);
}

function current_account($selector='/account/settings.php') {
	global $INI,$login_user;	
	$a = array(
		'/coupon/index.php' => 'Phiếu giảm giá',
		'/account/settings.php' => '&nbsp;Thông tin',
		'/order/index.php' => '&nbsp;Đơn hàng',			
		'/credit/index.php' => 'Số dư',
		'/account/myask.php' => 'Hỏi đáp',
		'/account/refer.php' => '&nbsp;Mời bạn bè',
	);
	
	if($login_user['is_aff']==1)
	{
		$a['/account/aff.php'] = 'Affiliate - Widget';
	}	
		
	if (option_yes('usercredit')) {
		$a['/credit/score.php'] = 'Điểm thưởng';
	}
	return current_link($selector, $a, true);
}

function current_about($selector='ve-chung-toi') {
	global $INI;
	$a = array(
		'/ve-chung-toi.html' => '&nbsp;Về chúng tôi',
		'/lien-he.html' => '&nbsp;Liên hệ',
		'/dieu-khoan-su-dung.html' => '&nbsp;Điều khoản sử dụng',
		'/tuyen-dung.html' => '&nbsp;Tuyển dụng',
		/*'/about/privacy.php' => 'Chính sách',*/
	);
	$l = "/{$selector}.html";
	return current_link($l, $a, true);
}

function current_help($selector='hoi-dap.html') {
	global $INI,$url_suffix;
	$a = array(
		'/dealsoc-la-gi.html' => "&nbsp;Về".$INI['system']['abbreviation'],
		'/hoi-dap.html' => '&nbsp;Hỏi đáp',
		'tra-hang-va-hoan-tien.html' => '&nbsp;Trả hàng & hoàn tiền',
		'/huong-dan-mua-hang.html' => '&nbsp;HD mua hàng',
		'/dieu-khoan-su-dung.html' => '&nbsp;Điều khoản sử dụng',
		'/tuyen-dung.html' => '&nbsp;Tuyển dụng',
		'/hop-tac-kinh-doanh.html' => '&nbsp;Hợp tác kinh doanh',
		'/thong-bao.html' => '&nbsp;Thông báo',
	);
	$l = "/{$selector}.html";
	return current_link($l, $a, true);
}

function current_order_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/order/index.php?s=index' => 'Tất cả',
		'/order/index.php?s=unpay' => 'Chưa thanh toán',
		'/order/index.php?s=pay' => 'Đã thanh toán',
	);
	$l = "/order/index.php?s={$selector}";
	return current_link($l, $a);
}

function current_credit_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/credit/score.php' => 'Điểm thưởng',
		'/credit/goods.php' => 'Đổi điểm thưởng',
	);
	$l = "/credit/{$selector}.php";
	return current_link($l, $a);
}

function current_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {		
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
		}
		else $html .= "<li><a href=\"{$l}\">{$n}</a>{$span}</li>";
	}
	return $html;
}
/* manage current */
function mcurrent_misc($selector=null) {
	if( abs(intval($_SESSION['user_id'])) == 780){
		$a = array(
		'/backend/misc/index.php' => '&nbsp;Home',
		'/backend/misc/forum.php' => '&nbsp;Forum',
		'/backend/misc/ask.php' => '&nbsp;Q & A',
		'/backend/misc/feedback.php' => '&nbsp;Feedback',
		);
	}else{
		$a = array(
			'/backend/misc/index.php' => '&nbsp;Home',
			'/backend/misc/ask.php' => '&nbsp;Q & A',
			'/backend/misc/forum.php' => '&nbsp;Forum',
			'/backend/misc/feedback.php' => '&nbsp;Feedback',
			/*'/backend/misc/subscribe.php' => '&nbsp;Email',
			'/backend/misc/smssubscribe.php' => '&nbsp;SMS',
			'/backend/misc/invite.php' => '&nbsp;Invitation Rebate',
			'/backend/misc/aff.php' => 'Affiliate Rebate',
			'/backend/misc/money.php' => 'Finance',
			'/backend/misc/link.php' => '&nbsp;Friend link',
			'/backend/misc/backup.php' => '&nbsp;Backup',*/
		);
	}
	$l = "/backend/misc/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_misc_money($selector=null){
	$selector = $selector ? $selector : 'store';
	$a = array(
		'/backend/misc/money.php?s=store' => 'Offline topup',
		'/backend/misc/money.php?s=charge' => 'Online topup',
		'/backend/misc/money.php?s=withdraw' => 'Withdraw records',
		'/backend/misc/money.php?s=cash' => 'Pay in cach',
		'/backend/misc/money.php?s=refund' => 'Refund records',
	);
	$l = "/backend/misc/money.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_backup($selector=null){
	$selector = $selector ? $selector : 'backup';
	$a = array(
		'/backend/misc/backup.php' => 'Database backup',
		'/backend/misc/restore.php' => 'Database restore',
	);
	$l = "/backend/misc/{$selector}.php";
	return current_link($l, $a);
}

function mcurrent_misc_invite($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/backend/misc/invite.php?s=index' => 'Pendings',
		'/backend/misc/invite.php?s=record' => 'Approved',
		'/backend/misc/invite.php?s=cancel' => 'Fouls',
	);
	$l = "/backend/misc/invite.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_aff($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/backend/misc/aff.php?s=index' => 'Tất cả',
		'/backend/misc/aff.php?s=pending' => 'Chờ T.toán',
		'/backend/misc/aff.php?s=record' => 'Đã T.toán',
		'/backend/misc/aff.php?s=cancel' => 'Hủy',
		'/backend/misc/aff.php?s=faul' => 'Chưa hoàn tất',
	);
	$l = "/backend/misc/aff.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_aff_front($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/account/aff.php?s=index' => 'Tất cả',
		'/account/aff.php?s=pending' => 'Chờ T.toán',
		'/account/aff.php?s=record' => 'Đã T.toán',
		'/account/aff.php?s=cancel' => 'Hủy',
		'/account/aff.php?s=faul' => 'Chưa hoàn tất',
	);
	$l = "/account/aff.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_order($selector=null) {
	global $city;
	if($city['id']==11){
		$a = array(
			'/backend/order/index.php' => '&nbsp;Mới đặt',		
			'/backend/order/unpay.php' => '&nbsp;Chưa XN',
			'/backend/order/prepaid.php' => '&nbsp;Trả tiền trước',
			'/backend/order/office.php' => '&nbsp;VP - Tạm Hoãn',
			'/backend/order/confirmed.php' => '&nbsp;Đã xác nhận',
			'/backend/order/delivery.php' => '&nbsp;Đã bàn giao',
			'/backend/order/pay.php' => '&nbsp;Đã thanh toán',
			/*'/backend/order/credit.php' => 'Pay with balance',*/
			'/backend/order/canceled.php' => '&nbsp;Đã Hủy',
			/*'/backend/order/warning.php' => 'Cảnh báo',*/
			'/backend/order/history.php' => '&nbsp;Lịch sử ĐH',
			'/backend/order/search.php' => '&nbsp;Tất cả ĐH',
			
		);
		$l = "/backend/order/{$selector}.php";
	}else{
		$a = array(
			'/backend/order/index.php?city_id=556' => '&nbsp;Mới đặt',		
			'/backend/order/prepaid.php?city_id=556' => '&nbsp;Đã update',
			'/backend/order/confirmed.php?city_id=556' => '&nbsp;Xác nhận',
			
			'/backend/order/datratien.php?city_id=556' => 'Đã trả tiền',
			'/backend/order/pay.php?city_id=556' => 'Đã thành công',
			'/backend/order/printorderconfirmed.php?city_id=556' => '&nbsp;In DS lấy hàng',
			'/backend/order/printorderproduct.php?city_id=556' => '&nbsp;Đã In DS lấy hàng',
			'/backend/order/printorderpacking.php?city_id=556' => '&nbsp;In ĐH đóng gói',
			'/backend/order/scanpackage.php?city_id=556' => 'In nhãn',
			'/backend/order/printtranferreport.php?city_id=556' => '&nbsp;In BBBG',
			'/backend/order/canceled.php?city_id=556' => '&nbsp;Đã Hủy',
			
			/* '/backend/order/history.php?city_id=556' => '&nbsp;Lịch sử ĐH', */
			'/backend/order/search.php?city_id=556' => '&nbsp;Tất cả',
			
		);
		$l = "/backend/order/{$selector}.php?city_id=556";
	}
	//$l = "/backend/order/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_eorder($selector=null) {
	$a = array(		
		'/backend/eorder/index.php' => '&nbsp;Mới đặt',		
		'/backend/eorder/unpay.php' => '&nbsp;Chưa xác nhận',
		'/backend/eorder/office.php' => '&nbsp;Tạm Hoãn',
		'/backend/eorder/confirmed.php' => '&nbsp;Đã xác nhận',
		'/backend/eorder/delivery.php' => '&nbsp;Đã bàn giao',
		'/backend/eorder/pay.php' => '&nbsp;Đã thanh toán',
		'/backend/order/credit.php' => 'Pay with balance',		
		'/backend/eorder/canceled.php' => '&nbsp;Đã Hủy',
		'/backend/order/warning.php' => 'Cảnh báo',
		'/backend/eorder/history.php' => '&nbsp;Lịch sử ĐH',
		'/backend/eorder/search.php' => '&nbsp;Tất cả ĐH',
		'/backend/eorder/prepaid.php' => '&nbsp;T.toán trước',		
		
	);
	$l = "/backend/eorder/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_logistics($selector=null) {
	$a = array(
		'/backend/logistics/index.php' => '&nbsp;Logistics',
	);
	$l = "/backend/logistics/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_shipping($selector=null) {
	$a = array(
		'/backend/shipping/index.php' => '&nbsp;X.N nộp tiền',	
		'/backend/shipping/ship_out.php' => '&nbsp;B.B bàn giao',
		'/backend/shipping/ship_in.php' => '&nbsp;B.K chưa nộp tiền',
		'/backend/shipping/export_ship_in.php' => '&nbsp;B.K đã nộp tiền',
		'/backend/shipping/ship_out_history.php' => '&nbsp;Lịch sử bàn giao',
		'/backend/shipping/ship_in_history.php' => '&nbsp;Lịch sử nộp tiền',
		'/backend/shipping/report.php' => '&nbsp;Tổng hợp',
	);
	$l = "/backend/shipping/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_tool($selector=null) {
	$a = array(
		'/backend/tool/index.php' => 'Email Template',			
	);
	$l = "/backend/tool/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_report($selector=null) {
	$a = array(
		'/backend/report/index.php' => 'Statitics',			
		//'/backend/report/sales_amount.php' => 'Sales Amount',	
		'/backend/report/sales_number.php' => 'Sales Number',	
		'/backend/report/orders.php' => 'by Order',	
		'/backend/report/deals.php' => 'by Deal',		
		'/backend/report/sale_report.php' => 'by Sale',		
		//'/backend/report/deliveryman.php' => 'by Delivery Man',		
		//'/backend/report/metrics.php' => 'Metrics',		
				
	);
	$l = "/backend/report/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_user($selector=null) {
	$a = array(
		'/backend/user/index.php' => 'User list',
		'/backend/user/manager.php' => 'Manager list',
		'/backend/partner/index.php' => 'Biz list',
		'/backend/partner/create.php' => 'New biz',
	);
	$l = "/backend/user/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_shipper($selector=null) {
	$a = array(
		'/backend/logistics/payment.php' => '&nbsp;Payment',		
		'/backend/logistics/transport.php' => 'Shipping',
		'/backend/logistics/index.php' => '&nbsp;Deliveryman',
		'/backend/logistics/create.php' => '&nbsp;Thêm mới NV GH',
	);
	$l = "/backend/logistics/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_team($selector=null) {
	$a = array(
		'/backend/team/index.php' => '&nbsp;Today deal',
		'/backend/team/success.php' => '&nbsp;Successful deal',
		'/backend/team/failure.php' => '&nbsp;Unsuccessful deal',
		'/backend/team/OnOff.php' => '&nbsp;On/Off deal',
		'/backend/team/show_homepage.php' => '&nbsp;Show homepage',
		'/backend/team/edit.php' => '&nbsp;New deal',
	);
	$l = "/backend/team/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_feedback($selector=null) {
	$a = array(
		'/backend/feedback/index.php' => 'Overview',
	);
	$l = "/backend/feedback/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_coupon($selector=null) {
	$a = array(
		'/backend/coupon/index.php' => '&nbsp;Usable',
		'/backend/coupon/consume.php' => '&nbsp;Used',
		'/backend/coupon/expire.php' => '&nbsp;Expired',
		'/backend/coupon/card.php' => '&nbsp;Coupon',
		'/backend/coupon/cardcreate.php' => '&nbsp;New coupon',
	);
	$l = "/backend/coupon/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_category($selector=null) {
	$zones = get_zones();
	$a = array();
	foreach( $zones AS $z=>$o ) {
		$a['/backend/category/index.php?zone='.$z] = $o;
	}
	$l = "/backend/category/index.php?zone={$selector}";
	return current_link($l,$a,true);
}
function mcurrent_partner($selector=null) {
	$a = array(
		'/backend/user/index.php' => '&nbsp;User list',
		'/backend/user/manager.php' => '&nbsp;Manager list',
		'/backend/partner/index.php' => '&nbsp;Biz list',
		'/backend/partner/create.php' => '&nbsp;New biz',
	);
	$l = "/backend/partner/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market($selector=null) {
	$a = array(
		'/backend/market/index.php' => '&nbsp;Email marketing',
		'/backend/market/sms.php' => '&nbsp;SMS group-sending',
		'/backend/market/down.php' => '&nbsp;Data download',
	);
	$l = "/backend/market/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market_down($selector=null) {
	$a = array(
		'/backend/market/down.php' => 'Mobile number',
		'/backend/market/downemail.php' => 'Email address',
		'/backend/market/downorder.php' => 'Deal order',
		'/backend/market/downcoupon.php' => 'Coupon',
		'/backend/market/downuser.php' => 'User info',
	);
	$l = "/backend/market/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_system($selector=null) {
	/*if( abs(intval($_SESSION['user_id'])) == 780){
		$a = array(
			'/backend/system/page.php' => 'Webpage',
		);
	}else*/{
		$a = array(
			'/backend/system/index.php' => '&nbsp;Basic',
			'/backend/system/option.php' => '&nbsp;Option',
			'/backend/system/bulletin.php' => '&nbsp;Bulletin',
			'/backend/system/pay.php' => '&nbsp;Pay',
			'/backend/system/email.php' => '&nbsp;Email',
			'/backend/system/sms.php' => '&nbsp;SMS',
			'/backend/system/page.php' => '&nbsp;Webpage',
			'/backend/system/cache.php' => '&nbsp;Cache',
			//'/backend/system/skin.php' => 'Skin',
			'/backend/system/template.php' => 'Template',
			//'/backend/system/upgrade.php' => 'Upgrade',
			'/backend/system/order_status.php' => '&nbsp;Order Status',
			'/backend/system/banner.php' => '&nbsp;Banner',
		);
	}
	$l = "/backend/system/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_credit($selector=null) {
	$a = array(
		'/backend/credit/index.php' => 'Credit records',
		'/backend/credit/settings.php' => 'Credit rules',
		'/backend/credit/goods.php' => 'Convert credits',
		//'/backend/credit/gift.php' => 'Gift credits',
	);
	$l = "/backend/credit/{$selector}.php";
	return current_link($l,$a,true);
}
function dealsoc_current_city($citys) {
	if(isset($citys['11'])) unset($citys['11']);
	$links = array();
	foreach($citys AS $city){
		$links["/{$city['slug']}/"] = $city['name'];
	}
    $html = '';
	foreach($links AS $l=>$n) {
        $html .= "<a href=\"{$l}\">{$n}</a>";
	}
	return $html;
}