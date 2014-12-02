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

$q = DB::GetQueryResult("SELECT
ship_out.out_id AS Ma_BG,
ship_out.created AS Ngay_BG,
ship_out.shipper AS Ma_NV_GH,
ship_out.creator AS Ma_NV_BG,
ship_out_data.deal_id AS Ma_Voucher,
team.short_title AS Ten_Voucher,
team.team_price AS Don_Gia,
Sum(ship_out_data.quantity) AS SL,
Sum(ship_out_data.amount) AS Thanh_Tien,
sum(`order`.money) as Tien_KM, sum(`order`.credit) as Tien_Tra_Truoc
FROM ship_out
INNER JOIN ship_out_data ON ship_out_data.out_id = ship_out.out_id
INNER JOIN team ON ship_out_data.deal_id = team.id
INNER JOIN `order` ON ship_out_data.order_id = `order`.id WHERE ship_out_data.deal_id>=305 AND ship_out.out_id=".$id." GROUP BY ship_out_data.deal_id, order.team_id", false);

$content = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>technical</Author>
  <LastAuthor>technical</LastAuthor>
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
 <Worksheet ss:Name="eVietsoft">
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
    <Cell><Data ss:Type="String">Hướng dẫn sử dụng mẫu import excel:</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">1. Không xóa các dòng ẩn của mẫu biểu.</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">2. Không thêm/xóa các cột dữ liệu.</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">3. Chỉ sử dụng vùng màu vàng để nhập dữ liệu. Nếu thiếu dòng thì copy dòng trên xuống và xóa dữ liệu cũ đi để thay bằng dữ liệu mới.</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">4. Phải lưu biểu mẫu này dưới dạng file &quot;XML spreadsheet&quot; thì mới import được vào hệ thống.</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
    <Cell ss:StyleID="s63"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">5. Các cột dữ liệu kiểu số (số lượng, số tiền, …): phải định dạng kiểu dữ liệu là &quot;General&quot;, không đặt công thức tính toán mà phải nhập giá trị.</Data></Cell>
    <Cell ss:Index="16" ss:StyleID="s63"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
   </Row>
   <Row>
    <Cell ss:Index="2"><Data ss:Type="String">6. Tất cả các cột dữ liệu không thuộc kiểu số: phải định dạng kiểu dữ liệu là &quot;Text&quot;.</Data></Cell>
    <Cell ss:Index="16" ss:StyleID="s63"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
    <Cell ss:StyleID="s64"/>
   </Row>
   <Row ss:Index="10">
    <Cell ss:StyleID="s65"><Data ss:Type="String">STT</Data></Cell>
    <Cell ss:StyleID="s65"><Data ss:Type="String">Mã bàn giao</Data></Cell>
    <Cell ss:StyleID="s65"><Data ss:Type="String">Ngày bàn giao</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Mã NV giao hàng</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Mã NV bàn giao </Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Mã Voucher</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Tên Voucher</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Đơn vị tính</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Số lượng</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Đơn giá</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Tiền khuyến mãi</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Tiền trả trước</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Thành tiền</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="16.5" ss:Hidden="1" ss:StyleID="s69">
    <Cell ss:StyleID="s70"><Data ss:Type="String">STT</Data></Cell>
    <Cell ss:StyleID="s71"><Data ss:Type="String">ID1</Data></Cell>
    <Cell ss:StyleID="s71"><Data ss:Type="String">DateCreate</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">EmpID1</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">EmpID2</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">ProdID</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">ProdName</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">UnitID</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">Qty</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">Price</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">AmountPromotion</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">AmountPayment</Data></Cell>
    <Cell ss:StyleID="s72"><Data ss:Type="String">Amount</Data></Cell>
   </Row>';


for($i=0;$i<count($q);$i++){
	/*$qq = DB::GetQueryResult("SELECT sum(money) as Tien_KM, sum(credit) as Tien_Tra_Truoc FROM `order` WHERE ship_id=".$q[$i]['ma_bg']." GROUP BY team_id");*/

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
     <ActiveRow>10</ActiveRow>
     <ActiveCol>3</ActiveCol>
     <RangeSelection>R11</RangeSelection>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>';
header("Content-type: text/xml; charset=utf-8");
header("Content-Disposition: attachment; filename=Download_".$id.".xml");
header("Pragma: no-cache");
header("Expires: 0");
$aa = DB::GetQueryResult("UPDATE `ship_out` SET exported='Y' WHERE out_id=".$id);
print "{$content}";		
exit();