<?php
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 17.01.15
* https://www.video2brain.com/de/videotraining/power-workshops-php
*/
namespace ch\keepitnative\formmailer\src\di\logger;
use ch\keepitnative\formmailer\src\di\logger\LoggerInterface;

/**
 * Class Output
 * @package ch\keepitnative\formmailer\src\di\logger
 */
class Output implements LoggerInterface {
	/**
	 * @param $msg
	 * @param $ip
	 * @param string $level
	 * @param string $logDir
	 */
	public function write($msg,$ip,$level='info',$logDir='') {
		printf("%s: %s [%s]",$msg,$level,date('Y-m-d H:i:s').time());
	}
}