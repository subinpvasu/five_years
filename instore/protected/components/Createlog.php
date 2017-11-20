<?php
/**
 * Create debug message for each day
 */
 
class Createlog
{
	
	public function create_log_msg( $log = '')
	{
		$status = 1; // 1 for on and 0 for off
		if($status == 1 && $log != '')
			file_put_contents($filename = Yii::getPathOfAlias('webroot').'/debug_log'.'/log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
	}
}