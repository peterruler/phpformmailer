<?php
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 17.01.15
*/
namespace ch\keepitnative\formmailer\src\logger\logger;

use ch\keepitnative\formmailer\src\logger\logger\LoggerInterface;

/**
 * Class LogToFile
 * @package ch\keepitnative\formmailer\src\logger\logger
 */
class LogToFile implements LoggerInterface {

	/**
	 * @param $msg
	 * @param $ip
	 * @param string $level
	 * @param string $logDir
	 */
	public function write($msg,$ip,$level = 'info',$logDir='') {

		$messageType = 3;
		$extraHeaders='';

		if(is_array($msg)) {
			$msg = (string) implode("\n",$msg);
		}

		$dateTime = new \DateTime();
		$timeStamp = $dateTime->format('H-m-d-h-i-s');
		$destination = $logDir.'/'.'error_log_'.$timeStamp.'.log';

		$message = $level.':'."\n".'IP Address: ['.$ip."]\n".$msg."\n".'['.date('Y-m-d H:i:s').']';

		error_log($message,$messageType,$destination,$extraHeaders);
	}

}