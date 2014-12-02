<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
import('backup');

need_manager();
need_auth('admin');

function _go_reload() {
	redirect( WEB_ROOT . '/backend/misc/restore.php' );
}

/* get tables */
$db_name = $INI['db']['name'];
$tables = DB::GetQueryResult("SHOW TABLE STATUS FROM `{$db_name}`", false);
/* end */

$backupdir = DIR_ROOT . '/data';
$handle = opendir($backupdir); $bs = array();
while ($file = readdir($handle)) {
    if(eregi("^[0-9]{8}[A-Z]{4}([0-9a-zA-Z_]+)(\.sql)$", $file))
        $bs[$file] = $file;
}
krsort($bs);
closedir($handle);

$action = strval($_REQUEST['action']);

if ($action=="restore") {
    if($_POST['restorefrom']=="server"){

		$serverfile = strval($_POST['serverfile']);
        if(!$serverfile) {
            Session::Set('error', "You chose to restore backup from server files, but you didn/'t specify the backup file.");
			_go_reload();
        }

        if(!eregi("_v[0-9]+", $serverfile)) {
            $filename = $backupdir . '/' . $serverfile;
            if( backup_import($filename)) {
               Session::Set('notice', "Backup file {$serverfile} was successfully imported to the database");
			}
            else {
                Session::Set('error', "Backup file {$serverfile} failed to be imported");
			}
			_go_reload();

        }else{
            $filename = $backupdir . '/' . $serverfile;
            if( true === backup_import($filename)) {
                Session::Set('notice', "{$serverfile} was imported to the database");
			}
            else {
                Session::Set('error', "{$serverfile} failed to be imported");
				_go_reload();
            }

            $voltmp = explode("_v",$serverfile);
            $volname = $voltmp[0];
            $volnum = explode(".sq",$voltmp[1]);
            $volnum = intval($volnum[0])+1;
            $nextfile = $volname."_v".$volnum.".sql";
            if(file_exists("{$backupdir}/{$nextfile}")){
                Session::Set('notice', "System will automatically import next section of the multiple volume backup in 3 seconds: file {$nextfile}");
                Session::Set('nextfile', $nextfile);
				_retore_script();
            }else{
                Session::Set('notice', "All of this volume backup has been  imported.");
            }

			_go_reload();
        }
    }

    if($_POST['restorefrom']=="localpc"){
        switch ($_FILES['myfile']['error']){
            case 1:
            case 2:
            $msgs = "Your file is bigger than the server upload limit. Upload failed.";
            break;
            case 3:
            $msgs = "Backup files uploaded from your computer is not complete";
            break;
            case 4:
            $msgs = "Uploading backup files from your computer failed.";
            break;
            case 0:
            break;
        }
        if($msgs){
			Session::Set('error', $msgs);
			_go_reload();
        }

		if ( true === backup_import($_FILES['myfile']['tmp_name'])) {
			Session::Set('notice', "Local backup file uploading succeeded.");
		}else {
			Session::Set('error', "Local backup file failed to be imported to the database.");
		}
		_go_reload();
	}

	if($_SESSION['nextfile']) {

		$serverfile = strval($_SESSION['nextfile']);
		$filename = $backupdir .'/' .$serverfile;
		if( true === backup_import($filename)) {
			Session::Set('notice', "{$serverfile} has been imported to the database");
		}
		else {
			Session::Set('error', "{$serverfile} failed to be imported");
			_go_reload();
		}

		$voltmp = explode("_v", $serverfile);
		$volname = $voltmp[0];
		$volnum = explode(".sq",$voltmp[1]);
		$volnum = intval($volnum[0])+1;
		$nextfile = $volname."_v".$volnum.".sql";
		if(file_exists("{$backupdir}/{$nextfile}")){
			Session::Set('notice', "System will automatically import next section of the multiple volume backup in 3 seconds：file {$nextfile}");
			Session::Set('nextfile', $nextfile);
			_retore_script();
		}else{
			Session::Set('notice', "The multiple vulume backup has all been imported.");
		}
		_go_reload();
	}
}

$show = array();
$show[] = "It will cover all the old date when restoring backup data.";
$show[] = "It can only restore data files imported by this system, and is not applicable for files imported by other softwares.";
$show[] = "The maximum size of data to be restored locally is 2M.";
$show[] = "If you use multiple volume backup, you need by hand import only the file volume 1.  Other data files will be imorted by the system.";

include template('manage_misc_restore');

function _retore_script() {
	$script = "<meta http-equiv='refresh' content='3; url=restore.php?action=restore' />" ;
	Session::Set('script', $script);
}
