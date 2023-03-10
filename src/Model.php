<?php

declare(strict_types = 1);

namespace Framework;

use Framework\Database;
use PDOException;

abstract class Model
{
	public array $values = [];
	private $db;

	public function __construct() {
		$this->db = Database::connect();
	}

	public function get(int $id = null): array|false {
		$table = $this->table;
		$sql = "SELECT * FROM $table";

		if (!is_null($id)) {
			$sql .= " WHERE id = $id";
		}

		$query = $this->db->query($sql);

		return $query->fetchAll();
	}

	public function create(): bool {
		$table = $this->table;
		$fields = $this->fields;
		$params = array_map(fn ($val) => ":$val", $fields);

		$sql = $this->db->prepare("INSERT INTO $table (" . implode(',', $fields) . ") VALUES (" . implode(',', $params) . ")");

		foreach ($fields as $key => $field) {
			$sql->bindValue(":$field", $this->values[$key]);
		}

		return $sql->execute();
	}
}
