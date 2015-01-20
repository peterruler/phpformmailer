<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage csrf
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer\src\csrfprotection;

use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\session\SessionInterface;
use ch\keepitnative\formmailer\src\request\Request;

require_once __DIR__ . '/Csrf.php';

/**
 * Class CsrfProtection
 * @package ch\keepitnative\formmailer\src\csrfprotection
 */
class CsrfProtection
{

    /**
     * @var null
     */
    public static $instance = null;
    /**
     * @var null
     */
    public static $session = null;
    /**
     * @var null
     */
    public static $randomtoken = null;
    /**
     * @var null
     */
    public static $hash = null;

    /**
     * @var null
     */
    public static $input = null;

    /**
     * @param null $input
     */
    public static function setInput($input)
    {
        self::$input = $input;
    }

    /**
     * @return null
     */
    public static function getInput()
    {
        return self::$input;
    }

    /**
     * @param null $hash
     */
    public static function setHash($hash)
    {
        self::$hash = $hash;
    }

    /**
     * @return null
     */
    public static function getHash()
    {
        return self::$hash;
    }

    /**
     * @param null $randomtoken
     */
    public static function setRandomtoken($randomtoken)
    {
        self::$randomtoken = $randomtoken;
    }

    /**
     * @return null
     */
    public static function getRandomtoken()
    {
        return self::$randomtoken;
    }

    /**
     * @param null $session
     */
    public static function setSession($session)
    {
        self::$session = $session;
    }

    /**
     * @return null
     */
    public static function getSession()
    {
        return self::$session;
    }

    /**
     * @param SessionInterface $session
     * @param InputInterface $input
     * @param string $hash
     * @return null
     */
    public static function getInstance(SessionInterface $session = null, InputInterface $input = null, $hash = 'abc')
    {
        if (is_null(static::$instance)) {
            if (!is_null($session) && !is_null($input) && $hash != '') {
                static::$instance = new static($session, $input, $hash);
            }
        }
        return static::$instance;
    }

    /**
     * dummy method singleton
     */
    private function __clone()
    {
    }

    /**
     * @param SessionInterface $session
     * @param InputInterface $input
     * @param null $hash
     */
    public function __construct(SessionInterface $session = null, InputInterface $input = null, $hash = null)
    {

        if (!is_null($session)) {
            static::$session = $session;
        }
        if (!is_null($input)) {
            static::$input = $input;
        }
        if (!is_null($hash)) {
            static::$hash = $hash;
        }
    }

    /**
     * add session for token
     */
    public static function createToken()
    {
        static::$randomtoken = base64_encode(openssl_random_pseudo_bytes(32));
        static::$session->setUserdata('CSRFSession' . static::$hash, static::$randomtoken);
    }

    /**
     * generate html for csrf token
     */
    public static function createTokenField()
    {
        $sess_token = static::$randomtoken;
        print '<input type="hidden" name="' . static::$hash . '" value="' . $sess_token . '"/>' . "\n";
    }

    /**
     * @return bool
     */
    public static function isInValidToken()
    {
        $isCsfrCorrect = false;
        $postCsfr = static::$input->post(static::$hash);
        $sessionCsfr = static::$session->getUserdata('CSRFSession' . static::$hash);
        return $postCsfr == $sessionCsfr;
    }
} 