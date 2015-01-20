<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage input
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, originally by Matthew Machuga, matthewmachuga.com
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\input;
/**
 * Interface InputInterface
 * @package ch\keepitnative\formmailer\src\input
 */
/**
 * Interface InputInterface
 * @package ch\keepitnative\formmailer\src\input
 */
interface InputInterface {
    /**
     * @return mixed
     */
    public static function createFromGlobals();

    /**
     * @param array $inputs
     */
    public function __construct($inputs = []);

    /**
     * @param array $inputs
     * @return mixed
     */
    public function replace($inputs = []);

    /**
     * @param $key
     * @return mixed
     */
    public function post($key);

	/**
     * @param null $input
     * @return mixed
     */
    public static function filterInput($input=null);
}