<?php
/**
 * Created by PhpStorm.
 * User: Clutz
 * Date: 16/01/2016
 * Time: 01:24
 */

namespace TechTest\People;

use TechTest\Person\PersonEntity;

interface People
{

	public function getAll();

	public function getById($id);

	public function add(PersonEntity $personEntity);

	public function update(PersonEntity $personEntity);

	public function deleteById($id);
}