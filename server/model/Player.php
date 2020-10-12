<?php


namespace poker_model;


class Player extends DBO
{
    const STATE_LOBBY = 0;
    const STATE_WATCHING = 1;
    const STATE_AT_THE_TABLE = 2;
    const STATE_IN_GAME_INACTIVE = 3;
    const STATE_IN_GAME_ACTIVE = 4;

    const ROLE_DEALER = 0;
    const ROLE_SMALL_BLIND = 1;
    const ROLE_BIG_BLIND = 2;

    const ACTION_ENTER = 0;
    const ACTION_PAUSE = 1;
    const ACTION_EXIT = 2;
    const ACTION_CHECK = 3;
    const ACTION_BET = 4;
    const ACTION_CALL = 5;
    const ACTION_RAISE = 6;
    const ACTION_FOLD = 7;

    // region DB Fields
    const AUTHENTICATION_ID = "authentication_id";
    const NAME = "name";
    const SESSION_ID = "session_id";
    const CARD1 = "card1";
    const CARD2 = "card2";
    const MONEY = "money";
    const CURRENT_BET = "current_bet";
    const TOTAL_BET = "total_bet";
    const STATE = "state";
    const IS_UPDATED = "is_updated";
    const LAST_UPDATE_TIME = "last_update_time";
    const ACTIVE_TIME = "active_time";
    const LAST_ACTION = "last_action";

    private int $session = 0;

    // endregion

    //region getter and setter

    public function getAuthenticationId()
    {
        return $this->getValue(self::AUTHENTICATION_ID);
    }

