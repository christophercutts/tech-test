<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 16/01/2016
 * Time: 01:27
 */

namespace TechTest\Person;


class PersonEntity
{
	/**
	 * @var int
	 */
	protected $id;
	/**
	 * @var string
	 */
	protected $firstname;
	/**
	 * @var string
	 */
	protected $surname;

	public function toJson()
	{
		return json_encode(array(
			'id'		=> $this->getId(),
			'firstname'	=> $this->getFirstname(),
			'surname'	=> $this->getSurname()
		));
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return PersonEntity
	 * @throws \Exception
	 */
	public function setId($id)
	{
		if(!is_int($id))
			throw new \Exception('Person ID must be an integer');
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstname()
	{
		return $this->firstname;
	}

	/**
	 * @param string $firstname
	 * @return PersonEntity
	 * @throws \Exception
	 */
	public function setFirstname($firstname)
	{
		if(!is_string($firstname))
			throw new \Exception('Firstname must be a string');
		$this->firstname = $firstname;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param string $surname
	 * @return PersonEntity
	 * @throws \Exception
	 */
	public function setSurname($surname)
	{
		if(!is_string($surname))
			throw new \Exception('Surname must be a string');
		$this->surname = $surname;
		return $this;
	}

}