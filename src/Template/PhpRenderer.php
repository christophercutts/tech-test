<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 04/11/2015
 * Time: 23:34
 */

namespace TechTest\Template;

class PhpRenderer implements Renderer
{
	public function render($template, $data = [])
	{
		extract($data);
		ob_start();
		include ROOT_DIR . '/../templates/' . $template;
		$content = ob_get_contents();
		ob_clean();
		return $content;
	}

}