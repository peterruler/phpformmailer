<?php
/**
 * @project Simple PHP Form Mailer
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer;
date_default_timezone_set("Europe/Zurich");
ob_start();

use ch\keepitnative\formmailer\src\config\Registry as ConfigRegistry;
use ch\keepitnative\formmailer\src\logger\factories\Logger as LoggerFactory;
use ch\keepitnative\formmailer\src\logger\Registry as LoggerRegistry;
use ch\keepitnative\formmailer\src\logger\Dependant;
use ch\keepitnative\formmailer\src\logger\logger\LogToFile;
use ch\keepitnative\formmailer\src\di\logger\Output;
use ch\keepitnative\formmailer\src\psr4autoloader\Psr4AutoloaderClass;
use ch\keepitnative\formmailer\src\error\ErrorInterface;
use ch\keepitnative\formmailer\src\input\Input;
use ch\keepitnative\formmailer\src\csrfprotection\CsrfProtection;
use ch\keepitnative\formmailer\src\error\Error;
use ch\keepitnative\formmailer\src\registry\RegistryInterface;
use ch\keepitnative\formmailer\src\uploader\Uploader;
use ch\keepitnative\formmailer\src\mailer\Mailer;
use ch\keepitnative\formmailer\src\validation\Validation;
use ch\keepitnative\formmailer\src\captcha\Captcha;
use ch\keepitnative\formmailer\src\session\Session;
use ch\keepitnative\formmailer\config\Settings;
require_once __DIR__ . '/src/psr4autoloader/Psr4AutoloaderClass.php';

// instantiate the loader
$loader = new Psr4AutoloaderClass();

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('ch\keepitnative\formmailer\src\\', __DIR__ . '/src');
// register the base directories for the namespace prefix
$loader->addNamespace('ch\keepitnative\formmailer\config\\', __DIR__ . '/config');

//get input instance
$input = Input::createFromGlobals();
//Start session

$session = Session::getInstance($input);
$session::regen();
$session->startTheSession();


//Einstellungen

//config lesen
//print_r($_SERVER);exit;
$root = $_SERVER['SCRIPT_FILENAME'];

//$ini_array = parse_ini_file(__DIR__ . "/config/config.ini", true); //true with groups

//var_dump($ini_array);Exit;
if (strpos($root, 'dev.02.php-upload-formmailer.me') !== false) {
    $env = 'DEVELOPMENT';
    //$group = array_keys($ini_array)[2];
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

} else if (strpos($root, 'phpformmailer-master') !== false) {
    $env = 'STAGE';
    //$group = array_keys($ini_array)[1];
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
} else {
    $env = 'PRODUCTION';
    //$group = array_keys($ini_array)[0];
    ini_set('display_errors', 'Off');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('log_errors','On');

}

//SECURITY php.ini settings
ini_set('session.use_only_cookies',1);
ini_set('max_file_uploads',1);
ini_set('allow_url_fopen','Off');

 ini_set('open_basedir', '/Applications/MAMP/'.PATH_SEPARATOR.__DIR__.'/config'.PATH_SEPARATOR.__DIR__.'/logs'.PATH_SEPARATOR.__DIR__.'/tmpl'.PATH_SEPARATOR.__DIR__.'/fonts'.PATH_SEPARATOR.__DIR__.'/uploads'.PATH_SEPARATOR.'./tmp'.PATH_SEPARATOR.__DIR__.'/tmp'.PATH_SEPARATOR.__DIR__.'/img'.PATH_SEPARATOR.__DIR__.'/src/');

//print $env;
//var_dump($group);exit;
define('ENV', $env);

//var_dump($settings);
//var_dump($ini_array);
/*
$thema = $ini_array[$group]['thema'];
$basisUrl = $ini_array[$group]['basisUrl'];
$weiterleitungsUrl = $ini_array[$group]['weiterleitungsUrl'];
$empfaenger = $ini_array[$group]['empfaenger'];
$hash = $ini_array[$group]['hash'];
$zielverzeichnis = $ini_array[$group]['zielverzeichnis'];
$maximaleUploadGroesse = $ini_array[$group]['maximaleUploadGroesse'];
$captchaBenutzen = $ini_array[$group]['captchaBenutzen'];
*/
//print $basisUrl;
//serverseitige validierungs regeln
$rules = [
    'email' => 'email|required',
    'nachname' => 'minlength=3|maxlength=28|text|required',
    'vorname' => 'minlength=2|maxlength=28|text|required',
    'strassenr' => 'minlength=5|maxlength=28|text|required',
    'plzort' => 'minlength=5|maxlength=28|text|required',
    'telefon' => 'minlength=5|maxlength=28|text|required',
    'art' => 'required|text',
    'groesse' => 'minlength=4|maxlength=28|text|required'
];
$settings = new Settings();
$config= $settings::$settings[$env];
$configRegistry = ConfigRegistry::getInstance();
//
$configRegistry->set('rules',$rules);
$configRegistry->set('data',$_FILES);
$configRegistry->set('config',$config);
//var_dump($configRegistry);
//$erlaubteDateiEndungen = explode(',', $ini_array[$group]['erlaubteEndungen']);
/*
$options = [
    'thema' => $thema,
    'baseUrl' => $basisUrl,
    'emailRecipientFirma' => $empfaenger,
    'data' => $_FILES,
    'uploadDir' => $zielverzeichnis,
    'maxSize' => $maximaleUploadGroesse, //=2MB
    'formats' => $erlaubteDateiEndungen,
    'rules' => $rules,
    'captchaBenutzen' => $captchaBenutzen,

];
*/
$logDir = __DIR__.'/logs';
//Ende Einstellungen

