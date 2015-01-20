<?php
/**
 * Created by PhpStorm.
 * User: peterstrossler
 * Date: 20.01.15
 * Time: 12:58
 */

namespace ch\keepitnative\formmailer\src\config;


/**
 * Interface ConfigRegistryInterface
 * @package ch\keepitnative\formmailer\src\config
 */
interface ConfigRegistryInterface {
    /**
     * @return mixed
     */
    public static function getInstance();

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function set($field,$value);

    /**
     * @param $field
     * @return mixed
     */
    public function get($field);
} 