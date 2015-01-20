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

use ch\keepitnative\formmailer\config\SettingsInterface;
use ch\keepitnative\formmailer\src\config\ConfigInterface;
use ch\keepitnative\formmailer\src\config\ConfigRegistryInterface;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\input\InputInterface;

/**
 * Interface UploaderInterface
 * @package ch\keepitnative\formmailer\src\uploader
 */
interface UploaderInterface {

    /**
     * @param InputInterface $input
     * @param ErrorInterface $errors
     */
    public function __construct(InputInterface &$input, ErrorInterface &$errors);

    /**
     * @return mixed
     */
    public static function isIsSuccess();

    /**
     * @param $isSuccess
     * @return mixed
     */
    public static function setIsSuccess($isSuccess);

    /**
     * @return mixed
     */
    public function uploadFile();

    /**
     * @return mixed
     */
    public function isSuccessful();
} 