//GET THE FORM PROGRAM RUNNING

$errors = new Error();
$validator = new Validation($errors);

$token = CsrfProtection::getInstance($session, $input, $configRegistry->get('config')['hash']);
$token::createToken();

/*
$ini_array[$group]['data'] = $_FILES;
$ini_array[$group]['formats'] = $erlaubteDateiEndungen;
$ini_array[$group]['rules'] = $rules;
*/
if ($configRegistry->get('config')['captchaBenutzen']) {
    $optionsCaptcha = [
        'fontsDir' => './fonts',
        'tmpDir' => './tmp',
        'bgPath' => './img/bg.png'
    ];
    $configRegistry->set('captchaOptions',$optionsCaptcha);
    Captcha::destroyImage($session);
    $captcha = Captcha::getInstance($input, $session, $errors);
    //$captcha->createCaptcha();
}
//var_dump($input->post('reset'));
if ( $input->post($configRegistry->get('config')['hash']) && 'Zur&uuml;cksetzen'!= $input->post('reset')) {

    if (CsrfProtection::isInValidToken()) {
        $errors::setErrors("Security Token des Formulars und des Servers stimmen nicht überein!");
    }

    $mailer = new Mailer($input, $errors);
    $uploader = new Uploader($input, $errors);


    $config = [
        'logger' => 'LogToFile',
    ];
    $registry = LoggerRegistry::getInstance();
    $registry->set('configuration',$config);

    $loggerFactory = new LoggerFactory();

    $registry->set('loggerFactory',$loggerFactory);

    $loggerFactory('LogToFile');

    $dependant = new Dependant();
    $dependant->setLogger($loggerFactory->getLogger());

    //var_dump($_SERVER);

    //check if theres an image to upload
    if ($input->post('format') && $input->post('format') == 2 || $input->post('format') == 3) {
        $data = $uploader->uploadFile();
        //var_dump($data);die;
        $imgName = $data['imgName'];
        $attachment = $data['attachment'];
    }

    if ($validator->validate($input, $configRegistry->get('rules')) == TRUE) {

        if ($configRegistry->get('config')['captchaBenutzen']) {
            if (Captcha::checkCaptcha($session)) {
                $errors::setMsg("Captcha Code ist gültig");
            } else {
                $errors::setErrors("Captcha Code ist ungültig");
            }
        }

        //validate form input
        $errors::setMsg('Validierung erfolgreich!');

        if ($uploader->isSuccessful()) {
            //email with attachment
            if (count($errors::$errors) <= 0) {
                $isMailed1 = $mailer->sendMail($configRegistry->get('config')['empfaenger'],$attachment, $imgName);
                $isMailed2 = $mailer->sendMail($input->post('email'),$attachment, $imgName);
                if ($isMailed1 && $isMailed2) {
                    $errors::setMsg('Email erfolgreich versendet!!');
                    header("Location: ". $configRegistry->get('config')['basisUrl'] . 'success.php');
                } else {
                    $errors::setErrors('Email konnte nicht versendet werden!!');
                }
            }
        } else {
            //non attachment mail
            if (count($errors::$errors) <= 0) {
                $isMailed1 = $mailer->sendMail($configRegistry->get('config')['empfaenger'], null, null);
                $isMailed2 = $mailer->sendMail($input->post('email'), null, null);
                if ($isMailed1 && $isMailed2) {
                    $errors::setMsg('Email erfolgreich versendet!!');
                    $captcha::destroyImage($session);
                    $session::regen();
                    $ip = $_SERVER['SERVER_ADDR'];
                    $dependant->setMsg($errors::$errors,$ip,'success',$logDir);
                    header("Location: ".$configRegistry->get('config')['basisUrl'] . 'success.php');
                } else {
                    $errors::setErrors('Email konnte nicht versendet werden!!');
                    $session::regen();
                }
            }
        }
    } else {
        $ip = $_SERVER['SERVER_ADDR'];
        $dependant->setMsg($errors::$errors,$ip,'validation error',$logDir);
        $value = 'Es gab Fehler bei der Validierung:';
        array_unshift($errors::$errors, $value);
    }
} else {
    //@todo debug $errors::setErrors('CSRF Error');
}
if($input->post('reset')=='Zur&uuml;cksetzen') {
    $input->resetAllPostData();
}
print ob_get_contents();
