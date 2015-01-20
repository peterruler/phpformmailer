<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage mailer
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler, based on script by roger klein, www.klick-info.ch
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */

namespace ch\keepitnative\formmailer\src\mailer;

use ch\keepitnative\formmailer\config\SettingsInterface;
use ch\keepitnative\formmailer\src\config\ConfigRegistryInterface;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\input\InputInterface;
use ch\keepitnative\formmailer\src\request\Request;


interface MailerInterface {

    public function __construct(InputInterface &$input = null, ErrorInterface &$errors);

    public function sendMail($to='', $attachment=null, $imgName='');
} 