<?php
return [
	['GET', '/', ['TechTest\Controllers\TechTest', 'show']],
	['POST', '/add', ['TechTest\Controllers\TechTest', 'add']],
	['POST', '/update', ['TechTest\Controllers\TechTest', 'update']],
	['POST', '/delete', ['TechTest\Controllers\TechTest', 'delete']],
];