<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('shipping');
if($city['id']==440){
	$prefix = "HDN";	
}else{
	$prefix = "HDS";		
}
$id = abs(intval($_GET['out_id']));

$sql = "SELECT so.*, sd.* FROM ship_out AS so LEFT JOIN ship_out_data AS sd USING(out_id) WHERE so.out_id=".$id." ORDER BY street, dist_id, ward_id ASC, order_id DESC";
$rs = DB::GetQueryResult($sql,false);



$content = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>TranAnh</Author>
  <LastAuthor>trananh</LastAuthor>
  <Created>1996-10-14T23:33:28Z</Created>
  <LastSaved>2010-10-31T04:29:02Z</LastSaved>
  <Version>12.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <DownloadComponents/>
  <LocationOfComponents HRef="file:///F:\091010_ServerOld\F\Soft\OfficeXP\"/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>10365</WindowHeight>
  <WindowWidth>15420</WindowWidth>
  <WindowTopX>-60</WindowTopX>
  <WindowTopY>-1005</WindowTopY>
  <TabRatio>308</TabRatio>
  <RefModeR1C1/>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Arial"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s21">
      <Font ss:FontName="Arial" ss:Bold="1" />
   </Style>
  <Style ss:ID="s62">
   <NumberFormat/>
  </Style>
  <Style ss:ID="s63">
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s64">
   <NumberFormat ss:Format="Short Date"/>
  </Style>
  <Style ss:ID="s65">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#808080" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s66">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#808080" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s69">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s70">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#969696" ss:Pattern="Solid"/>
   <NumberFormat/>
  </Style>
  <Style ss:ID="s71">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#969696" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s72">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial" x:Family="Swiss" ss:Color="#FFFFFF"/>
   <Interior ss:Color="#969696" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s73">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#FFFF99" ss:Pattern="Solid"/>
   <NumberFormat/>
  </Style>
  <Style ss:ID="s74">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Arial"/>
   <Interior ss:Color="#FFFF99" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
  <Style ss:ID="s75">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Interior ss:Color="#FFFF99" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="@"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Phieu_de_nghi_chuyen_hang">
  <Table ss:ExpandedColumnCount="24" ss:ExpandedRowCount="38" x:FullColumns="1"
   x:FullRows="1">
   <Column ss:StyleID="s62" ss:AutoFitWidth="0" ss:Width="30.75"/>
   <Column ss:StyleID="s63" ss:AutoFitWidth="0" ss:Width="79.5"/>
   <Column ss:StyleID="s63" ss:AutoFitWidth="0" ss:Width="69.75"/>
   <Column ss:AutoFitWidth="0" ss:Width="118.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="96"/>
   <Column ss:AutoFitWidth="0" ss:Width="74.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="89.25" ss:Span="1"/>
   <Column ss:Index="9" ss:AutoFitWidth="0" ss:Width="72.75" ss:Span="4"/>
   <Column ss:Index="14" ss:AutoFitWidth="0" ss:Width="92.25" ss:Span="5"/>
   
   <Row>
    <Cell><Data ss:Type="String">CHEAPDEAL TP.HỒ CHÍ MINH</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell><Data ss:Type="String">137/5A Lê Văn Sỹ, P.13, Q.Phú Nhuận, Tp. HCM</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell><Data ss:Type="String">ĐT: 08 3991 4018</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row> 
   <Row>
    <Cell><Data ss:Type="String"  ss:StyleID="s21">Đơn hàng - Số: '.$rs[0]['out_id'].' Ngày:'.date("d/m/Y H:i:s", strtotime($rs[0]['created'])).'</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   
   
   <Row ss:Index="6">
    <Cell ss:StyleID="s65"><Data ss:Type="String">ĐH</Data></Cell>
    <Cell ss:StyleID="s65"><Data ss:Type="String">Mã Deal</Data></Cell>
    <Cell ss:StyleID="s65"><Data ss:Type="String">Tên Deal</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Họ tên</Data></Cell>
	<Cell ss:StyleID="s66"><Data ss:Type="String">Địa chỉ</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">ĐT</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">SL</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Số tiền</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Phí vận chuyển</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Ghi chú</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">PCN</Data></Cell>
   </Row>
   ';

/*$qq = DB::GetQueryResult("SELECT sum(money) as Tien_KM, sum(credit) as Tien_Tra_Truoc FROM `order` WHERE ship_id=".$q[$i]['ma_bg']." GROUP BY team_id");*/

