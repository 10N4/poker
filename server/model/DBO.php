<?php


namespace poker_model;


abstract class DBO
{
	private const ID = "id";

	private $values = array();

	public function __construct()
	{
		$this->values[self::ID] = 0;
	}

	// region DB Control

	public static function loadById($id): DBO
	{
		return self::load(self::ID, $id)[0];
	}

	public static function load($field, $value, $options = array()): array
	{
		return array();
	}

	public function create(): void
	{

	}

	public function update(): void
	{

	}

	public function delete(): void
	{

	}

	// endregion

	// region getter and setter

	public function getId(): int
	{
		return $this->values[self::ID];
	}

	public function isCreated(): bool
	{
		return $this->values[self::ID] == 0;
	}

	protected function getValue($field)
	{
		return $this->values[$field];
	}

	protected function setValue($field, $value)
	{
		$this->values[$field] = $value;
	}

	// endregion

	// region helper

	public static function forEachInstance($fun): void
	{

	}

	// endregion
}