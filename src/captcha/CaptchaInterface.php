<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage captcha
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer\src\captcha;

use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\session\SessionInterface;

/**
 * Interface CaptchaInterface
 * @package ch\keepitnative\formmailer\src\captcha
 */
interface CaptchaInterface {
    /**
     * @param SessionInterface $session
     * @param ErrorInterface $error
     * @return mixed
     */
    public static function getInstance(InputInterface $input, SessionInterface &$session, ErrorInterface &$error);
    /**
     * @return null
     */
    public static function getSession();

    /**
     * @param $session
     */
    public static function setSession($session);
    /**
     * @return mixed
     */
    public function createCaptcha();

    /**
     * @return mixed
     */
    public function createText();

    /**
     * @return mixed
     */
    public function createUniqueImageName();

    /**
     * @return mixed
     */
    public static function outputImage();

    /**
     * @param $imgDir
     * @return mixed
     */
    public function setBgPath($imgDir);

    /**
     * @return mixed
     */
    public function getBgPath();

    /**
     * @param $fontsDir
     * @return mixed
     */
    public function setFontsDir($fontsDir);

    /**
     * @return mixed
     */
    public function getFontsDir();

    /**
     * @param $txtCode
     * @return mixed
     */
    public function setTxtCode($txtCode);

    /**
     * @return mixed
     */
    public function getTxtCode();

    /**
     * @param $fileName
     * @return mixed
     */
    public function setFileName($fileName);

    /**
     * @return mixed
     */
    public function getFileName();

    /**
     * @param $tmpPath
     * @return mixed
     */
    public static function setTmpPath($tmpPath);

    /**
     * @return mixed
     */
    public static function getTmpPath();

    /**
     * @param int $code
     * @return mixed
     */
    public function setSessionCode($code=0);

    /**
     * @return mixed
     */
    public static function getSessionCode();

    /**
     * @param string $imgName
     * @return mixed
     */
    public function setSessionFileName($imgName='');

    /**
     * @return mixed
     */
    public static function getSessionFileName();

    /**
     * @return mixed
     */
    public function resetSessionFileName();

    /**
     * @return mixed
     */
    public static function destroyImage(SessionInterface $session);
    /**
     * @return bool
     */
    public static function checkCaptcha(SessionInterface $session);
}