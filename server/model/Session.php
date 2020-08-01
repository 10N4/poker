<?php


namespace poker_model;

require_once "DBO.php";
require_once "CardDeckManager.php";

class Session extends DBO
{
    const MAX_PLAYER_COUNT = 8;
    const MIN_PLAYER_COUNT = 2;

    const STATE_NOT_STARTED = 0;
    const STATE_BET_CHECK = 1;
    const STATE_RAISE_CALL = 2;
    const STATE_SHOWDOWN = 3;
    const STATE_FINISHED = 4;

    const TIME_GENERAL_BUFFER = 5;
    const TIME_TO_UPDATE = 10;
    const TIME_MAKE_MOVE = 15;
    const TIME_START_ROUND = 20;

    const ROUND_UNSET = -1;
    const ROUND_OPEN_CARDS_0 = 0;
    const ROUND_OPEN_CARDS_3 = 3;
    const ROUND_OPEN_CARDS_4 = 4;
    const ROUND_OPEN_CARDS_5 = 5;

    const AMOUNT_SMALL_BLIND = 5;

    const GLOBAL_ID = 'global_id';
    const NAME = 'name';
    const START_MONEY = 'start_money';
    const START_DATE = 'start_date';
    const CARD1 = 'card1';
    const CARD2 = 'card2';
    const CARD3 = 'card3';
    const CARD4 = 'card4';
    const CARD5 = 'card5';
    const STATE = 'state';
    const ROUND = 'round';
    const POD = 'pod';
    const DEALER = 'dealer';
    const PLAYER_LAST_RAISED = 'player_last_raised';

    // region Getter und Setter

    public function getGlobalId(): string
    {
        return $this->getValue(self::GLOBAL_ID);
    }

    public function setGlobalId($globalId): void
    {
        $this->setValue(self::GLOBAL_ID, $globalId);
    }

    public function getName(): string
    {
        return $this->getValue(self::NAME);
    }

    public function setName($name): void
    {
        $this->setValue(self::NAME, $name);
    }

    public function getStartMoney(): string
    {
        return $this->getValue(self::START_MONEY);
    }

    public function setStartMoney($startMoney): void
    {
        $this->setValue(self::START_MONEY, $startMoney);
    }

    public function getStartDate(): string
    {
        return $this->getValue(self::START_DATE);
    }

    public function setStartDate($startDate): void
    {
        $this->setValue(self::START_DATE, $startDate);
    }

    public function getCard1Rep(): string
    {
        return $this->getValue(self::CARD1);
    }

    public function setCard1($card1): void
    {
        $this->setValue(self::CARD1, $card1);
    }

    public function getCard2Rep(): string
    {
        return $this->getValue(self::CARD2);
    }

    public function setCard2($card2): void
    {
        $this->setValue(self::CARD2, $card2);
    }

    public function getCard3Rep(): string
    {
        return $this->getValue(self::CARD3);
    }

    public function setCard3($card3): void
    {
        $this->setValue(self::CARD3, $card3);
    }

    public function getCard4Rep(): string
    {
        return $this->getValue(self::CARD4);
    }

    public function setCard4($card4): void
    {
        $this->setValue(self::CARD4, $card4);
    }

    public function getCard5Rep(): string
    {
        return $this->getValue(self::CARD5);
    }

    public function setCard5($card5): void
    {
        $this->setValue(self::CARD5, $card5);
    }

    public function getState(): string
    {
        return $this->getValue(self::STATE);
    }

    public function setState($state): void
    {
        $this->setValue(self::STATE, $state);
    }

    public function getRound()
    {
        return $this->getValue(self::ROUND);
    }

    public function setRound($round): void
    {
        $this->setValue(self::ROUND, $round);
    }

    public function getPod()
    {
        return $this->getValue(self::POD);
    }

    public function setPod(int $pod): void
    {
        $this->setValue(self::POD, $pod);
    }

    public function getDealerId(): string
    {
        return $this->getValue(self::DEALER);
    }

    public function setDealerId($dealerId): void
    {
        $this->setValue(self::DEALER, $dealerId);
    }

    public function getPlayerLastRaisedId(): string
    {
        return $this->getValue(self::PLAYER_LAST_RAISED);
    }

    public function setPlayerLastRaisedId($playerLastRaisedId): void
    {
        $this->setValue(self::PLAYER_LAST_RAISED, $playerLastRaisedId);
    }

    // endregion

    // region Advanced Setter

    public function raisePodBy(int $amount): void
    {
        $this->setPod($this->getPod() + $amount);
    }

