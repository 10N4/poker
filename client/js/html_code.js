var html_code_session_poker_table = `

    <div id="action_raise_content_box">
        Selected value: <span id="raiseValueSpan"></span><br><br>
        <input type="range" min="1" max="200" value="50" class="raiseValueSlider" id="raiseValue" oninput="updateRaiseValue()">
        <button id="raise_button">Raise!</button>
    </div>
    <div class="first_row">
        <div class="player_3_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
        <div class="player_4_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
        <div class="player_5_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
    </div>


    <div class="second_row">
        <div class="player_2_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
        <div class="block_middle">
            <div class="block_middle_pod">
                POD: <span id="pod_money"></span>
            </div>
            <div class="cards_outer_box">
                <div class="card_box">
                    <img src="client/cards/.svg" class="img_card">
                </div>
                <div class="card_box">
                    <img src="client/cards/.svg" class="img_card">
                </div>
                <div class="card_box">
                    <img src="client/cards/.svg" class="img_card">
                </div>
                <div class="card_box">
                    <img src="client/cards/.svg" class="img_card">
                </div>
                <div class="card_box">
                    <img src="client/cards/.svg" class="img_card">
                </div>
            </div>
        </div>
        <div class="player_6_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
    </div>


    <div class="third_row">
        <div class="player_1_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
        <div class="player_me_box">
            <div class="player_inner">
                <div class="player_img_own_cards_box">
                    <img src="client/cards/AS.svg" class="player_img_own_cards player_img_own_cards1">
                    <img src="client/cards/AC.svg" class="player_img_own_cards player_img_own_cards2">
                </div>
                <!--<img src="client/img/user.png" class="player_img">-->
                <div class="player_name_box">
                    <span class="player_name">DU</span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
                <div class="player_space"></div>
                <button class="player_action" id="player_action_call">Call<span id="call_value"></span></button>
                <button class="player_action" id="player_action_raise">Raise</button>
                <button class="player_action" id="player_action_fold">Fold</button>
            </div>
        </div>
        <div class="player_7_box">
            <div class="player_inner">
                <img src="client/img/user.png" class="player_img">
                <div class="player_name_box">
                    <span class="player_name"></span>
                </div>
                <div class="player_money_box">
                    <span class="player_money"></span>
                </div>
                <p class="speech"><span class="player_current_bet"></span></p>
            </div>
        </div>
    </div>


`;




var html_code_start_menu = `
	
	<div id="start_menu_outer_box">
		<h1>Willkommen beim Onlinepoker</h1>
		<button id="open_window_for_creating_new_session" class="create_new_session_button">Neues Spiel erstellen</button>
	</div>

`;


var html_code_create_new_session = `
	
	<div id="start_menu_outer_box">
		<h1>Neues Spiel erstellen</h1>
		<div id="form_error_messages"></div>
		<div id="create_new_session_table_outer">
			<div id="create_new_session_table">
				<div class="table_row">
					<div class="table_cell">Name</div>
					<div class="table_cell"><input type="text" id="create_new_session_name"></div>
				</div>
				<div class="table_row">
					<div class="table_cell">Startgeld</div>
					<div class="table_cell"><input type="number" id="create_new_session_start_money"></div>
				</div>
				<div class="table_row">
					<div class="table_cell">Einsatz Small Blind</div>
					<div class="table_cell"><input type="number" id="create_new_session_small_blind"></div>
				</div>
			</div>
			<input type="submit" id="create_new_session" value="Spiel erstellen" class="create_new_session_button">
		</div>
	</div>

`;