/* 
for($i=0;$i<count($q);$i++){
	
	$content .=' <Row ss:AutoFitHeight="0" ss:Height="15">
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.($i+1).'</Data></Cell>
    <Cell ss:StyleID="s74"><Data ss:Type="String">'.$q[$i]['ma_bg'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">'.$q[$i]['ngay_bg'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">'.$q[$i]['ma_nv_gh'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">'.$q[$i]['ma_nv_bg'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">'.$prefix.$q[$i]['ma_voucher'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">'.$q[$i]['ten_voucher'].'</Data></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">1</Data></Cell>
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.$q[$i]['sl'].'</Data></Cell>
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.$q[$i]['don_gia'].'</Data></Cell>
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.$q[$i]['tien_km'].'</Data></Cell>
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.$q[$i]['tien_tra_truoc'].'</Data></Cell>
    <Cell ss:StyleID="s73"><Data ss:Type="Number">'.$q[$i]['thanh_tien'].'</Data></Cell>
   </Row>';
} */


$team_ids = Utility::GetColumn($rs, 'deal_id');
$teams = Table::Fetch('team', $team_ids);

$data = array();
if(is_array($rs)){
	foreach($rs AS $index=>$one) {
		$order_money = DB::GetQueryResult("SELECT money, notes, credit, shipping_cost, payment_cost FROM `order` WHERE id='".$one['order_id']."'", false);
		$arr = array();
		$arr['order_id'] = $one['order_id'];
		$arr['deal_id'] = $one['deal_id'];
		$arr['short_title'] = $teams[$one['deal_id']]['short_title'];
		$arr['cus_name'] = $one['cus_name'];
		$arr['note_address'] = $one['note_address'].' '.$one['cus_address'];
		$arr['cus_phone'] = $one['cus_phone'];
		$arr['quantity'] = $one['quantity'];
		$arr['amount'] = $one['amount'];
		$arr['shipping_cost'] = $order_money[0]['shipping_cost']+$order_money[0]['payment_cost'];
		$arr['cus_notes'] = cut_string($one['cus_notes'],100,"...").'-'.$order_money[0]['notes'];
		$arr['pcn']  = 'X';
		
		$data[] = $arr;
		
		/* $content .=' <Row ss:AutoFitHeight="0" ss:Height="15">
		<Cell ss:StyleID="s73"><Data ss:Type="Number">'.$one['order_id'].'</Data></Cell>
		<Cell ss:StyleID="s74"><Data ss:Type="String">'.$one['deal_id'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.$teams[$one['deal_id']]['short_title'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.$one['cus_name'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.$one['note_address'].' '.$one['cus_address'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.$one['cus_phone'].'</Data></Cell>
		<Cell ss:StyleID="s73"><Data ss:Type="Number">'.$one['quantity'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.$one['amount'].'</Data></Cell>
		<Cell ss:StyleID="s75"><Data ss:Type="String">'.($order_money[0]['shipping_cost']+$order_money[0]['payment_cost']).'</Data></Cell>
		<Cell ss:StyleID="s73"><Data ss:Type="String">'.cut_string($one['cus_notes'],100,"...").'-'.$order_money[0]['notes'].'</Data></Cell>
		<Cell ss:StyleID="s73"><Data ss:Type="String">x</Data></Cell>
	   </Row>'; */
		
	}
}

$content .= '</Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <TopRowVisible>6</TopRowVisible>
   <LeftColumnVisible>3</LeftColumnVisible>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>1</ActiveRow>
     <ActiveCol>1</ActiveCol>
     <RangeSelection>R11</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>';



/* header("Content-type: text/xls; charset=utf-8");
header("Content-Disposition: attachment; filename=Phieu_de_nghi_chuyen_hang_ma_".$id.".xls");
header("Pragma: no-cache");
header("Expires: 0");
print "{$content}";		
exit(); */

$kn = array(
		'order_id' => 'ĐH',
		'deal_id' => 'Mã Deal',
		'short_title' => 'Tên Deal',
		'cus_name' => 'Họ tên',
		'note_address' => 'Địa chỉ',
		'cus_phone' => 'ĐT',
		'quantity' => 'SL',
		'amount' => 'Số tiền',
		'shipping_cost' => 'Phí vận chuyển',
		'cus_notes' => 'Ghi chú',
		'pcn'=>'PCN',
		);

down_xls($data, $kn, 'Phieu_de_nghi_chuyen_hang_ma_'.$id);