    public function setNextRound()
    {
        switch ($this->getState()) {
            case self::STATE_NOT_STARTED:
            case self::STATE_SHOWDOWN:
                $this->startFirstRoundOfGame();
                break;
            case self::STATE_BET_CHECK:
            case self::STATE_RAISE_CALL:
                $this->startNextRoundOfGame();
                break;
        }
    }

    private function startFirstRoundOfGame()
    {
        $players = $this->getPlayersAtTable();

        $this->setPod(0);
        $this->setRound(self::ROUND_OPEN_CARDS_0);
        $this->setState(self::STATE_RAISE_CALL);

        $cardDeckManager = new CardDeckManager();
        $cards = $cardDeckManager->getRandomCards(5);
        $this->setCard1($cards[0]->__toString());
        $this->setCard2($cards[1]->__toString());
        $this->setCard3($cards[2]->__toString());
        $this->setCard4($cards[3]->__toString());
        $this->setCard5($cards[4]->__toString());

        /** @var Player $player */
        foreach ($players as $player) {
            $player->clearCurrentBet();
            $player->clearTotalBet();
            $player->setInActive();
            $player->setCards($cardDeckManager);
            $player->update();
        }

        if ($this->getDealerId() == DBO::ID_NOT_CREATED) {
            $this->setDealerId($players[0]->getId());
        } else {
            $dealer = Player::getById($this->getDealerId());
            $this->setDealerId($dealer->getNextPlayer()->getId());
        }

        $roles = $this->getRoles();
        /** @var Player $smallBlind */
        $smallBlind = $roles[Player::ROLE_SMALL_BLIND];
        $smallBlind->raiseBet(self::AMOUNT_SMALL_BLIND);
        $smallBlind->update();

        /** @var Player $bigBlind */
        $bigBlind = $roles[Player::ROLE_BIG_BLIND];
        $bigBlind->raiseBet(2 * self::AMOUNT_SMALL_BLIND);
        $bigBlind->update();

        $activePlayer = $bigBlind->getNextPlayer();
        $activePlayer->setActive();
        $activePlayer->update();
    }

    private function startNextRoundOfGame()
    {
        if ($this->getRound() == self::ROUND_OPEN_CARDS_5) {
            $this->startShowdown();
            return;
        }

        $this->setRound($this->getNextRound());
        $this->setState(self::STATE_BET_CHECK);

        $players = $this->getPlayersInGame();
        /** @var Player $player */
        foreach ($players as $player) {
            $this->raisePodBy($player->getCurrentBet());
            $player->clearCurrentBet();
            $player->setInActive();
            $player->update();
        }

        /** @var Player $dealer */
        $dealer = $this->getRoles()[Player::ROLE_DEALER];
        $activePlayer = $dealer->getNextPlayer();
        $activePlayer->setActive();
        $activePlayer->update();
    }

    private function startShowdown()
    {
        $this->setState(self::STATE_SHOWDOWN);
        $this->setRound(self::ROUND_UNSET);
        $players = $this->getPlayersInGame();
        /** @var Player $player */
        foreach ($players as $player) {
            $this->raisePodBy($player->getCurrentBet());
            $player->clearCurrentBet();
            $player->setActive();
            $player->update();
        }
    }

    // endregion

    // region Advanced Getter

    private function getNextRound()
    {
        switch ($this->getRound()) {
            case self::ROUND_OPEN_CARDS_0:
                return self::ROUND_OPEN_CARDS_3;
                break;
            case self::ROUND_OPEN_CARDS_3:
                return self::ROUND_OPEN_CARDS_4;
                break;
            case self::ROUND_OPEN_CARDS_4:
                return self::ROUND_OPEN_CARDS_5;
                break;
            case self::ROUND_OPEN_CARDS_5:
                return self::ROUND_OPEN_CARDS_0;
                break;
            default:
                return false;
        }
    }

    public function areAllBetsEqual()
    {
        $players = $this->getPlayersInGame();
        /** @var Player $player */
        $player = $players[0];
        $compareBet = $player->getCurrentBet();
        foreach ($players as $player) {
            if ($player->getCurrentBet() != $compareBet) {
                return false;
            }
        }
        return true;
    }

    public function isFull()
    {
        $players = Player::getPlayersBySessionId($this->getId());
        if (count($players) >= self::MAX_PLAYER_COUNT - 1) {
            return true;
        }
        return false;
    }

    public function hasEnoughPlayers(): bool
    {
        $players = Player::getPlayersBySessionId($this->getId());
        if (count($players) >= self::MIN_PLAYER_COUNT) {
            return true;
        }
        return false;
    }

    public function getLink()
    {
        return "/index.php?global-session-id=" . $this->getGlobalId();
    }

