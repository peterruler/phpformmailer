<?php
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 17.01.15
* https://www.video2brain.com/de/videotraining/power-workshops-php
*/
namespace ch\keepitnative\formmailer\src\logger;
use ch\keepitnative\formmailer\src\logger\Registry as LoggerRegistry;
use ch\keepitnative\formmailer\src\logger\logger\LoggerInterface;
use ch\keepitnative\formmailer\src\logger\logger\LogToFile;

/**
 * Class Dependant
 * @package ch\keepitnative\formmailer\src\logger
 */
class Dependant {
	/**
	 * @var null
	 */
	private $logger=null;

	/**
	 * @param LoggerInterface $logger
	 */
	public function setLogger(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	/**
	 * @return LoggerInterface|LogToFile|null
	 */
	public function getLogger() {
		if(!$this->logger instanceof LoggerInterface) {
            $registry = LoggerRegistry::getInstance();
            $config = $registry->get('configuration');

            $loggerFactory = $registry->get('loggerFactory');
            $loggerFactory($config['logger']);
            //if(class_exists($loggerClass)) {
			    $this->logger = $loggerFactory->getLogger();
            //}
        }
		return $this->logger;
	}

	/**
	 * @param $msg
	 * @param $ip
	 * @param $level
	 * @param $logDir
	 */
	public function setMsg($msg,$ip,$level,$logDir) {
		$this->createLogDir($logDir);
		$logger = $this->getLogger();
		$logger->write($msg,$ip,$level,$logDir);
	}

	/**
	 * @param string $logDir
	 */
	public function createLogDir($logDir='') {
		if(!is_dir($logDir)) {
			@mkdir($logDir,'0777');
		}
	}
}