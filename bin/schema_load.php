<?php
require_once __DIR__ . '/../bootstrap.php';
use Core\App;
$db = App::get('database');

$schemaFile = __DIR__ . '/../database/schema.sql';
$sql = file_get_contents($schemaFile);

// throw new Exception('Testing exception handling!');

try {
	$parts = explode(';', $sql);
	$parts = array_filter($parts);
	foreach ($parts as $part) {
		$db->query($part);
	}
	echo "Schema loaded successfully.\n";
} catch (Exception $e) {
		echo ("Error loading schema: " . $e->getMessage()) . "\n";
}	