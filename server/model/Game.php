<?php


namespace poker_model;

require_once "DBO.php";


class Game extends DBO
{
    const GAME_STATE_0 = 0;
    const GAME_STATE_1 = 1;
    const GAME_STATE_2 = 2;
    const GAME_STATE_3 = 3;

    const OPEN_CARDS_0 = 0;
    const OPEN_CARDS_3 = 3;
    const OPEN_CARDS_4 = 4;
    const OPEN_CARDS_5 = 5;

    const NAME = 'name';
    const LINK = 'link';
    const START_DATE = 'startdate';
    const CARD1 = 'card1';
    const CARD2 = 'card2';
    const CARD3 = 'card3';
    const CARD4 = 'card4';
    const CARD5 = 'card5';
    const GAME_STATE = 'gamestate';
    const START_MONEY = 'start_money';
    const POD = 'pod';
    const SMALL_BLIND = 'small_blind';
    const PLAYER_LAST_RAISED = 'player_last_raised';
    const OPEN_CARDS = 'open_cards';

    // region Getter und Setter

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
    public function getLink(): string
    {
        return $this->getValue(self::LINK);
    }

    /**
     * @param string $link
     */
    public function setLink($link): void
    {
        $this->setValue(self::LINK, $link);
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->getValue(self::START_DATE);
    }

    /**
     * @param int $start_date
     */
    public function setStartDate($start_date): void
    {
        $this->setValue(self::START_DATE, $start_date);
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
    public function getGameState(): string
    {
        return $this->getValue(self::GAME_STATE);
    }

    /**
     * @param int $game_state
     */
    public function setGameState($game_state): void
    {
        $this->setValue(self::GAME_STATE, $game_state);
    }

    /**
     * @return string
     */
    public function getStartMoney(): string
    {
        return $this->getValue(self::START_MONEY);
    }

    /**
     * @param string $start_money
     */
    public function setStartMoney($start_money): void
    {
        $this->setValue(self::START_MONEY, $start_money);
    }

    /**
     * @return string
     */
    public function getPod(): string
    {
        return $this->getValue(self::POD);
    }

    /**
     * @param int $pod
     */
    public function setPod($pod): void
    {
        $this->setValue(self::POD, $pod);
    }

    /**
     * @return string
     */
    public function getSmallBlind(): string
    {
        return $this->getValue(self::SMALL_BLIND);
    }

    /**
     * @param string $small_blind
     */
    public function setSmallBlind($small_blind): void
    {
        $this->setValue(self::SMALL_BLIND, $small_blind);
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

    public static function getGameByLink($link)
    {
        $game = Game::load(self::LINK, $link);
    }

    public static function init($name, $startMoney, $playerId): Game
    {
        /** @var Game $game */
        $game = new Game();
        $game->setName($name);

        $link = '';
        $linkExists = true;
        while ($linkExists) {
            $link = generateRandomString();
            if (self::getGameByLink($link) == null) {
                $linkExists = false;
            }
        }
        $game->setLink($link);

        $game->setStartDate(time());

        $deck = new CardDeckManager();
        $cards = $deck->getRandomCards(5);

        $game->setCard1($cards[0]->__toString());
        $game->setCard2($cards[1]->__toString());
        $game->setCard3($cards[2]->__toString());
        $game->setCard4($cards[3]->__toString());
        $game->setCard5($cards[4]->__toString());

        $game->setGameState(self::GAME_STATE_0);
        $game->setStartMoney($startMoney);
        $game->setPod(0);
        $game->setSmallBlind($playerId);
        $game->setOpenCards(self::OPEN_CARDS_0);

        return $game;
    }

    protected static function getTable(): string
    {
        return "games";
    }

    protected static function getColumns(): array
    {
        return array();
    }
}