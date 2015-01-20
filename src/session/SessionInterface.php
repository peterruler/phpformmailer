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
use ch\keepitnative\formmailer\src\request\Request;
use ch\keepitnative\formmailer\src\response\Response;

/**
 * Interface SessionInterface
 * @package ch\keepitnative\formmailer\src\session
 */
interface SessionInterface
{
    /**
     * @return mixed
     */
    public static function isSessionStarted();

    /**
     * @param InputInterface $request
     * @param Response $response
     * @param null $key
     * @return mixed
     */
    public static function getInstance(InputInterface &$input, $key = NULL);

    /**
     * @param InputInterface $request
     * @param Response $response
     * @param null $key
     */
    function __construct(InputInterface &$input, $key = NULL);

    /**
     * @return mixed
     */
    function __clone();

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    function setUserdata($key, $value);

    /**
     * @param $key
     * @return mixed
     */
    function getUserdata($key);

    /**
     * @return mixed
     */
    public static function regen();

    /**
     * @param array $data
     * @return mixed
     */
    public function setUserdatas($data = []);

    /**
     * @param $key
     * @return mixed
     */
    public function issetParameter($key);

    /**
     * @return mixed
     */
    public function unsetAll();
}
