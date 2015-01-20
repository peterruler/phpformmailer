<?php
/**
 * Created by PhpStorm.
 * User: peterstrossler
 * Date: 20.01.15
 * Time: 13:46
 */

namespace ch\keepitnative\formmailer\src\logger\factories;


use ch\keepitnative\formmailer\src\logger\Registry;

/**
 * Class Logger
 * @package ch\keepitnative\formmailer\src\di\factories
 */
class Logger {
    /**
     * @var null
     */
    public $type = NULL;

    /**
     * @param null $type
     */
    public function __construct($type=NULL) {
        $this->init($type);
    }

    /**
     * @param null $type
     */
    public function __invoke($type=NULL) {
        $this->init($type);
    }

    /**
     * @param $type
     */
    protected function  init($type) {
        if(is_null($type)) {
            $registry = Registry::getInstance();
            $configuration = $registry->get('configuration');
            $type = $configuration['logger'];
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getLogger() {
        $loggerClass = 'ch\\keepitnative\\formmailer\\src\\logger\\logger\\'.$this->type;
        return new $loggerClass;
    }
} 