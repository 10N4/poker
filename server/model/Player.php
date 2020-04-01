<?php


namespace poker_model;


class Player extends DBO
{
    const NAME = "name";
    const GAME_ID = "game_id";
    const IS_ACTIVE = "is_active";
    const IS_PAUSED = "is_paused";
    const COOKIE_ID = "cookie_id";
    const CARD1 = "card1";
    const CARD2 = "card2";
    const MONEY = "money";
    const CURRENT_BET = "current_bet";
    const TOTAL_BET = "total_bet";
    const IS_UPDATED = "is_updated";

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

    public function getCards()
    {
        return array($this->getCard1(), $this->getCard2());
    }

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

    public static function getPlayerByCookieId($cookieId)
    {
        return Player::load(self::COOKIE_ID, $cookieId);
    }

    public static function init($name, $link): Player
    {
        $player = new Player();

        $player->setName($name);
        /** @var Game $game */
        $game = Game::getGameByLink($link);
        $player->setGameId($game->getId());
        $player->setActive(false);
        $player->setPaused(false);

        $cookieId = '';
        $cookieIdExists = true;
        while ($cookieIdExists) {
            $cookieId = generateRandomString();
            if (self::getPlayerByCookieId($cookieId) == null) {
                $cookieIdExists = false;
            }
        }
        $player->setCookieId($cookieId);
        $deck = new CardDeckManager();
        $cards = $deck->getRandomCardsByGame($player->getGameId(), 2);
        $player->setCard1($cards[0]);
        $player->setCard2($cards[1]);
        $player->setMoney($game->getStartMoney());
        $player->setCurrentBet(0);
        $player->setTotalBet(0);
        $player->setUpdated(false);
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