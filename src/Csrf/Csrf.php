<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 16/01/2016
 * Time: 14:46
 */

namespace TechTest\Csrf;


interface Csrf
{

	public function getNewToken();

	public function getCurrentToken();

}