<?php


namespace poker_model;


class Player extends DBO
{
    // region DB Fields
    const AUTHENTICATION_ID = "authentication_id";
    const NAME              = "name";
    const SESSION_ID        = "session_id";
    const CARD1             = "card1";
    const CARD2             = "card2";
    const MONEY             = "money";
    const CURRENT_BET       = "current_bet";
    const TOTAL_BET         = "total_bet";
    const IS_PAUSED         = "is_paused";
    const SET_ACTIVE_TIME   = "set_active_time";
    const LAST_UPDATE_TIME  = "last_update_time";

    // endregion

    //region getter and setter

    public function getName()
    {
        return $this->getValue(self::NAME);
    }

    private function setName($name)
    {
        $this->setValue(self::NAME, $name);
    }

    public function getSessionId()
    {
        return $this->getValue(self::NAME);
    }

    private function setSessionId($sessionId)
    {
        $this->setValue(self::SESSION_ID, $sessionId);
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

    public function getAuthenticationId()
    {
        return $this->getValue(self::AUTHENTICATION_ID);
    }

    private function setAuthenticationId($authenticationId)
    {
        $this->setValue(self::AUTHENTICATION_ID, $authenticationId);
    }

    public function getCard1()
    {
        return $this->getValue(self::CARD1);
    }

    private function setCard1($card1)
    {
        $this->setValue(self::CARD1, $card1);
    }

    public function getCard2()
    {
        return $this->getValue(self::CARD2);
    }

    private function setCard2($card2)
    {
        $this->setValue(self::CARD2, $card2);
    }

    public function getMoney()
    {
        return $this->getValue(self::MONEY);
    }

    private function setMoney($money)
    {
        $this->setValue(self::MONEY, $money);
    }

    public function getCurrentBet()
    {
        return $this->getValue(self::CURRENT_BET);
    }

    private function setCurrentBet($currentBet)
    {
        $this->setValue(self::CURRENT_BET, $currentBet);
    }

    public function getTotalBet()
    {
        return $this->getValue(self::TOTAL_BET);
    }

    private function setTotalBet($totalBet)
    {
        $this->setValue(self::TOTAL_BET, $totalBet);
    }

    public function raiseBet($amount)
    {
        $this->setCurrentBet($this->getCurrentBet() + $amount);
        $this->setTotalBet($this->getTotalBet() + $amount);
    }

    public function clearCurrentBet()
    {
        $this->setCurrentBet(0);
    }

    public function isUpdated()
    {
        return $this->getValue(self::IS_UPDATED);
    }

    public function setUpdated($flag)
    {
        $this->setValue(self::IS_UPDATED, $flag);
    }

    public function getLastUpdateTime()
    {
        return $this->getValue(self::LAST_UPDATE_TIME);
    }

    public function setLastUpdateTime(int $time)
    {
        $this->setValue(self::LAST_UPDATE_TIME, $time);
    }

    public function getSetActiveTime()
    {
        return $this->getValue(self::SET_ACTIVE_TIME);
    }

    public function setSetActiveTime(int $time)
    {
        $this->setValue(self::SET_ACTIVE_TIME, $time);
    }

    // endregion

    /**
     * Sets the bet of the player on the highest bet in the round
     */
    public function equalizeBet()
    {
        $players = $this->getAllPlayers();
        $maxBet = 0;
        /** @var Player $player */
        foreach ($players as $player) {
            if ($player->getCurrentBet() > $maxBet) {
                $maxBet = $player->getCurrentBet();
            }
        }
        $this->setCurrentBet($maxBet);
    }

    /**
     * Returns true, if the player is the dealer, returns false otherwise
     * @return bool
     */
    public function isDealer()
    {
        $session = $this->getSession();
        $dealerId = $session->getDealer();
        return $this->getId() == $dealerId;
    }

    /**
     * Sets the next active player by the order in the database (ordered by the id).
     * If this player has the highest id in the session, the next active player is the one with the lowest.
     * The method assumes the sessions state is a 'round-sate' and this player is the active one actually.
     */
    public function setNextPlayerActive() {
        $players = $this->getAllPlayers();
        $lastPlayersIndex = count($players) - 1;
        if ($lastPlayersIndex < 1) {
            return;
        }
        $nextPlayerId = 0;
        for ($i = 0; $i <= $lastPlayersIndex; $i++) {
            if ($players[$i]->getId() != $this->getId()) {
                continue;
            }
            if ($i == $lastPlayersIndex) {
                $nextPlayerId = $players[0]->getId();
            } else {
                $nextPlayerId = $i;
            }
            break;
        }
        $this->setActive(false);
        /** @var Player $nextPlayer */
        $nextPlayer = Player::loadById($nextPlayerId);
        $nextPlayer->setActive(true);
        $nextPlayer->update();
    }

    /**
     * Sets the is_updated field of all players of the session false
     */
    public static function setAllUnUpdated($sessionId): void
    {
        /**
         * @param Player $player
         */
        $setUpdateFalse = function ($player) {
            $player->setUpdated(false);
        };
        /*$load = function() {
            Player::load(self::SESSION_ID, $sessionId)
        }
        static::forEachInstance($setUpdateFalse, );*/
    }

    /**
     * Returns the player with the given authentication_id
     * @param $globalPlayerId
     * @return Player
     */
    public static function loadPlayerByAuthenticationId($globalPlayerId): Player
    {
        return Player::load(self::AUTHENTICATION_ID, $globalPlayerId)[0];
    }

    /**
     * Returns an array with all players of the session with the given id
     * @param $sessionId
     * @return array
     */
    public static function getPlayersBySessionId($sessionId)
    {
        return Player::load(self::SESSION_ID, $sessionId);
    }

    /**
     * Returns an array with all players of the same session this player belongs to including this player
     * @return array
     */
    public function getAllPlayers()
    {
        return self::getPlayersBySessionId($this->getId());
    }

    /**
     * Returns an array with all players that are active session independently
     * @return array
     */
    public static function getActivePlayers()
    {
        return Player::load(Player::IS_ACTIVE, true);
    }

    /**
     * Returns the session of the player
     * @return Session
     */
    public function getSession(): Session
    {
        return Session::loadById($this->getSessionId());
    }

    /**
     * Returns the cards of the player
     * @return array
     */
    public function getCards()
    {
        return array($this->getCard1(), $this->getCard2());
    }

    /**
     * Initializes a new Player and returns it
     * This function replaces the constructor
     * @param string $name
     * @param Session $session
     * @return Player
     */
    public static function init(string $name, Session $session): Player
    {
        $player = new Player();

        $player->setName($name);

        $player->setSessionId($session->getId());
        $player->setActive(false);
        $player->setPaused(false);

        $cookieId = '';
        $cookieIdExists = true;
        while ($cookieIdExists) {
            $cookieId = generateRandomString();
            if (self::loadPlayerByAuthenticationId($cookieId) == null) {
                $cookieIdExists = false;
            }
        }
        $player->setAuthenticationId($cookieId);
        $deck = new CardDeckManager();
        $cards = $deck->getRandomCardsBySession($player->getSessionId(), 2);
        $player->setCard1($cards[0]);
        $player->setCard2($cards[1]);
        $player->setMoney($session->getStartMoney());
        $player->setCurrentBet(0);
        $player->setTotalBet(0);
        $player->setUpdated(false);

        return $player;
    }

    protected static function getTable(): string
    {
        return 'poker_player';
    }

    protected static function getColumns(): array
    {
        return array(
            self::NAME,
            self::SESSION_ID,
            self::IS_ACTIVE,
            self::IS_PAUSED,
            self::AUTHENTICATION_ID,
            self::CARD1,
            self::CARD2,
            self::MONEY,
            self::CURRENT_BET,
            self::TOTAL_BET,
            self::IS_UPDATED,
            self::SET_ACTIVE_TIME,
            self::LAST_UPDATE_TIME,
        );
    }
}