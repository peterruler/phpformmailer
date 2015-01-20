<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage uploader
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, based on script by roger klein, www.klick-info.ch
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer\src\uploader;

require_once __DIR__ . '/UploaderInterface.php';

use ch\keepitnative\formmailer\config\SettingsInterface;
use ch\keepitnative\formmailer\src\config\ConfigInterface;
use ch\keepitnative\formmailer\src\config\ConfigRegistryInterface;
use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\mailer\MailerInterface;
use ch\keepitnative\formmailer\src\request\Request;
use ch\keepitnative\formmailer\src\uploader\UploaderInterface;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\error\Error;
use ch\keepitnative\formmailer\src\registry\RegistryInterface;
use ch\keepitnative\formmailer\src\config\Registry as ConfigRegistry;

/**
 * Class Uploader
 * @package ch\keepitnative\formmailer\src\uploader
 */
class Uploader implements UploaderInterface
{
    /**
     * @var null
     */
    public static $errors = NULL;
    /**
     * @var bool
     */
    public static $isSuccess = false;
    /**
     * @var \ch\keepitnative\formmailer\src\input\InputInterface|null
     */
    public $input = null;

    /**
     * @param null $errors
     */
    public static function setErrors($errors)
    {
        self::$errors = $errors;
    }

    /**
     * @return null
     */
    public static function getErrors()
    {
        return self::$errors;
    }

    /**
     * @param \ch\keepitnative\formmailer\src\input\InputInterface|null $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return \ch\keepitnative\formmailer\src\input\InputInterface|null
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param InputInterface $input
     * @param ErrorInterface $errors
     */
    public function __construct(InputInterface &$input, ErrorInterface &$errors)
    {
        $this->input = $input;
        static::$errors = $errors;
    }

    /**
     * @return boolean
     */
    public static function isIsSuccess()
    {
        return self::$isSuccess;
    }

    /**
     * @param boolean $isSuccess
     */
    public static function setIsSuccess($isSuccess)
    {
        self::$isSuccess = $isSuccess;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return static::$isSuccess;
    }

	/**
     * @return ConfigRegistry
     */
    public function getRegistry() {
        return ConfigRegistry::getInstance();
    }
    /**
     * @return array
     */
    public function getAllowedFileTypes()
    {
        $settings = $this->getRegistry();
        return explode(',', $settings->get('config')['erlaubteEndungen']);
    }

    /**
     * @return bool
     */
    public function checkIfUploadSelected()
    {
        $err = static::$errors;
        if ($this->input->post('format') == 2 || $this->input->post('format') == 3) {
            //ist entweder Bild oder Bild und Text
            $err::setMsg('Es wird bei den gegebenen Angaben ein Bild übermittelt');
            return true;
        } else if ($this->input->post('format') == 1) {
            $err::setErrors('Es wurde kein Upload gewünscht!');
            return false;
        }
    }

    /**
     * @return int
     */
    public function getMimeType() {
        $settings = $this->getRegistry();
        $imgName = $settings->get('data')['sujet']['name'];
        $info   = explode('.',$imgName);
        $type   = str_replace(['-','_','.','$'],'',trim($info[1]));
        //var_dump($type); exif_imagetype($filename); not working
        return $type;
    }
    /**
     * @return bool|mixed|string
     */
    public function getImgName()
    {
        $err = static::$errors;

        $settings = $this->getRegistry();

        $imgName = '';
        $imgName = $settings->get('data')['sujet']['tmp_name'];

        $imgName = str_replace(['.', ' ', '_', '$', ';'], '-', trim($imgName));

        $mimeExif = $this->getMimeType();
        $imgName = $imgName . microtime(true) . '.' . $mimeExif;

        $isFileProvided = true;

        //CHECK IF IMG NAME IS NOT EMPTY
        if (!isset($imgName) || empty($imgName)) {
            //check if an image is provided
            $err::setErrors('Bildname leer!');
            return false;
        }

        $erlaubteEndungen = $settings->get('config')['erlaubteEndungen'];
        $mimeHaystack = explode(',',$erlaubteEndungen);
        //CHECK MIME TYPE WITH WHITE LIST
        $mimeExif = $this->getMimeType();
        if (!in_array($mimeExif, $mimeHaystack)) {
            $err::setErrors('Dateityp nicht erlaubt');
            return false;
        } else {
            return $imgName;
        }
    }

    /**
     * @return string
     */
    public function getUploadFileFullPath()
    {
        $settings = $this->getRegistry();
        $uploadDir = $settings->get('config')['zielverzeichnis'];
        $uploadDir = substr($uploadDir,0,count($uploadDir)-1);
        $imgName = '';
        $imgName = $settings->get('data')['sujet']['tmp_name'];
        return $uploadDir . $imgName;
    }

