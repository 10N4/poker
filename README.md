# poker

## First Meeting
* We make 8 constant slots for the players. If there are less than 8 players, the slots will be empty.
* Tasks: Leon: databases and backend, Niklas: backend, Jona: frontend

## REST API
JSON code:
```
{
  roles: {
    bigBlind: "idxx",
    smallBlind: "idyy",
    activePlayer: "idzz",
  },
  players: [
    {
      id: "idxx",
      name: "Leon", 
      money: -42,
      setThisRound: 250
    },
    {
      id: "idyy",
      name: "Niklas", 
      money: -42,
      setThisRound: 250
    },
    {
      id: "idzz",
      name: "Leon", 
      money: -42,
      setThisRound: 250
    },
    {
      id: "4",
      name: "Leon", 
      money: -42,
      setThisRound: 250
    },
    {
      id: "5",
      name: "Leon", 
      money: -42,
      setThisRound: 250
    },
    {
      id: "6",
      name: "Leon", 
      money: -42,
      setThisRound: 250
    }
  ],
  card1: {
    color: "P",
    card: 7
  },
  card2: {
    color: "H",
    card: 36
  },
  card3: {
    color: "C",
    card: 25
  },
  card4: {
    color: "null",
    card: 0
  },
  card5: {
    color: "null",
    card: 0
  }
}

```