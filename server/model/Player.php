<?php


namespace poker_model;


class Player extends DBO
{
    private const NAME = "name";
    private const GAME_ID = "game_id";
    private const IS_ACTIVE = "is_active";
    private const IS_PAUSED = "is_paused";
    private const COOKIE_ID = "cookie_id";
    private const CARD1 = "card1";
    private const CARD2 = "card2";
    private const MONEY = "money";
    private const CURRENT_BET = "current_bet";
    private const TOTAL_BET = "total_bet";
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

    public function getGameId()
    {
        return $this->getValue(self::NAME);
    }

    public function setGameId($gameId)
    {
        $this->setValue(self::GAME_ID, $gameId);
    }

    public function isActive()
    {
        return $this->getValue(self::IS_ACTIVE);
    }

    public function setActive($flag)
    {
        $this->setValue(self::IS_ACTIVE, $flag);
    }

    public function isPaused()
    {
        return $this->getValue(self::IS_PAUSED);
    }

    public function setPaused($flag)
    {
        $this->setValue(self::IS_PAUSED, $flag);
    }

    public function getCookieId()
    {
        return $this->getValue(self::COOKIE_ID);
    }

    public function setCookieId($cookieId)
    {
        $this->setValue(self::COOKIE_ID, $cookieId);
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

    public function getCurrentBet()
    {
        return $this->getValue(self::CURRENT_BET);
    }

    public function setCurrentBet($currentBet)
    {
        $this->setValue(self::CURRENT_BET, $currentBet);
    }

    public function getTotalBet()
    {
        return $this->getValue(self::TOTAL_BET);
    }

    public function setTotalBet($totalBet)
    {
        $this->setValue(self::TOTAL_BET, $totalBet);
    }

    public function isUpdated()
    {
        return $this->getValue(self::IS_UPDATED);
    }

    public function setUpdated($flag)
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

    protected static function getTable(): string
    {
        return "poker_player";
    }

    protected static function getColumns(): array
    {
        return "poker_player";
    }
}