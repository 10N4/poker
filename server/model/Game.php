<?php


namespace poker_model;


class Game extends DBO
{
    private const NAME = 'name';
    private const LINK = 'link';
    private const START_DATE = 'startdate';
    private const CARD1 = 'card1';
    private const CARD2 = 'card2';
    private const CARD3 = 'card3';
    private const CARD4 = 'card4';
    private const CARD5 = 'card5';
    private const GAME_STATE = 'gamestate';
    private const START_MONEY = 'start_money';
    private const POT = 'pot';
    private const SMALL_BLIND = 'small_blind';
    private const PLAYER_LAST_RAISED = 'player_last_raised';

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
    public function setName(string $name): void
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
    public function setLink(string $link): void
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
     * @param string $start_date
     */
    public function setStartDate(string $start_date): void
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
    public function setCard1(string $card1): void
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
    public function setCard2(string $card2): void
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
    public function setCard3(string $card3): void
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
    public function setCard4(string $card4): void
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
    public function setCard5(string $card5): void
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
     * @param string $game_state
     */
    public function setGameState(string $game_state): void
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
    public function setStartMoney(string $start_money): void
    {
        $this->setValue(self::START_MONEY, $start_money);
    }

    /**
     * @return string
     */
    public function getPot(): string
    {
        return $this->getValue(self::POT);
    }

    /**
     * @param string $pot
     */
    public function setPot(string $pot): void
    {
        $this->setValue(self::POT, $pot);
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
    public function setSmallBlind(string $small_blind): void
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
    public function setPlayerLastRaised(string $player_last_raised): void
    {
        $this->setValue(self::PLAYER_LAST_RAISED, $player_last_raised);
    }

    // endregion

    protected static function getTable(): string
    {
        return "games";
    }

    protected static function getColumns(): array
    {
        // TODO: Implement getColumns() method.
    }
}