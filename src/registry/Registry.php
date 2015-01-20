<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage registry
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, (c) by Stephan Schmidt, php design patterns, http://www.phpdesignpatterns.de/auflage-2/
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer\src\registry;

require_once __DIR__.'/RegistryInterface.php';
use ch\keepitnative\formmailer\src\registry\RegistryInterface;

/**
 * Class Registry
 * @package ch\keepitnative\formmailer\src\session
 */
class Registry implements RegistryInterface
{
    /**
     * @var null
     */
    protected static $instance = null;
    /**
     * @var array
     */
    protected $values = array();

    /**
     *
     */
    const KEY_REQUEST = 'request';
    /**
     *
     */
    const KEY_RESPONSE = 'response';

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return Registry|null
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    /**
     *
     */
    protected function __construct()
    {
    }

    /**
     *
     */
    private function __clone()
    {
    }

    /**
     * @param $key
     * @param $value
     */
    protected function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * @param $key
     * @return null
     */
    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->set(self::KEY_REQUEST, $request);
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->set(self::KEY_RESPONSE, $response);
    }

    /**
     * @return null
     */
    public function getRequest()
    {
        return $this->get(self::KEY_REQUEST);
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->get(self::KEY_RESPONSE);
    }
}