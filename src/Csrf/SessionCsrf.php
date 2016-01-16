<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 16/01/2016
 * Time: 14:47
 */

namespace TechTest\Csrf;


class SessionCsrf implements Csrf
{
	const TOKEN_NAME = 'csrf-token';

	public function __construct()
	{
		if(!session_id())
			session_start();
	}

	public function getNewToken()
	{
		$_SESSION[self::TOKEN_NAME] = bin2hex(openssl_random_pseudo_bytes(10));
		return $_SESSION[self::TOKEN_NAME];
	}

	public function getCurrentToken()
	{
		if(!isset($_SESSION[self::TOKEN_NAME]))
			$this->getNewToken();
		return $_SESSION[self::TOKEN_NAME];
	}
}