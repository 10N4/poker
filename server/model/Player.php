<?php


namespace poker_model;


class Player extends DBO
{
	private const NAME = "name";
	private const CARD1 = "card1";
	private const CARD2 = "card2";
	private const MONEY = "money";
	private const WAGER = "wager";
	private const IS_UPDATED = "is_updated";

	//region getter and setter

	public function getName()
	{
		return $this->getValue(self::NAME);
	}

	public function setName($name)
	{
		$this->setValue(self::NAME, $name);
	}

	public function getCard1()
	{
		return $this->getValue(self::CARD1);
	}

	public function setCard1($card1)
	{
		$this->setValue(self::CARD1, $card1);
	}

	public function getCard2()
	{
		return $this->getValue(self::CARD2);
	}

	public function setCard2($card2)
	{
		$this->setValue(self::CARD2, $card2);
	}

	public function getMoney()
	{
		return $this->getValue(self::MONEY);
	}

	public function setMoney($money)
	{
		$this->setValue(self::MONEY, $money);
	}

	public function getWager()
	{
		return $this->getValue(self::WAGER);
	}

	public function setWager($wager)
	{
		$this->setValue(self::WAGER, $wager);
	}


	public function isUpdated(): bool
	{
		return $this->getValue(self::IS_UPDATED);
	}

	public function setUpdated($flag): void
	{
		$this->setValue(self::IS_UPDATED, $flag);
	}

	// endregion

	public static function setAllUnUpdated(): void
	{
		/**
		 * @param Player $player
		 */
		$setUpdateFalse = function ($player) {
			$player->setUpdated(false);
		};
		static::forEachInstance($setUpdateFalse);
	}

	protected static function getTable()
	{
		return "poker_player";
	}

	protected static function getColumns()
	{
		return "poker_player";
	}
}