    private function setAuthenticationId($authenticationId)
    {
        $this->setValue(self::AUTHENTICATION_ID, $authenticationId);
    }

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
        return $this->getValue(self::SESSION_ID);
    }

    private function setSessionId($sessionId)
    {
        $this->setValue(self::SESSION_ID, $sessionId);
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

    public function getState()
    {
        return $this->getValue(self::STATE);
    }

    public function setState($flag)
    {
        $this->setValue(self::STATE, $flag);
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
        return $this->getValue(self::ACTIVE_TIME);
    }

    private function setActiveTime(int $time)
    {
        $this->setValue(self::ACTIVE_TIME, $time);
    }

    public function getLastAction()
    {
        return $this->getValue(self::LAST_ACTION);
    }

    public function setLastAction($lastAction)
    {
        $this->setValue(self::LAST_ACTION, $lastAction);
    }

    // endregion

    public function hasState($state)
    {
        return $this->getState() == $state;
    }

    public function raiseBet($amount, $strict = true)
    {
        if (($this->getMoney() < $amount) && $strict) {
            return false;
        }
        $this->setMoney($this->getMoney() - $amount);
        $this->setCurrentBet($this->getCurrentBet() + $amount);
        $this->setTotalBet($this->getTotalBet() + $amount);
        $session = $this->getSession();
        $session->setPlayerLastRaisedId($this->getId());
        $session->update();
        return true;
    }

    public function clearCurrentBet()
    {
        $this->setCurrentBet(0);
    }

    public function clearTotalBet()
    {
        $this->setTotalBet(0);
    }

    /**
     * Sets the bet of the player on the highest bet in the round
     * @param bool $strict
     * @return bool
     */
    public function equalizeBet($strict = true)
    {
        $amount = $this->getHighestBet() - $this->getCurrentBet();
        return $this->raiseBet($amount, $strict);
    }

    /**
     * Returns true, if the player is the dealer, returns false otherwise
     * @return bool
     */
    public function isDealer()
    {
        $session = $this->getSession();
        $dealerId = $session->getDealerId();
        return $this->getId() == $dealerId;
    }

    /**
     * Sets the next active player by the order in the database (ordered by the id).
     * If this player has the highest id in the session, the next active player is the one with the lowest.
     * The method assumes the sessions state is a 'round-sate' and this player is the active one actually.
     */
    public function setNextPlayerActive()
    {
        $this->setInActive();
        $nextPlayer = $this->getNextPlayer();
        while ($nextPlayer->isAllIn()) {
            $nextPlayer = $nextPlayer->getNextPlayer();
        }
        $nextPlayer->setActive();
        $nextPlayer->update();
    }

    public function getNextPlayer(): Player
    {
        $session = $this->getSession();
        $players = $session->getPlayersInGame();
        $lastPlayersIndex = count($players) - 1;
        if ($lastPlayersIndex < 1) {
            dieFatalError('35038c0c-5edc-4786-8487-b8938aecd6d2');
        }

        $nextPlayerIndex = 0;
        for ($i = 0; $i < $lastPlayersIndex; $i++) {
            if ($players[$i]->getId() != $this->getId()) {
                continue;
            }
            $nextPlayerIndex = $i + 1;
            break;
        }
        return $players[$nextPlayerIndex];
    }

    public function setCards(CardDeckManager $cardDeckManager)
    {
        $cards = $cardDeckManager->getRandomCards(2);
        $this->setCard1($cards[0]->__toString());
        $this->setCard2($cards[1]->__toString());
    }

    /**
     * Returns the player with the given authentication_id
     * @param $globalPlayerId
     * @return Player|bool
     */
    public static function getPlayerByAuthenticationId($globalPlayerId)
    {
        $player = Player::get(self::AUTHENTICATION_ID, $globalPlayerId);
        if (!empty($player)) {
            return $player[0];
        }
        return false;
    }

    /**
     * Returns an array with all players of the session with the given id
     * @param $sessionId
     * @return array
     */
    public static function getPlayersBySessionId($sessionId)
    {
        return Player::get(self::SESSION_ID, $sessionId);
    }

    /**
     * Returns an array with all players of the same session this player belongs to including this player
     * @return array
     */
    public function getAllPlayers()
    {
        return self::getPlayersBySessionId($this->getSessionId());
    }

    /**
     * Returns an array with all players that are active session independently
     * @return array
     */
    public static function getActivePlayers()
    {
        return Player::get(Player::STATE, self::STATE_IN_GAME_ACTIVE);
    }

    /**
     * Returns the session of the player
     * @return Session
     */
    public function getSession(): Session
    {
        return Session::getById($this->getSessionId());
    }

    /**
     * Returns the cards of the player
     * @return array
     */
    public function getCards()
    {
        return array($this->getCard1(), $this->getCard2());
    }

    public function getHighestBet()
    {
        $players = $this->getAllPlayers();
        $maxBet = 0;
        /** @var Player $player */
        foreach ($players as $player) {
            if ($player->getCurrentBet() > $maxBet) {
                $maxBet = $player->getCurrentBet();
            }
        }
        return $maxBet;
    }

    public function setActive()
    {
        $this->setState(self::STATE_IN_GAME_ACTIVE);
        $this->setActiveTime(time());
    }

    public function setInActive()
    {
        $this->setState(self::STATE_IN_GAME_INACTIVE);
        $this->setActiveTime(0);
    }

    public function isAllIn(): bool
    {
        return $this->getMoney() < 0;
    }

    // region base

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

        $player->setAuthenticationId(generateUniqueString());
        $player->setName($name);
        $player->setSessionId($session->getId());
        $player->setCard1(Card::REP_NO_CARD);
        $player->setCard2(Card::REP_NO_CARD);
        $player->setMoney($session->getStartMoney());
        $player->setCurrentBet(0);
        $player->setTotalBet(0);
        $player->setState(self::STATE_AT_THE_TABLE);
        $player->setUpdated(false);
        $player->setLastUpdateTime(0);
        $player->setActiveTime(0);
        $player->setLastAction(self::ACTION_ENTER);

        return $player;
    }

    protected static function getTable(): string
    {
        return 'players';
    }

    protected static function getColumns(): array
    {
        return array(
            self::AUTHENTICATION_ID,
            self::NAME,
            self::SESSION_ID,
            self::CARD1,
            self::CARD2,
            self::MONEY,
            self::CURRENT_BET,
            self::TOTAL_BET,
            self::STATE,
            self::IS_UPDATED,
            self::LAST_UPDATE_TIME,
            self::ACTIVE_TIME,
            self::LAST_ACTION,
        );
    }

    public static function getById($id): Player
    {
        return parent::getById($id);
    }

    public function __construct()
    {
    }

    // endregion
}