<?php

namespace Core;


abstract class Model {
	protected static $table;
	public $id;

	public static function all(): array {
		$db = App::get('database');
		return $db->fetchAll("SELECT * FROM " . static::$table, [], static::class);
	}

	public static function find(mixed $id): static | null {
		$db = App::get('database');
		$result = $db->fetch("SELECT * FROM " . static::$table . " WHERE id = ?", [$id], static::class);
		return $result ? $result : null;
	}

	public static function create(array $data): static {
		$db = App::get('database');
		$columns = implode(', ', array_keys($data));
		$placeholders = implode(', ', array_fill(0, count($data), '?'));
		$sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
		$db->query($sql, array_values($data));
		return static::find($db->lastInsertId());
	}

	public function save(): static {
		$db = App::get('database');
		$data = get_object_vars($this);
		if (isset($this->id)) {
			// Update existing record
			unset($data['id']); // Ensure id is not included in update
			$set = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
			$sql = "UPDATE " 
			. static::$table 
			. " SET $set WHERE id = ?";
			$params = array_values($data);
			$params[] = $this->id; // Add id to the end of params
			$db->query($sql, $params);
			return $this;
		} else {
			unset($data['id']); // Ensure id is not included in insert
			return static::create($data);
		}

		
	}
	public function delete(): void {
		if (!isset($this->id)) {
			return;
		}
		$db = App::get('database');
		$db->query("DELETE FROM " . static::$table . " WHERE id = ?", [$this->id]);
	}

	public static function getRecent(
		?int $limit = null, 
		?int $page = null) {
		/** 
		 * @var \Core\Database $db 
		 * */
		$query = "SELECT * FROM " . static::$table;
		$params = [];


		$query .= " ORDER BY created_at DESC";

		if (null !== $limit){
			$query .= " LIMIT ?";
			$params[] = $limit;
		}

		if ($page !== null && $limit !== null){
			$offset = ($page -1) * $limit;
			$query .= " OFFSET ?";
			$params[] = $offset;
		}

		$db = App::get('database');
		return $db->fetchAll($query,	$params, static::class);
	}

	public static function count(): int {
		/** @var \Core\Database $db */
		$query = "SELECT COUNT(*) FROM " . static::$table;
		$db = App::get('database');
		return (int) $db->query($query,	[])->fetchColumn(0);
	}

	// protected static function createFromArray(array $data): static {
	// 	$model = new static();
	// 	foreach($data as $key => $value){
	// 		if (property_exists($model, $key)){
	// 			$model->$key = $value;
	// 		}
	// 	}
	// 	return $model;
	// }
}