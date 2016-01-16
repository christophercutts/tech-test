<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 16/01/2016
 * Time: 01:29
 */

namespace TechTest\People;

use TechTest\Person\PersonEntity;

class JsonPeople implements People
{
	/**
	 * @var PersonEntity[]
	 */
	protected $people = array();

	const STORE_LOC = __DIR__ . '/../../storage/store.json';

	public function __construct()
	{
		if(empty($this->people)) {
			$people = array();
			if (file_exists(self::STORE_LOC)) {
				foreach(json_decode(file_get_contents(self::STORE_LOC), true) as $id => $person) {
					$people[$id] = (new PersonEntity())->setId($id)->setFirstname($person['firstname'])->setSurname($person['surname']);
				}
			}
			ksort($people);
			$this->setPeople($people);
		}
	}

	public function getAll()
	{
		return $this->getPeople();
	}

	public function getById($id)
	{
		if(!is_int($id))
			throw new \Exception('Person ID must be an integer!');
		if(!isset($this->people[$id]))
			throw new \Exception('A person does not exist with that ID');
		var_dump(count($this->people));
		return $this->people[$id];
	}

	public function add(PersonEntity $personEntity)
	{
		$newId = max(array_keys($this->people)) + 1;
		$personEntity->setId($newId);
		$this->setPeople($this->getPeople() + array($newId => $personEntity));
		$this->save();
		return $personEntity->getId();
	}

	public function update(PersonEntity $personEntity)
	{
		$people = $this->getPeople();
		if(isset($people[$personEntity->getId()])) {
			$people[$personEntity->getId()] = $personEntity;
			$this->setPeople($people);
			$this->save();
		} else {
			$this->add($personEntity);
		}
	}

	public function deleteById($id)
	{
		$people = $this->getPeople();
		if(isset($people[$id])) {
			unset($people[$id]);
			$this->setPeople($people);
			$this->save();
		}
	}

	private function save() {
		$people = array();
		foreach($this->getPeople() as $person) {
			$people[$person->getId()] = array(
				'firstname'	=> $person->getFirstname(),
				'surname'	=> $person->getSurname()
			);
		}
		$fp = fopen(self::STORE_LOC, 'w');
		fwrite($fp, json_encode($people));
		fclose($fp);
	}

	/**
	 * @return PersonEntity[]
	 */
	public function getPeople()
	{
		return $this->people;
	}

	/**
	 * @param PersonEntity[] $people
	 */
	private function setPeople($people)
	{
		$this->people = $people;
	}

}