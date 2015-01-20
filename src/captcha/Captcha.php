<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage captcha
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, based on script by roger klein, www.klick-info.ch
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\captcha;

use ch\keepitnative\formmailer\src\config\ConfigRegistryInterface;
use ch\keepitnative\formmailer\src\config\Registry;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\captcha\CaptchaInterface;
use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\session\SessionInterface;

require_once __DIR__.'/CaptchaInterface.php';
/**
 * Class Captcha
 * @package ch\keepitnative\formmailer\src\captcha
 */
class Captcha implements CaptchaInterface {

    /**
     * @var null
     */
    protected static $instance=null;

    /**
     * @var null
     */
    protected static $error=null;

	/**
     * @var null
     */
    public static $input = null;
    /**
     * @var null
     */
    protected static  $session = null;

    /**
     * @var string
     */
    private static $tmpPath = './tmp';

    /**
     * @var string
     */
    private $fontsDir = './fonts';

    /**
     * @var string
     */
    private $bgPath = './img/bg.png';

    /**
     * @var string
     */
    private $fileName = '';

    /**
     * @var string
     */
    private $txtCode = '';

    /**
     * @return null
     */
    public static function getInput()
    {
        return self::$input;
    }

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
    public static function getSession()
    {
        return static::$session;
    }

    /**
     * @param $session
     */
    public static function setSession($session)
    {
        static::$session = $session;
    }

    /**
     * @param string $bgPath
     */
    public function setBgPath($bgPath='')
    {
        $this->bgPath = $bgPath;
    }

    /**
     * @return string
     */
    public function getBgPath()
    {
        return $this->bgPath;
    }

    /**
     * @param $fontsDir
     */
    public function setFontsDir($fontsDir)
    {
        $this->fontsDir = $fontsDir;
    }

    /**
     * @return string
     */
    public function getFontsDir()
    {
        return $this->fontsDir;
    }

    /**
     * @param $txtCode
     */
    public function setTxtCode($txtCode)
    {
        $this->txtCode = $txtCode;
    }

    /**
     * @return string
     */
    public function getTxtCode()
    {
        return $this->txtCode;
    }

    /**
     * @param $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $tmpPath
     */
    public static function setTmpPath($tmpPath)
    {
        static::$tmpPath = $tmpPath;
    }

    /**
     * @return string
     */
    public static function getTmpPath()
    {
        return static::$tmpPath.'/';
    }

    /**
     * @param int $code
     */
    public function setSessionCode($code=0) {
        static::$session->setUserdata('code',$code);
    }

    /**
     * @return mixed
     */
    public static function getSessionCode() {
        return static::$session->getUserdata('code');
    }

    /**
     * @param string $imgName
     */
    public function setSessionFileName($imgName='') {
        static::$session->setUserdata('imgName', $imgName);
    }

    /**
     *
     */
    public function resetSessionFileName() {
        static::$session->setUserdata('imgName',NULL);
    }

    /**
     * @return mixed
     */
    public static function getSessionFileName() {
        return static::$session->getUserdata('imgName');
    }

    /**
     * @return bool
     */
    public static function destroyImage(SessionInterface $session)
    {
        $tmpPath = str_replace('/\.\//',__DIR__.'/../../',static::getTmpPath());
        $directoryIterator = new \DirectoryIterator($tmpPath);
        foreach($directoryIterator as $content) :
            $filePath = $tmpPath.$content->getFileName();
            //var_dump($content->getFileName(),$session->getUserdata('imgName'));
            if($tmpPath.$content->getFileName()==$session->getUserdata('imgName'))
                unlink($filePath);
        endforeach;
    }

    /**
     * @return null
     */
    public static function getError()
    {
        return static::$error;
    }

    /**
     * @param $error
     */
    public static function setError($error)
    {
        static::$error = $error;
    }

    /**
     * @return bool
     */
    public static function checkCaptcha(SessionInterface $session) {
        $isCaptchaValid = false;
        $post = array_map('\strip_tags',$_POST);

        $code = static::getSessionCode();
        if($post['captcha'] == $code) {
            $isCaptchaValid = true;
            //after checking remove captcha png from folder
            static::destroyImage($session);
        }
        return $isCaptchaValid;
    }

