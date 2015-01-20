<?php
/**
 * Created by PhpStorm.
 * User: peterstrossler
 * Date: 20.01.15
 * Time: 12:34
 */

namespace ch\keepitnative\formmailer\src\logger;


/**
 * Class Registry
 * @package ch\keepitnative\formmailer\src\logger\
 */
class Registry {

    /**
     * @var array
     */
    private $config = [];

    /**
     * @return Registry
     */
    public static function getInstance() {
        static $instance;
        if(!isset($instance) && !is_object($instance)) {
            $instance = new Registry();
        }
        return $instance;
    }

    /**
     * @param $field
     * @param $value
     */
    public function set($field,$value) {
        $this->config[$field] = $value;
    }

    /**
     * @param $field
     * @return mixed
     * @throws Exception
     */
    public function get($field) {
        if(!isset($this->config[$field])) {
            throw new \Exception('unknown Attribute ' . $field);
        }
        return $this->config[$field];
    }
} 