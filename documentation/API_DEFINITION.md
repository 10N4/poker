# Definition of REST API
All requests are sent to `/server/controller/rest.php`.

With every request, also the `authenticationID` is transmitted as a cookie.

## GET
For `GET` requests, the server returns a JSON.


### Cards
Client request:
```
P_ACTION: A_UPDATE
```


Server answer:
```
{
  "card1": "h12",
  "card2": "d3"
}
```



### Update
Client request:
```
P_ACTION: A_UPDATE
```


Server answer:
```
{
  "roles": {
    "dealer": "35",
    "smallBlind": "36",
    "bigBlind": "42",
    "activePlayer": "53"
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
  "card1": "QH",
  "card2": "2C",
  "card3": "5D",
  "card4": 0,
  "card5": 0
}
```

### Create Session
Client request:
```
P_ACTION=A_ENTER_SESSION&P_SESSION_NAME=session_name&P_PLAYER_NAME=player_name
```


Server answer:
```
R_OK, R_ERROR
```



## POST


### Join session
Client request:
```
P_ACTION=A_ENTER_SESSION&P_SESSION_NAME=session_name&P_PLAYER_NAME=player_name
```


Server answer:
```
R_GAME_STARTED: boolean
```


### Exit session
Client request:
```
P_ACTION=A_EXIT_SESSION
```


Server answer:
```
R_OK, R_ERROR
```


### Checken
Client request:
```
P_ACTION=A_CHECK
```


Server answer:
```
R_OK, R_ERROR
```


### Bet
Client request:
```
P_ACTION=A_BET&BET_VALUE=bet_value
```


Server answer:
```
R_OK, R_ERROR
```


### Call
Client request:
```
P_ACTION=A_CALL
```


Server answer:
```
R_OK, R_ERROR
```


### Raise
Client request:
```
P_ACTION=A_RAISE&RAISE_VALUE=raise_value
```


Server answer:
```
R_OK, R_ERROR
```


### Fold
Client request:
```
P_ACTION=A_FOLD
```


Server answer:
```
R_OK, R_ERROR
```