    /**
     * @param array $options
     * @param ErrorInterface $error
     */
    protected function __construct($options=[],ErrorInterface &$error) {

        static::setTmpPath($options['tmpDir']);
        $this->setFontsDir($options['fontsDir']);
        $this->setTmpPath($options['tmpDir']);
        $this->setBgPath($options['bgPath']);
        $this->createCaptcha();
    }

    /**
     *
     */
    private function __clone() {}

    /**
     * @return bool
     */
    public static function sessionStart() {
        return session_start();
    }

    /**
     * @param SessionInterface $session
     * @param ErrorInterface $error
     * @return null
     */
    public static function getInstance(InputInterface $input, SessionInterface &$session, ErrorInterface &$error)
    {
        $registry = Registry::getInstance();
        $options = $registry->get('captchaOptions');
        static::setInput($input);
        static::$session = $session;
        if(is_null(static::$instance)) {
            static::$instance = new static($options,$error);
        }
        return static::$instance;
    }

    /**
     * creates captcha output tmp dir from tmpPath
     */
    public function createTmpDir() {
        if(!is_dir(static::getTmpPath())) {
            try {
                if(!@mkdir(static::getTmpPath(),'0777')) {
                    throw new \Exception('Captcha tmp dir was not created');
                }
            } catch(\Exception $e) {
               print $e->getMessage();
            }
        }
    }
    /**
     * class to create captcha image via gd lib
     */
    public function createCaptcha()
    {
        $this->createText();
        $input = static::getInput();
        $post = $input->post('all');
        if(!$post)
        $this->setSessionCode($this->getTxtCode());
        $code = static::getSessionCode();
        $font_dir = $this->getFontsDir();
        // Hintergrundbild laden
        $filePath = $this->getBgPath();
        $image = ImageCreateFromPNG($filePath);

        // Schriftfarbe
        $color = imagecolorallocate($image, 0, 0, 0);

        // Schriftgroesse
        $size = 20;

        // Zeichen auf das Bild setzen, Position etwas variieren, zufaellig eine Schriftart auswaehlen (1.ttf-7.ttf)
        imagettftext($image, $size, 0, 5,   25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[0]);
        imagettftext($image, $size, 0, 30,  25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[1]);
        imagettftext($image, $size, 0, 55,  25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[2]);
        imagettftext($image, $size, 0, 80,  25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[3]);
        imagettftext($image, $size, 0, 105, 25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[4]);
        imagettftext($image, $size, 0, 130, 25 + rand(0, 10), $color, $font_dir.'/'.rand(1,7).'.ttf', $code[5]);

        $captchaFileName = $this->getFileName();
        $this->createUniqueImageName();
        $outputFileName = static::getTmpPath().$this->getFileName();
        $this->setSessionFileName($outputFileName);
        $this->createTmpDir();
        imagepng($image, $outputFileName);
        // Bild aus Speicher entfernen
        imagedestroy($image);
    }

    /**
     * @param int $anz
     */
    public function createText($anz = 6){
        $txtCode ='';
        $arr1 = range(2, 9);
        $arr2 = array_merge(range('a', 'h'), ['m', 's', 'w', 'x', 'y', 'z']);
        $arr2 = array_map('strtolower', $arr2);
        $arr1und2 = array_merge($arr1, $arr2);
        srand ((float)microtime() * 1000000);
        shuffle($arr1und2);
        $txtCode = array_slice($arr1und2, 0, $anz);
        $txtCode = implode('',$txtCode);
        $this->setTxtCode($txtCode);

    }

    /**
     * create a unique image name
     */
    public function createUniqueImageName()
    {
        $fileName='';
        $dateTime = new \DateTime();
        $timestamp = $dateTime->format('U');
        $fileName = $timestamp.'-'.uniqid();
        $this->setFileName($fileName.'.png');
    }

    /**
     * generate html for the captcha
     */
    public static function outputImage()
    {
        $filePath = static::getSessionFileName();

        print '<img src="'.$filePath.'" alt="Captcha-Bild" />';
    }
}
