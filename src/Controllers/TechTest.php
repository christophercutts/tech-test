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

	public function __construct(Request $request, Response $response, Renderer $renderer, People $people)
	{
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
		$this->people = $people;
	}

	public function show()
	{
		$template_vars = array(
			'people' => $this->people->getAll(),
			'execution_time'	=> sprintf("%.4f", microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),
		);
		$html = $this->renderer->render('page/view.php', $template_vars);
		$this->response->setContent($html);
	}

	public function add() {
		try {
			$person = (new PersonEntity())->setFirstname($this->request->getParameter('firstname'))
				->setSurname($this->request->getParameter('surname'));
			$person->setId($this->people->add($person));
			$json = $person->toJson();
			$response = 200;
		}catch(\Exception $e) {
			switch($e->getMessage()) {
				case 'Firstname must be a string':
					$message = "badfirstname";
					break;
				case 'Surname must be a string':
					$message = "badsurname";
					break;
				default:
					$message = "error";
					break;
			}
			$json = json_encode(array('message' => $message));
			$response = 500;
		}
		$template_vars = array(
			'json' => $json,
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}

	public function update() {
		try {
			$person = (new PersonEntity())->setId((int)$this->request->getParameter('id'))
				->setFirstname($this->request->getParameter('firstname'))
				->setSurname($this->request->getParameter('surname'));
			$this->people->update($person);
			$json = 'Updated';
			$response = 200;
		}catch(\Exception $e) {
			switch($e->getMessage()) {
				case 'Firstname must be a string':
					$message = "badfirstname";
					break;
				case 'Surname must be a string':
					$message = "badsurname";
					break;
				default:
					$message = $e->getMessage();
					break;
			}
			$json = json_encode(array('message' => $message));
			$response = 500;
		}
		$template_vars = array(
			'json' => $json,
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}

	public function delete()
	{
		$this->people->deleteById($this->request->getParameter('id'));
		$json = 'Deleted';
		$response = 200;

		$template_vars = array(
			'json' => $json,
		);
		$html = $this->renderer->render('page/data.php', $template_vars);
		$this->response->setStatusCode($response);
		$this->response->setContent($html);
	}
}