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
class user_permissions_change_list extends Upgrade_API
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
		/**
		** NOTE **
		* For all permissions, they are separate queries because a union will truncate the field length
		* to the smallest field.
		* So 'add' union 'edit' becomes 'add' and 'edi'.
		*/

		/**
		* Expand 'manage lists' permissions into 'create', 'edit', 'delete', 'bounce'.
		*/
		$query = 'insert into ' . SENDSTUDIO_TABLEPREFIX . 'user_permissions (userid, area, subarea)';
		$query .= ' SELECT AdminID, \'lists\', \'create\' FROM ' . SENDSTUDIO_TABLEPREFIX . 'allow_functions WHERE SectionID=2';

		$result = $this->Db->Query($query);
		$query = 'insert into ' . SENDSTUDIO_TABLEPREFIX . 'user_permissions (userid, area, subarea)';
		$query .= ' SELECT AdminID, \'lists\', \'delete\' FROM ' . SENDSTUDIO_TABLEPREFIX . 'allow_functions WHERE SectionID=2';

		$result = $this->Db->Query($query);
		$query = 'insert into ' . SENDSTUDIO_TABLEPREFIX . 'user_permissions (userid, area, subarea)';
		$query .= ' SELECT AdminID, \'lists\', \'edit\' FROM ' . SENDSTUDIO_TABLEPREFIX . 'allow_functions WHERE SectionID=2';

		$result = $this->Db->Query($query);
		$query = 'insert into ' . SENDSTUDIO_TABLEPREFIX . 'user_permissions (userid, area, subarea)';
		$query .= ' SELECT AdminID, \'lists\', \'bounce\' FROM ' . SENDSTUDIO_TABLEPREFIX . 'allow_functions WHERE SectionID=2';
		$result = $this->Db->Query($query);

		return $result;
	}
}
