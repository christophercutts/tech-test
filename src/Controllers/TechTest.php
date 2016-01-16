<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 23/10/2015
 * Time: 22:59
 */

namespace TechTest\Controllers;

use Http\Request;
use Http\Response;
use TechTest\Csrf\Csrf;
use TechTest\Person\PersonEntity;
use TechTest\Template\Renderer;
use TechTest\People\People;

class TechTest
{
	/**
	 * @var Response
	 */
	private $response;
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var Renderer
	 */
	private $renderer;
	/**
	 * @var People
	 */
	private $people;
	/**
	 * @var Csrf
	 */
	private $csrf;

	public function __construct(Request $request, Response $response, Renderer $renderer, People $people, Csrf $csrf)
	{
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
		$this->people = $people;
		$this->csrf = $csrf;
	}

	/**
	 * Main GET request to display all currently stored people
	 *
	 * URI: /
	 *
	 */
	public function show()
	{
		$template_vars = array(
			'people'			=> $this->people->getAll(),
			'csrf'				=> $this->csrf->getNewToken(),
			'execution_time'	=> sprintf("%.4f", microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),
		);
		$html = $this->renderer->render('page/view.php', $template_vars);
		$this->response->setContent($html);
	}

	/**
	 * Add a person from the values submitted to POST
	 *
	 * URI: /add
	 *
	 */
	public function add()
	{
		if($this->request->getParameter('csrf') === $this->csrf->getCurrentToken()) {
			try {
				$person = (new PersonEntity())->setFirstname($this->request->getParameter('firstname'))
					->setSurname($this->request->getParameter('surname'));
				$person->setId($this->people->add($person));
				$json = $person->toJson();
				$response = 200;
			} catch (\Exception $e) {
				$json = json_encode(array('message' => "failure"));
				$response = 500;
			}
		} else {
			$json = json_encode(array('message' => "failure"));
			$response = 500;
		}
		$template_vars = array(
			'json' => $json,
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}

	/**
	 * Update a person with the details submitted to POST
	 *
	 * URI: /update
	 *
	 */
	public function update()
	{
		if($this->request->getParameter('csrf') === $this->csrf->getCurrentToken()) {
			try {
				$person = (new PersonEntity())->setId((int)$this->request->getParameter('id'))
					->setFirstname($this->request->getParameter('firstname'))
					->setSurname($this->request->getParameter('surname'));
				$this->people->update($person);
				$json = $person->toJson();
				$response = 200;
			} catch (\Exception $e) {
				$json = json_encode(array('message' => "failure"));
				$response = 500;
			}
		} else {
			$json = json_encode(array('message' => "failure"));
			$response = 500;
		}
		$template_vars = array(
			'json' => $json,
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}

	/**
	 * Delete a single person based on the ID
	 *
	 * URI: /delete
	 *
	 */
	public function delete()
	{
		if($this->request->getParameter('csrf') === $this->csrf->getCurrentToken()) {
			try {
				$this->people->deleteById((int)$this->request->getParameter('id'));
				$message = 'success';
				$response = 200;
			} catch (\Exception $e) {
				$message = 'failure';
				$response = 500;
			}
		} else {
			$message = 'failure';
			$response = 500;
		}

		$template_vars = array(
			'json' =>  json_encode(array('message' => $message)),
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}
}