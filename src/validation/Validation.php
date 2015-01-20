<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage validation
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, based on validation class by joost van veen, http://www.joostvanveen.com/
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\validation;

use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\error\Error;
use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\request\Request;

/**
 * Class Validation
 * @package ch\keepitnative\formmailer\src\validation
 */
class Validation
{
    /**
     * @var array
     */
    public static $errors = [];

    /**
     * @param array $errors
     */
    public static function setErrors($errors)
    {
        self::$errors = $errors;
    }

    /**
     * @return array
     */
    public static function getErrors()
    {
        return self::$errors;
    }

    /**
     * @param ErrorInterface $errors
     */
    function __construct(ErrorInterface &$errors)
    {
        static::$errors = $errors;
    }

	/**
     * @param $callback
     * @return string
     */
    public function removeElements($callback) {
        if(strstr($callback,'minlength')) {
            $callback = 'minlength';
        } else if(strstr($callback,'maxlength')) {
            $callback = 'maxlength';
        } else if(strstr($callback,'matches')) {
            $callback = 'matches';
        } else if(strstr($callback,'unique')) {
            $callback = 'unique';
        }
        return $callback;
    }
    /**
     * @param InputInterface $input
     * @param $rules
     * @return bool
     */

    public function validate($data, $rules) {

        $data = $data->post('all');
        $valid = TRUE;
        $minMaxLength = [];
        $n=0;
        foreach($rules as $fieldName => $rule) {
            $callbacks = explode('|',$rule);

            //var_dump($callbacks);
            foreach($callbacks as $callback) {
                $value = isset($data[$fieldName]) ? $data[$fieldName] : NULL;
                if(strstr($callback,'minlength')) {
                    $minlength='';
                    //echo $callback;
                    $minlengths = explode('=',$callback);
                    //var_dump($minlengths);
                    $minlength = $minlengths[1];
                    $callback = $this->removeElements($callback);
                    if( $this->$callback($value,$fieldName,$minlength) == FALSE) $valid = FALSE;
                } else if(strstr($callback,'maxlength')) {
                    $maxlength='';
                    $maxlengths = explode('=',$callback);
                    $maxlength = $maxlengths[1];
                    $callback = $this->removeElements($callback);
                    if( $this->$callback($value,$fieldName,$maxlength) == FALSE) $valid = FALSE;
                } else if(strstr($callback,'matches')) {
                    $match='';
                    $matches = explode('=',$callback);
                    $match = $matches[1];
                    $callback = $this->removeElements($callback);
                    if( $this->$callback($value,$fieldName,$match,$data) == FALSE) $valid = FALSE;
                }  else if(strstr($callback,'unique')) {
                    $dbKeys=array();
                    $matches = explode('=',$callback);
                    $dbKeys = explode(".",$matches[1]);
                    $callback = $this->removeElements($callback);
                    if( $this->$callback($value,$fieldName,$dbKeys) == FALSE) $valid = FALSE;
                } else {
                    if( $this->$callback($value,$fieldName) == FALSE) $valid = FALSE;
                }
            }
        }
        $errorVar = static::$errors;
        if(isset($GLOBALS['error'])) {
            foreach( $GLOBALS['error'] as $err ) :
                $errorVar::setErrors($err);
            endforeach;
        }
        return $valid;
    }

