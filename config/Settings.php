<?php
namespace ch\keepitnative\formmailer\config;
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 19.01.15
*/
/**
 * Class Settings
 * @package ch\keepitnative\formmailer\config
 */
class Settings
{
    /**
     * @var string
     */
    private static $env = 'DEVELOPMENT';
    /**
     * @var array
     */
    public static $settings = [
        'DEVELOPMENT' => [
            'thema'                 => 'Offerte',
            'basisUrl'              => 'http://phpformmailer-master.01.me:5555/',
            'weiterleitungsUrl'     => 'http://phpformmailer-master.01.me:5555/success.php',
            'empfaenger'            => '7starch@gmail.com',
            'hash'                  => 'honey_potfield_FokjlarjfsagF9845698sdfh_g9823_4598skjg',//Sicherheits Antispam Hash
            'zielverzeichnis'       => './uploads/',//Ordner in dem Bilder gespeichert werden sollen
            'maximaleUploadGroesse' => '2000000',//2 MB, in Bytes
            'erlaubteEndungen'      => 'gif,png,jpg,pdf,eps,ai',//mit Komma ',' getrennte Liste aller Dateiendungen
            'captchaBenutzen'       => true,
            'srvRoot'               => '/Applications/MAMP/',
        ],
        'STAGE'       => [
            'thema'                 => 'Offerte',
            'basisUrl'              => 'http://phpformmailer-master.me/',
            'weiterleitungsUrl'     => 'http://phpformmailer-master.me/success.php',
            'empfaenger'            => '7starch@gmail.com',
            'hash'                  => 'honey_potfield_FokjlarjfsagF9845698sdfh_g9823_4598skjg',//Sicherheits Antispam Hash
            'zielverzeichnis'       => './uploads/',//Ordner in dem Bilder gespeichert werden sollen
            'maximaleUploadGroesse' => '2000000',//2 MB, in Bytes
            'erlaubteEndungen'      => 'gif,png,jpg,pdf,eps,ai',//mit Komma ',' getrennte Liste aller Dateiendungen
            'captchaBenutzen'       => true,
            'srvRoot'               => '/Applications/MAMP/',
        ],
        'PRODUCTION'  => [
            'thema'                 => 'Offerte',
            'basisUrl'              => 'http://phpformmailer-master.me/',
            'weiterleitungsUrl'     => 'http://phpformmailer-master.me/success.php',
            'empfaenger'            => '7starch@gmail.com',
            'hash'                  => 'honey_potfield_FokjlarjfsagF9845698sdfh_g9823_4598skjg',//Sicherheits Antispam Hash
            'zielverzeichnis'       => './uploads/',//Ordner in dem Bilder gespeichert werden sollen
            'maximaleUploadGroesse' => '2000000',//2 MB, in Bytes
            'erlaubteEndungen'      => 'gif,png,jpg,pdf,eps,ai',//mit Komma ',' getrennte Liste aller Dateiendungen
            'captchaBenutzen'       => true,
            'srvRoot'               => '/Applications/MAMP/',
        ]
    ];
}