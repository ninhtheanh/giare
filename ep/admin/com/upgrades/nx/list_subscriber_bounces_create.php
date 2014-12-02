<?php
/*
               -+=#*^  BAD  SYNTAX  ^*@#=+-
                   LEETWOLF + FLIPMODE!
              INTERSPIRE EMAIL MARKETER 6.0.0
*/

/**
* This file is part of the upgrade process.
*
* @package SendStudio
*/

/**
* Do a sanity check to make sure the upgrade api has been included.
*/
if (!class_exists('Upgrade_API', false)) {
	exit();
}

/**
* This class runs one change for the upgrade process.
* The Upgrade_API looks for a RunUpgrade method to call.
* That should return false for failure
* It should return true for success or if the change has already been made.
*
* @package SendStudio
*/
class list_subscriber_bounces_create extends Upgrade_API
{
	/**
	* RunUpgrade
	* Runs the query for the upgrade process
	* and returns the result from the query.
	* The calling function looks for a true or false result
	*
	* @return Mixed Returns true if the condition is already met (eg the column already exists).
	*  Returns false if the database query can't be run.
	*  Returns the resource from the query (which is then checked to be true).
	*/
	function RunUpgrade()
	{
		$query = 'create table ' . SENDSTUDIO_TABLEPREFIX . 'list_subscriber_bounces (
		  bounceid int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  subscriberid int(11) default NULL,
		  statid int(11) default NULL,
		  listid int(11) default NULL,
		  bouncetime int(11) default NULL,
		  bouncetype varchar(255) default NULL,
		  bouncerule varchar(255) default NULL,
		  bouncemessage text
		)';
		$result = $this->Db->Query($query);

		return $result;
	}
}
