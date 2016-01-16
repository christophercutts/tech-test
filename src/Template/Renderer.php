<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 24/10/2015
 * Time: 00:14
 */

namespace TechTest\Template;


interface Renderer
{
	public function render($template, $data = []);
}