<?php
 define (__TRACE_ENABLED__, false);
 define (__DEBUG_ENABLED__, true);
 require("barcode.php");		   
 require("i25object.php");
 require("c39object.php");
 require("c128aobject.php");
 require("c128bobject.php");
 require("c128cobject.php");
/* Default value */
if (!isset($_GET['output']))  $output   = "png"; 
if (!isset($_GET['barcode'])){
	$barcode  = "0123456789";
}else{
	$barcode  = (int)$_GET['barcode'];
}
if (!isset($_GET['type']))    $type     = "I25";
if (!isset($_GET['width']))   $width    = "180";
if (!isset($_GET['height']))  $height   = "60";
if (!isset($_GET['xres']))    $xres     = "2";
if (!isset($_GET['font']))    $font     = "2";
/*********************************/ 
$barcode = str_repeat("0",10-strlen($barcode)).$barcode;
$drawtext		= 'on';
$stretchtext	= 'on';
if (isset($barcode) && strlen($barcode)>0) {    
  $style  = BCS_ALIGN_CENTER;					       
  $style |= ($output  == "png" ) ? BCS_IMAGE_PNG  : 0; 
  $style |= ($output  == "jpeg") ? BCS_IMAGE_JPEG : 0; 
  $style |= ($border  == "on"  ) ? BCS_BORDER 	  : 0; 
  $style |= ($drawtext== "on"  ) ? BCS_DRAW_TEXT  : 0; 
  $style |= ($stretchtext== "on" ) ? BCS_STRETCH_TEXT  : 0; 
  $style |= ($negative== "on"  ) ? BCS_REVERSE_COLOR  : 0; 
  switch ($type){

	case "I25":
			  $obj = new I25Object($width, $height, $style, $barcode);
			  break;
    case "C39":
			  $obj = new C39Object($width, $height, $style, $barcode);
			  break;
    case "C128A":
			  $obj = new C128AObject($width, $height, $style, $barcode);
			  break;
    case "C128B":
			  $obj = new C128BObject($width, $height, $style, $barcode);
			  break;
    case "C128C":
                          $obj = new C128CObject($width, $height, $style, $barcode);
			  break;
	default:
			$obj = false;
  }
  if ($obj) {
      $obj->SetFont($font);   
      $obj->DrawObject($xres);
  	  $obj->FlushObject();
  	  $obj->DestroyObject();
  	  unset($obj); 
  }
}else{
	echo $barcode."<br />".$style."<br />".$type."<br />".$xres."<br />".$font;
}

?>