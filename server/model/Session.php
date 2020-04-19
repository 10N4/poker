<?php


namespace poker_model;

require_once "DBO.php";


class Session extends DBO
{
    const MAX_PLAYER_COUNT = 8;
    const MIN_PLAYER_COUNT = 2;

    const STATE_NOT_STARTED = 0;
    const STATE_ROUND_BET_CHECK = 1;
    const STATE_ROUND_RAISE_CALL = 2;
    const STATE_SHOWDOWN = 3;
    const STATE_FINISHED = 4;

    const TIME_GENERAL_BUFFER = 5;
//    const TIME_TO_UPDATE = 10;
    const TIME_MAKE_MOVE = 15;
    const TIME_START_ROUND = 20;

    const OPEN_CARDS_0 = 0;
    const OPEN_CARDS_3 = 3;
    const OPEN_CARDS_4 = 4;
    const OPEN_CARDS_5 = 5;

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
    const POT = 'pot';
    const DEALER = 'dealer';
    const PLAYER_LAST_RAISED = 'player_last_raised';
    const OPEN_CARDS = 'open_cards';

    // region Getter und Setter

    /**
     * @return string
     */
    public function getGlobalId(): string
    {
        return $this->getValue(self::GLOBAL_ID);
    }

    /**
     * @param string $globalId
     */
    public function setGlobalId($globalId): void
    {
        $this->setValue(self::GLOBAL_ID, $globalId);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getValue(self::NAME);
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->setValue(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getStartMoney(): string
    {
        return $this->getValue(self::START_MONEY);
    }

    /**
     * @param string $startMoney
     */
    public function setStartMoney($startMoney): void
    {
        $this->setValue(self::START_MONEY, $startMoney);
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->getValue(self::START_DATE);
    }

    /**
     * @param int $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->setValue(self::START_DATE, $startDate);
    }

    /**
     * @return string
     */
    public function getCard1(): string
    {
        return $this->getValue(self::CARD1);
    }

    /**
     * @param string $card1
     */
    public function setCard1($card1): void
    {
        $this->setValue(self::CARD1, $card1);
    }

    /**
     * @return string
     */
    public function getCard2(): string
    {
        return $this->getValue(self::CARD2);
    }

    /**
     * @param string $card2
     */
    public function setCard2($card2): void
    {
        $this->setValue(self::CARD2, $card2);
    }

    /**
     * @return string
     */
    public function getCard3(): string
    {
        return $this->getValue(self::CARD3);
    }

    /**
     * @param string $card3
     */
    public function setCard3($card3): void
    {
        $this->setValue(self::CARD3, $card3);
    }

    /**
     * @return string
     */
    public function getCard4(): string
    {
        return $this->getValue(self::CARD4);
    }

    /**
     * @param string $card4
     */
    public function setCard4($card4): void
    {
        $this->setValue(self::CARD4, $card4);
    }

    /**
     * @return string
     */
    public function getCard5(): string
    {
        return $this->getValue(self::CARD5);
    }

    /**
     * @param string $card5
     */
    public function setCard5($card5): void
    {
        $this->setValue(self::CARD5, $card5);
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->getValue(self::STATE);
    }

    /**
     * @param int $state
     */
    public function setState($state): void
    {
        $this->setValue(self::STATE, $state);
    }

    public function getRound()
    {
        return $this->getValue(self::ROUND);
    }

    /**
     * @param int $round
     */
    public function setRound($round): void
    {
        $this->setValue(self::ROUND, $round);
    }

    public function increaseRound(): void
    {
        $this->setRound($this->getRound() + 1);
    }

    public function getPot()
    {
        return $this->getValue(self::POT);
    }

    /**
     * @param int $pod
     */
    public function setPot(int $pod): void
    {
        $this->setValue(self::POT, $pod);
    }

    public function raisePotBy(int $amount): void
    {
        $pot = $this->getPot();
        $this->setPot($pot + $amount);
    }

    /**
     * @return string
     */
    public function getDealer(): string
    {
        return $this->getValue(self::DEALER);
    }

    /**
     * @param string $dealerId
     */
    public function setDealer($dealerId): void
    {
        $this->setValue(self::DEALER, $dealerId);
    }

    /**
     * @return string
     */
    public function getPlayerLastRaised(): string
    {
        return $this->getValue(self::PLAYER_LAST_RAISED);
    }

    /**
     * @param string $player_last_raised
     */
    public function setPlayerLastRaised($player_last_raised): void
    {
        $this->setValue(self::PLAYER_LAST_RAISED, $player_last_raised);
    }

    /**
     * @return string
     */
    public function getOpenCards(): string
    {
        return $this->getValue(self::OPEN_CARDS);
    }

    /**
     * @param string $openCards
     */
    public function setOpenCards($openCards): void
    {
        $this->setValue(self::OPEN_CARDS, $openCards);
    }

    // endregion

    public function setNextRound()
    {
        switch ($this->getState()) {
            case self::STATE_NOT_STARTED:
            case self::STATE_SHOWDOWN:
                $this->setPot(0);
                break;
            case self::STATE_ROUND_BET_CHECK:
            case self::STATE_ROUND_RAISE_CALL:
                $players = Player::getPlayersBySessionId($this->getId());
                /** @var Player $player */
                foreach ($players as $player) {
                    $this->raisePotBy($player->getCurrentBet());
                    $player->clearCurrentBet();
                    $this->increaseRound();
                    $player->update();
                }
                break;
        }
    }

    public function isFull()
    {
        $players = Player::getPlayersBySessionId($this->getId());
        if (count($players) >= self::MAX_PLAYER_COUNT) {
            return true;
        }
        return false;
    }

    public function hasEnoughPlayers()
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
        $cards = array($this->getCard1(), $this->getCard2(), $this->getCard3());
        if ($this->getOpenCards() >= 4) {
            $cards[$this->getCard4()];
        }
        if ($this->getOpenCards() == 5) {
            $cards[$this->getCard5()];
        }
        return $cards;
    }

    public static function getSessionByGlobalId($link): Session
    {
        return Session::load(self::GLOBAL_ID, $link)[0];
    }

    /**
     * Initializes a new Session and returns it
     * @param string $name
     * @param int $startMoney
     * @return Session
     */
    public static function init(string $name, int $startMoney): Session
    {
        /** @var Session $session */
        $session = new Session();
        $session->setName($name);

        $globalId = '';
        $linkExists = true;
        while ($linkExists) {
            $globalId = generateRandomString();
            if (self::getSessionByGlobalId($globalId) == null) {
                $linkExists = false;
            }
        }
        $session->setGlobalId($globalId);

        $session->setStartDate(time());

        $deck = new CardDeckManager();
        $cards = $deck->getRandomCards(5);

        $session->setCard1($cards[0]->__toString());
        $session->setCard2($cards[1]->__toString());
        $session->setCard3($cards[2]->__toString());
        $session->setCard4($cards[3]->__toString());
        $session->setCard5($cards[4]->__toString());

        $session->setState(self::STATE_NOT_STARTED);
        $session->setStartMoney($startMoney);
        $session->setPot(0);
        $session->setDealer(0);
        $session->setOpenCards(self::OPEN_CARDS_0);

        return $session;
    }

    protected static function getTable(): string
    {
        return "sessions";
    }

    protected static function getColumns(): array
    {
        return array(
            self::NAME,
            self::GLOBAL_ID,
            self::START_DATE,
            self::CARD1,
            self::CARD2,
            self::CARD3,
            self::CARD4,
            self::CARD5,
            self::STATE,
            self::START_MONEY,
            self::POT,
            self::DEALER,
            self::PLAYER_LAST_RAISED,
            self::OPEN_CARDS,
        );
    }
}