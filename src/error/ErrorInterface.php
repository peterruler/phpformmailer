<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage error
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\error;

/**
 * Interface ErrorInterface
 * @package ch\keepitnative\formmailer\src\error
 */
interface ErrorInterface
{
    /**
     *
     */
    function __construct();

    /**
     * @return array
     */
    public static function getErrors();

    /**
     * @param array $errors
     */
    public static function setErrors($errors);

    /**
     * @return array
     */
    public static function getMsg();

    /**
     * @param array $msg
     */
    public static function setMsg($msg);
}