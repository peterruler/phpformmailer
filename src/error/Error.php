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
ob_start();
require_once __DIR__ . '/ErrorInterface.php';
use ch\keepitnative\formmailer\src\di\Dependant;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\di\logger\Output;

/**
 * Class Error
 * @package ch\keepitnative\formmailer\src\error
 */
class Error implements ErrorInterface
{

	/**
     * @var array
     */
    public static $errors = [];
	/**
     * @var array
     */
    public static $msg = [];

	/**
     *
     */
    function __construct()
    {
    }

    /**
     * @return array
     */
    public static function getErrors()
    {
        if (count(static::$errors) > 0) {
            $err = '<p class="alert alert-danger" role="alert">';
            foreach (static::$errors as $error):
                $err .= '<span class="text-danger">' . $error . "</span><br />";
            endforeach;
            $err .= '<p>';
        } else {
            $err = '';
        }
        return $err;
    }

    /**
     * @param array $errors
     */
    public static function setErrors($errors)
    {
        static::$errors[] = $errors;
    }

    /**
     * @return array
     */
    public static function getMsg()
    {
        if (count(static::$msg) > 0) {
            $msg = '<p class="alert alert-success" role="alert">';
            foreach (static::$msg as $msg_txt):
                $msg .= '<span class="text-success">' . $msg_txt . "</span><br />";
            endforeach;
            $msg .= '<p>';
        } else {
            $msg = '';
        }
        return $msg;
    }

    /**
     * @param array $msg
     */
    public static function setMsg($msg)
    {

        static::$msg[] = $msg;
    }
} 