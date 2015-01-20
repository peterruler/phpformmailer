<?php
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 17.01.15
*/
namespace ch\keepitnative\formmailer\src\logger\logger;

/**
 * Interface LoggerInterface
 * @package ch\keepitnative\formmailer\src\logger\logger
 */
interface LoggerInterface {
	/**
	 * @param $msg
	 * @param $ip
	 * @param string $level
	 * @param string $logDir
	 * @return mixed
	 */
	public function write($msg,$ip,$level='info',$logDir='');
}