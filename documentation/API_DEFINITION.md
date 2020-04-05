# Definition of REST API


## Update
Client request:
```
{
  P_ACTION: A_UPDATE
}
```


Server answer:
```
{
  "roles": {
    "bigBlind": "idxx",
    "smallBlind": "idyy",
    "activePlayer": "42"
  },
  "players": [
    {
      "id": "33",
      "name": "Albert", 
      "money": 5050,
      "setThisRound": 250
    },
    {
      "id": "35",
      "name": "Berta", 
      "money": 3160,
      "setThisRound": 250
    },
    {
      "id": "36",
      "name": "Caesar", 
      "money": 1590,
      "setThisRound": 250
    },
    {
      "id": "42",
      "name": "David", 
      "money": 2450,
      "setThisRound": 250
    },
    {
      "id": "51",
      "name": "Eberhart", 
      "money": 3240,
      "setThisRound": 150
    },
    {
      "id": "53",
      "name": "Francois", 
      "money": 6110,
      "setThisRound": 150
    },
    {
      "id": "55",
      "name": "Günter", 
      "money": 4930,
      "setThisRound": 150
    },
    {
      "id": "59",
      "name": "Heribert", 
      "money": 2770,
      "setThisRound": 150
    }
  ],
  "card1": {
    "color": "P",
    "card": "QH"
  },
  "card2": {
    "color": "H",
    "card": "2C"
  },
  "card3": {
    "color": "C",
    "card": "5D"
  },
  "card4": {
    "color": "null",
    "card": 0
  },
  "card5": {
    "color": "null",
    "card": 0
  }
}
```


## Join game