    /**
     * @return bool
     */
    public function checkIfFileNameIsValid() {
        $settings = $this->getRegistry();
        if(empty(basename($settings->get('data')['sujet']['tmp_name']))) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function checkMaxUploadFileSize() {
        $settings = $this->getRegistry();
        $err = static::$errors;
        if ($settings->get('data')['sujet']['size'] >= $settings->get('config')['maximaleUploadGroesse']) {
            //check max size in MB
            $err::setErrors('Bild zu gross!');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function createUploadDir() {
        $settings = $this->getRegistry();
        $err = static::$errors;
        $uploadDir = $settings->get('config')['zielverzeichnis'];
        if ((!is_dir($uploadDir))) {
            $err::setErrors('Upload Verzeichnis ' . __DIR__ . $uploadDir . ' existiert nicht');
            if (!@mkdir($uploadDir)) {
                $err::setErrors('Verzeichnis nicht erstellbar');
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * @return bool
     */
    public function checkWritableUploadDir() {
        $settings = $this->getRegistry();
        $err = static::$errors;
        $uploadDir = $settings->get('config')['zielverzeichnis'];
        if (!is_writable($uploadDir)) {
            $err::setErrors('Verzeichnis nicht beschreibbar');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function checkFileBaseName() {
        $settings = $this->getRegistry();
        $err = static::$errors;
        $ext = $this->getMimeType();
        $erlaubteEndungen = $this->getAllowedFileTypes();
        $imgName = $this->getImgName();
        if (!is_uploaded_file($imgName) && !in_array($ext, $erlaubteEndungen)) {
            $err::setErrors('You\'ve cheated with the Files\' Name');
            return false;
        } else {
            return true;
        }

    }

    /**
     * @return mixed
     */
    public function createUniqueFileName() {
        $settings = $this->getRegistry();
        $uploadDir = $settings->get('config')['zielverzeichnis'];
        $fileName = explode('.',$settings->get('data')['sujet']['name'])[0];
        $time = str_replace(['.','_',' '],'-',microtime(true));
        $attachment = str_replace([',',' '],'-',trim($uploadDir).'/'.$fileName.'-'.$time.'.'.$this->getMimeType());
        //var_dump($attachment);
        return $attachment;
    }

    /**
     * @return array|bool
     */
    public function uploadStart() {

        $err = static::$errors;
        //GET CONFIG
        $settings = $this->getRegistry();
        //SECURITY CHECK is_uploaded_file
        $attachment = $this->createUniqueFileName();
        //CHECK IF IMG NAME IS NOT EMPTY AND
        //CHECK MIME TYPE WITH WHITE LIST
        //GETIMG MIME TYPE
        $imgName = $this->getImgName();
        $tmpImgName = $settings->get('data')['sujet']['tmp_name'];
        //var_dump($attachment);
        if (@move_uploaded_file($tmpImgName, $attachment)) {
            //var_dump(7);
            $err::setMsg('Bild hochladen erfolgreich!');
            $data = [
                'attachment' => $attachment,
                'imgName' => $imgName
            ];
            //var_dump($data);
            //die;
            //die;
            //return file/attachment info to mailer
            static::setIsSuccess(true);
            return $data;
        } else {
            //var_dump(8);
            //echo "hochladen nicht erfolgreich";
            $err::setErrors('Bild hochladen nicht erfolgreich');
            static::setIsSuccess(false);
            //die;
            return false;
        }
    }
    /**
     * @return array
     */
    public function uploadFile()
    {

        //START CHECK IF IMAGE MENT TO BE UPLOADED
        if (!$this->checkIfUploadSelected() || !$this->checkIfFileNameIsValid()) {
            //var_dump(1);die;
            return;
        }

        //CHECK MAXIMUM UPLOAD SIZE
        if(!$this->checkMaxUploadFileSize()) {
            //var_dump(2);die;
            return;
        }

        //CREATE NEW UPLOAD DIR IF NOT EXISTING YET
        if ($this->createUploadDir()) {
            //var_dump(3);die;
        }

        //CHECK IF UPLOAD DIR CAN BE WRITTEN TO
        if (!$this->checkWritableUploadDir()) {
            //var_dump(4);die;
            return;
        }

        //check basename security
        if (!$this->checkFileBaseName()) {
            //var_dump(5);die;
            return;
        }

        //START UPLOADING IMAGE
        if (!empty($this->getImgName() || !$this->getImgName() )) {
            //var_dump(6);die;

            //UPLOAD FILE
            return $this->uploadStart();
        }
    }
}
