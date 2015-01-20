<?php
/**
* @author:peterruler
* @copyright (c) 2014 by peterruler, all rights reserved
* @license GPLv2
* @created 17.01.15
*/

namespace ch\keepitnative\formmailer\src\registry;

interface RegistryInterface {
	public function setRequest(Request $request);
	public function setResponse(Response $response);
	public function getRequest();
	public function getResponse();
}