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

require_once __DIR__.'/InputInterface.php';
/**
 * Class Input
 * @package ch\keepitnative\formmailer\src\input
 */
class Input implements InputInterface
{
    /**
     * @var array
     */
    protected $inputs = [
        'get' => [],
        'post' => []
    ];

    /**
     * @param array $inputs
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * @return array
     */
    public function getInputs()
    {
        return $this->inputs;
    }


	/**
     * @param null $input
     * @return string
     * obsolete
     */
    public static function filterInput($input=null) {
           return  htmlentities(trim(str_replace(['_','iframe','$','eval'],'-',$input)),ENT_QUOTES,'UTF-8');
    }

    /**
     * @return static
     */
    public static function createFromGlobals()
    {
        return new static(
            [
                'get' => array_map(
                function($input=null) {
                    return  htmlentities(trim(str_replace(['`','_','iframe','script','object','embed','img','$','eval','exec','system'],'-',$input)),ENT_QUOTES,'UTF-8');
                },$_GET),
                'post' => array_map(
                function($input=null) {
                    return  htmlentities(trim(str_replace(['`','_','iframe','script','object','embed','img','$','eval','exec','system'],'-',$input)),ENT_QUOTES,'UTF-8');
                },$_POST)
            ]
        );
    }

    /**
     * @param array $inputs
     */
    public function __construct($inputs = [])
    {
        $this->replace($inputs);
    }

    /**
     * @param array $inputs
     */
    public function replace($inputs = [])
    {
        foreach ($this->inputs as $key => $input) {
            if (isset($inputs[$key])) {
                $this->inputs[$key] = $inputs[$key];
            }
        }
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        return $this->fetch('get', $key);
    }

    /**
     * @param $key
     * @return array|null
     */
    public function post($key)
    {
        if($key==='all') {
            return $this->inputs['post'];
        }
        return $this->fetch('post', $key);
    }

    /**
     * @param $input
     * @param $key
     * @return null
     */
    protected function fetch($input, $key)
    {
        $result = null;

        if (isset($this->inputs[$input][$key])) {
            $result = $this->inputs[$input][$key];
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function resetAllPostData() {
        foreach($this->inputs['post'] as $k => $v) {
            unset($this->inputs['post'][$k]);
        }
        return $this->inputs['post'];
    }
}
