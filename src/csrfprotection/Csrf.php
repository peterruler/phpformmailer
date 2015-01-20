<?php
/**
 * @project Simple PHP Form Mailer
 * @subpackage csrf
 * @version 0.0.3
 * @authorUri: http://www.keepitnative.ch
 * @author peterruler
 * @copyright (c) 2014 by peterruler, all rights reserved
 * @license GNU/GPLv3
 * @creationDate 25.11.14
 */
namespace ch\keepitnative\formmailer\src\csrfprotection;
/**
 * Interface Csrf
 * @package ch\keepitnative\formmailer\src\csrfprotection
 */
interface Csrf {
    /**
     * @param SessionInterface $session
     * @param InputInterface $input
     * @param null $hash
     */
    public function __construct(SessionInterface $session= null, InputInterface $input= null, $hash=null);

    /**
     * @return mixed
     */
    public static function createToken();

    /**
     * @return mixed
     */
    public static function createTokenField();

    /**
     * @return mixed
     */
    public static function isInValidToken();
} 