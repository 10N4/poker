var pathname = window.location.pathname;
var sessionID = pathname.replace("/poker/", "");

console.log(sessionID);

if(sessionID != ""){ // Session ID is passed in URI. First we validate session ID. Then, we try to join the game

	$("#main").html(html_code_session_poker_table);
	if(getPlayerID() == ""){
	  console.log("No cookie ID");
	}

}
else { // Session ID is not passed in URI. Therefore, we show the player a menu to create a new game

	$("#main").html(html_code_start_menu);


	$("#open_window_for_creating_new_session").click(function() {
		$("#main").html(html_code_create_new_session);

		$("#create_new_session").click(function() {
			var error_messages = "";
			var new_session_name = $("#create_new_session_name").val();
			var new_session_start_money = $("#create_new_session_start_money").val();
			var new_session_small_blind = $("#create_new_session_small_blind").val();


			// Check for errors
			if(new_session_name.length < 3){
				error_messages += "Bitte geben Sie einen Namen für das Spiel mit mindestens 3 Buchstaben ein.<br>";
				$("#create_new_session_name").css("border", "2px solid red");
			}
			else {
				$("#create_new_session_name").css("border", "1px solid black");
			}
			if(isNaN(new_session_start_money) || new_session_start_money < 50){
				error_messages += "Bitte geben Sie eine gültige Zahl (und mindestens 50&euro;) für das Startgeld ein.<br>";
				$("#create_new_session_start_money").css("border", "2px solid red");
			}
			else {
				$("#create_new_session_start_money").css("border", "1px solid black");
			}
			if(isNaN(new_session_small_blind) || new_session_small_blind < 5){
				error_messages += "Bitte geben Sie eine gültige Zahl (und mindestens 5&euro;) für den Small Blind-Betrag ein.<br>";
				$("#create_new_session_small_blind").css("border", "2px solid red");
			}
			else {
				$("#create_new_session_small_blind").css("border", "1px solid black");
			}


			// If there were errors
			if(error_messages != ""){
				$("#form_error_messages").html(error_messages);
			}
			// If there were no errors --> Try to create the game (via ajax request)
			else {
				$.ajax({
					type: "POST",
					url: REST_API_URI,
					data: JSON.stringify({P_ACTION: A_CREATE_SESSION, P_SESSION_NAME: new_session_name, P_START_MONEY: new_session_start_money, P_MONEY_SMALL_BLIND: new_session_small_blind, P_PLAYER_NAME: new_session_name}),
					contentType: "application/json; charset=utf-8",
					dataType: "text", // data type of server response
					success: function(data){
						if(data == R_OK){
							alert("Server answer is OK.");
						}
						else if(data == R_ERROR){
							alert("Server answer is error :(");
						}
						else {
							alert("This is not supposed to happen. Return data = " + data);
						}
					},
					failure: function(errMsg) {
					    alert(errMsg);
					}
				});
			} // End: Else of error_messages != ""
		});
	});

}