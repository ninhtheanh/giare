<?php
require_once(dirname(__FILE__) . '/app.php');

/*!
 * upload demo for php
 * @requires xhEditor
 * 
 * @author Yanis.Wang<yanis.wang@gmail.com>
 * @site http://pirate9.com/
 * @licence LGPL(http://www.opensource.org/licenses/lgpl-license.php)
 * 
 * @Version: 0.9.2 build 100225
 * 
 * 
 */
header('Content-Type: text/html; charset=UTF-8');

function uploadfile($inputname)
{
	global $INI;
	$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;
	$attachdir='upload';//Upload file path, the end not to take/
	$dirtype=1;//1: 2 by day into the directory: monthly deposit directory 3: By extension memory storage directory recommended by the day
	$maxattachsize=2097152;//Maximum upload size, the default is 2M
	$upext='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//By extension
	$msgtype=2;// Return From the format parameter: 1, only the return url, 2, return parameter array
	
	$err = "";
	$msg = "";
	if(!isset($_FILES[$inputname]))return array('err'=>'Document domain name wrong, or did not select a file','msg'=>$msg);
	$upfile=$_FILES[$inputname];
	if(!empty($upfile['error']))
	{
		switch($upfile['error'])
		{
			case '1':
				$err = 'The file exceeds the upload_max_filesize value defined in php.ini';
				break;
			case '2':
				$err = 'HTML file size exceeds the value defined MAX_FILE_SIZE';
				break;
			case '3':
				$err = 'Incomplete upload';
				break;
			case '4':
				$err = 'No file upload';
				break;
			case '6':
				$err = 'Missing a temporary folder';
				break;
			case '7':
				$err = 'Failed to write file';
				break;
			case '8':
				$err = 'Upload interrupted by another extension';
				break;
			case '999':
			default:
				$err = 'Effective error-free code';
		}
	}
	elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = 'No file upload';
	else
	{
		$fileinfo=pathinfo($upfile['name']);
		$extension=strtolower($fileinfo['extension']);
		if(preg_match('/'.str_replace(',','|',$upext).'/i',$extension))
		{
			$filesize=$upfile['size'];
			if($filesize > $maxattachsize)$err='The file size exceeds'.$maxattachsize.'Byte';
			else
			{
				$year = date('Y');
				$day = date('md');
				$n = time().rand(1000,9999).'.jpg';
				$attach_dir = IMG_ROOT . "/team/{$year}/{$day}";
				RecursiveMkdir( IMG_ROOT . "/team/{$year}/{$day}" );
				$fname= time().rand(1000,9999).'.'.$extension;
				$target = $attach_dir.'/'.$fname;
				if ( is_resource($upfile['tmp_name']) ) {
					$data = fread($upfile['tmp_name'], $filesize);
					file_put_contents($target, $data);
					fclose($upfile['tmp_name']);
				} else {
					move_uploaded_file($upfile['tmp_name'],$target);
					@unlink($upfile['tmp_name']);
				}
				$target = $INI['system']['imgprefix']."/static/team/{$year}/{$day}/{$fname}";
				if($immediate=='1')$target='!'.$target;
				if($msgtype==1)$msg=$target;
				else $msg=array('url'=>$target,'localname'=>$upfile['name'],'id'=>'1');//idParameters fixed, only for demonstration, the actual project can be a database ID
			}
		}
		else $err='Upload file extensions must be as follows:'.$upext;

		if (is_resource($upfile['tmp_name'])) {fclose($upfile['tmp_name']);}
		else { @unlink($upfile['tmp_name']); }
	}
	return array('err'=>$err,'msg'=>$msg);
}

//HTML5 Upload
if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])) {
    if(preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)) {
        $temp_name = tmpfile();
		$content = file_get_contents("php://input");
		fwrite($temp_name, $content);
		fseek($temp_name, 0);
        $size = strlen($content);
        $_FILES[$info[1]]=array('name'=>$info[2],'tmp_name'=>$temp_name,'size'=>$size,'type'=> '','error'=>0); 
    }
}
//End HTML5 

$state=uploadfile('filedata');
echo json_encode($state);
