# Definition of REST API
All requests are sent to `/server/controller/rest.php`.

With every request, also the `authentication_id` is transmitted as a cookie.

## GET
For `GET` requests, the server returns a JSON.


### Cards
Client request:
```
P_ACTION=A_CARDS
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
P_ACTION=A_UPDATE
```


Server answer:
```
{
  "pod": 5000,
  "current_bet": 250,
  "roles": {
    "dealer": "35",
    "small_blind": "36",
    "big_blind": "42",
    "active_player": "53"
  },
  "players": [
    {
      "id": "33",
      "name": "Albert", 
      "money": 5050,
      "last_action": "Fold",
      "bet_raise_value": 0
    },
    {
      "id": "35",
      "name": "Berta", 
      "money": 3160,
      "last_action": "Check",
      "bet_raise_value": 0
    },
    {
      "id": "36",
      "name": "Caesar", 
      "money": 1590,
      "last_action": "Bet",
      "bet_raise_value": 150
    },
    {
      "id": "42",
      "name": "David", 
      "money": 2450,
      "last_action": "Call",
      "bet_raise_value": 150
    },
    {
      "id": "51",
      "name": "Eberhart", 
      "money": 3240,
      "last_action": "Raise",
      "bet_raise_value": 250
    },
    {
      "id": "53",
      "name": "Francois", 
      "money": 6110,
      "last_action": "Fold",
      "bet_raise_value": 0
    },
    {
      "id": "55",
      "name": "Günter", 
      "money": 4930,
      "last_action": "",
      "bet_raise_value": 0
    },
    {
      "id": "59",
      "name": "Heribert", 
      "money": 2770,
      "last_action": "",
      "bet_raise_value": 0
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
P_ACTION=A_ENTER_SESSION&P_SESSION_NAME=session_name&P_START_MONEY=start_money&P_MONEY_SMALL_BLIND=money_small_blind&P_PLAYER_NAME=player_name
```


Server answer:
```
{
  valid: R_OK, R_ERROR,
  session_id: session_id,
  session_name: session_name
}
```


### Check if sessions exists
Client request:
```
P_ACTION=A_SESSION_EXISTS
```


Server answer:
```
{
  "A_SESSION_EXISTS": true/false
}
```




## POST
For `POST` requests, the server returns plain text.



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


### Checken/Call
Client request:
```
P_ACTION=A_CHECK_CALL
```


Server answer:
```
R_OK, R_ERROR
```


### Bet/Raise
Client request:
```
P_ACTION=A_BET_RAISE&P_BET_RAISE_VALUE=bet_value
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