    /**
     * @param $value
     * @param $fieldname
     * @return mixed
     */
    public function email($value, $fieldname)
    {

        $fieldNames[] = $fieldname;
        $valid = filter_var($value, FILTER_VALIDATE_EMAIL);
        $errorVar = static::$errors;
        $err = '';
        if ($valid == FALSE) $err = 'Das Feld ' . ucfirst($fieldname) . ' muss eine gültige Email Adresse sein!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

    /**
     * @param $value
     * @param $fieldname
     * @return int
     */
    public function text($value, $fieldname)
    {
        $whitelist = '/^[a-zA-Zа-яА-Я0-9 ,\.\\n;:!_\-@]+$/';
        $valid = preg_match($whitelist, $value);
        $errorVar = static::$errors;
        $err = '';
        if ($valid == FALSE) $err = 'Das Feld ' . ucfirst($fieldname) . ' enthält ungültige Zeichen!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

    /**
     * @param $value
     * @param $fieldname
     * @return bool
     */
    public function numeric($value, $fieldname)
    {
        $valid = is_numeric($value);
        $errorVar = static::$errors;
        $err = '';
        if ($valid == FALSE) $err = 'Das Feld ' . ucfirst($fieldname) . ' enthält einen ungültigen Wert!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

    /**
     * @param $value
     * @param $fieldname
     * @return bool
     */
    public function required($value, $fieldname)
    {
        $valid = !empty($value);
        $errorVar = static::$errors;
        $err = '';
        if ($valid == FALSE) $err = 'Das Feld ' . ucfirst($fieldname) . ' ist ein Pflichfeld!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param $value
     * @param $fieldname
     * @return bool
     */
    public function integer($value,$fieldname) {
        $valid = is_int($value) || is_numeric($value);

        $errorVar = static::$errors;
        $err = '';
        if ($valid == FALSE) $err = 'Das Feld \''.$fieldname. '\' muss eine Ganzzahl enthalten!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param $value
     * @param $fieldname
     * @return bool
     */
    public function is_natural($value,$fieldname) {

        $errorVar = static::$errors;
        $err = '';
        $valid = is_numeric($value) || !is_nan($value);
        if($valid == FALSE) $err = 'Das Feld \''.$fieldname. '\' muss eine positive Ganzzahl enthalten!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param $value
     * @param $fieldname
     * @param $maxlength
     * @return bool
     */
    public function maxlength($value,$fieldname,$maxlength){
        //var_dump($maxlength);
        $errorVar = static::$errors;
        $err = '';
        $valid = (strlen($value) <= $maxlength)? true : false;
        if($valid == FALSE) $err = 'Das Feld \''.$fieldname. '\' muss weniger als '.$maxlength. ' Zeichen enthalten!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param $value
     * @param $fieldname
     * @param $minlength
     * @return bool
     */
    public function minlength($value,$fieldname,$minlength) {
        $errorVar = static::$errors;
        $err = '';
        $valid = (strlen($value) >= $minlength)? true: false;

        if($valid == FALSE) $err = 'Das Feld \''.$fieldname. '\' muss mehr als '.$minlength. ' Zeichen enthalten!';

        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param $value
     * @param $fieldname
     * @param $match
     * @param $data
     * @return bool
     */
    public function matches($value,$fieldname,$match,$data) {
        $errorVar = static::$errors;
        $err = '';
        //echo $value;echo $data[$match];exit;
        $valid = ($value==$data[$match])? true: false;
        if($valid == FALSE) $err = 'Das Feld \''.$fieldname. '\' muss mit dem Feld \''.$match. '\' übereinstimmen!';
        if(!empty($err)) {
            $GLOBALS['error'][$fieldname] = $err;
            //$errorVar::setErrors($err);
        }
        return $valid;
    }

	/**
     * @param null $value
     * @param $fieldname
     * @param array $dbKeys
     * @return bool
     */
    public function unique($value=null,$fieldname,$dbKeys=[]) {
        if(isset($value)) {
            $errorVar = static::$errors;
            $err = '';
            $pdo = MyPdo::getInstance();
            $record = $pdo->getOne($dbKeys[0],$dbKeys[1],$value);
            $valid = ($record==false)? true: false;
            if($valid == FALSE) $err =  'Das Feld \''.$fieldname. '\' mit dem Wert \''.$value. '\' ist schon vergeben!';
            if(!empty($err)) {
                $GLOBALS['error'][$fieldname] = $err;
                //$errorVar::setErrors($err);
            }
            return $valid;
        } else {
            return false;
        }
    }
}
