<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage session
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, based on session class by Stephan Schmidt, php design patterns, http://www.phpdesignpatterns.de/auflage-2/
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\session;

use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\session\SessionInterface;
use ch\keepitnative\formmailer\src\request\Request;
use ch\keepitnative\formmailer\src\request\HttpRequest;

ob_start();
require_once __DIR__ . '/SessionInterface.php';

/**
 * Class Session
 * @package ch\keepitnative\formmailer\src\session
 */
class Session implements SessionInterface
{
    /**
     * @var
     */
    protected static $instance;
    /**
     * @var array
     */
    private $values = [];
    /**
     * @var
     */
    private $sessionRegistry;

    public function startTheSession() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }
            } else {
                if (session_id() !== '') {
                    session_start();
                }
            }
        }
    }
    /**
     * @return bool
     */
    public static function isSessionStarted()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @param InputInterface $request
     * @param Response $response
     * @param null $key
     * @return Session
     */
    public static function getInstance(InputInterface &$input, $key = NULL)
    {

        if (!static::isSessionStarted()) {
            session_start();

        }
        if (is_null(self::$instance)) {
            self::$instance = new Session($input);
        }
        return self::$instance;

    }

    /**
     * @param InputInterface $request
     * @param Response $response
     * @param null $key
     */
    function __construct(InputInterface &$input, $key = NULL)
    {

    }

    /**
     *
     */
    function __clone()
    {
    }

    /**
     * @param $key
     * @param $value
     */
    function setUserdata($key, $value)
    {
        $_SESSION['__registry'][$key] = $value;
    }

    /**
     * @param $key
     * @return null
     */
    function getUserdata($key)
    {
        if (isset($_SESSION['__registry'][$key])) {
            return $_SESSION['__registry'][$key];
        }
        return null;
    }

    /**
     *
     */
    public static function regen()
    {
        session_regenerate_id(TRUE);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function setUserdatas($data = [])
    {
        //var_dump($data);Exit;
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                $_SESSION['__registry'][$key] = $value;
            }
            return true;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    public function issetParameter($key)
    {
        return isset($_SESSION['__registry'][$key]);
    }

    /**
     *
     */
    public function unsetAll()
    {
        if (count($_SESSION['__registry']) > 0) {
            foreach ($_SESSION['__registry'] as $key => $value) {
                $_SESSION['__registry'][$key] = NULL;
                unset($_SESSION['__registry'][$key]);
            }
            session_destroy();
        }
        //$this->sessionHandler->destroy(session_id());
    }
} 