    public function getCards()
    {
        switch ($this->getRound()) {
            case self::ROUND_OPEN_CARDS_0:
                return array();
                break;
            case self::ROUND_OPEN_CARDS_3:
                return array(
                    $this->getCard1Rep(),
                    $this->getCard2Rep(),
                    $this->getCard3Rep()
                );
                break;
            case self::ROUND_OPEN_CARDS_4:
                return array(
                    $this->getCard1Rep(),
                    $this->getCard2Rep(),
                    $this->getCard3Rep(),
                    $this->getCard4Rep(),
                );
                break;
            case self::ROUND_OPEN_CARDS_5:
                return array(
                    $this->getCard1Rep(),
                    $this->getCard2Rep(),
                    $this->getCard3Rep(),
                    $this->getCard4Rep(),
                    $this->getCard5Rep(),
                );
            default:
                return array();
        }
    }

    public function getAllUsedCards()
    {
        $usedCards = array(
            $this->getCard1Rep(),
            $this->getCard2Rep(),
            $this->getCard3Rep(),
            $this->getCard4Rep(),
            $this->getCard5Rep(),
        );
        arrayDeleteElementsByValue($usedCards, Card::REP_NO_CARD);
        $players = Player::getPlayersBySessionId($this->getId());
        /** @var Player $player */
        foreach ($players as $player) {
            $usedCards[] = $player->getCard1();
            $usedCards[] = $player->getCard2();
        }
        return $usedCards;
    }

    public function getRoles()
    {
        $dealerId = $this->getDealerId();
        $dealer = Player::getById($dealerId);
        $smallBlind = $dealer->getNextPlayer();
        $bigBlind = $smallBlind->getNextPlayer();

        return array(
            Player::ROLE_DEALER => $dealer,
            Player::ROLE_SMALL_BLIND => $smallBlind,
            Player::ROLE_BIG_BLIND => $bigBlind,
        );
    }

    public function getPlayersInGame()
    {
        $result = array();
        $players = Player::getPlayersBySessionId($this->getId());
        /** @var Player $player */
        foreach ($players as $player) {
            if ($player->hasState(Player::STATE_IN_GAME_INACTIVE)
                || $player->hasState(Player::STATE_IN_GAME_ACTIVE)) {
                $result[] = $player;
            }
        }
        return $result;
    }

    public function getPlayersAtTable()
    {
        $result = array();
        $players = Player::getPlayersBySessionId($this->getId());
        /** @var Player $player */
        foreach ($players as $player) {
            if ($player->hasState(Player::STATE_AT_THE_TABLE)
                || $player->hasState(Player::STATE_IN_GAME_INACTIVE)
                || $player->hasState(Player::STATE_IN_GAME_ACTIVE)) {
                $result[] = $player;
            }
        }
        return $result;
    }

    /**
     * Returns an instance of Session by the its global id
     * @param $link
     * @return bool|Session
     */
    public static function getSessionByGlobalId($link)
    {
        $session = Session::get(self::GLOBAL_ID, $link);
        if (!empty($session)) {
            return $session[0];
        }
        return false;
    }

    // endregion

    // region base

    /**
     * Initializes a new Session and returns it
     * @param string $name
     * @param int $startMoney
     * @return Session
     */
    public static function init(string $name, int $startMoney): Session
    {
        $session = new Session();

        $session->setGlobalId(generateUniqueString());
        $session->setName($name);
        $session->setStartMoney($startMoney);
        $session->setStartDate(time());
        $session->setCard1(Card::REP_NO_CARD);
        $session->setCard2(Card::REP_NO_CARD);
        $session->setCard3(Card::REP_NO_CARD);
        $session->setCard4(Card::REP_NO_CARD);
        $session->setCard5(Card::REP_NO_CARD);
        $session->setState(self::STATE_NOT_STARTED);
        $session->setRound(self::ROUND_UNSET);
        $session->setPod(0);
        $session->setDealerId(DBO::ID_NOT_CREATED);
        $session->setPlayerLastRaisedId(DBO::ID_NOT_CREATED);

        return $session;
    }

    protected static function getTable(): string
    {
        return "sessions";
    }

    protected static function getColumns(): array
    {
        return array(
            self::GLOBAL_ID,
            self::NAME,
            self::START_MONEY,
            self::START_DATE,
            self::CARD1,
            self::CARD2,
            self::CARD3,
            self::CARD4,
            self::CARD5,
            self::STATE,
            self::ROUND,
            self::POD,
            self::DEALER,
            self::PLAYER_LAST_RAISED,
        );
    }

    public static function getById($id): Session
    {
        return parent::getById($id);
    }

    public function __construct()
    {
    }

    // endregion
}