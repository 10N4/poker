function updateData(ajaxData) {
	player_id = 1;
	var activePlayerId = "0";
	for(i = 1; i <= 8; ++i){
		if(ajaxData["players"][i-1]["id"] == ownPlayerID){
			player_id_current = "me";
			--player_id;
		}
		else {
			player_id_current = player_id;
		}





		if(ajaxData["roles"]["activePlayer"] == ajaxData["players"][i-1]["id"]){
			activePlayerId = i;
			$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(126,191,113,0.7)");
			$(".player_"+player_id_current+"_box .player_inner").css("border","2px solid #fff");
		}
		else {
			$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(150,150,150,0.7)");
			$(".player_"+player_id_current+"_box .player_inner").css("border","0");
		}





    	$(".player_"+player_id_current+"_box .player_money").html(ajaxData["players"][i-1]["money"]+"€");
    	$(".player_"+player_id_current+"_box .player_name").html(ajaxData["players"][i-1]["name"]);
    	$(".player_"+player_id_current+"_box .player_current_bet").html(ajaxData["players"][i-1]["setThisRound"]);

    	++player_id;
	}
	for(index_cards = 1; index_cards <= 5; ++index_cards){
		//console.log(ajaxData["card"+index_cards]);
		if(ajaxData["card"+index_cards] != 0){
			//$("img.card").attr("src", ajaxData["card"+index_cards]);//[index_cards-1]
		}
	}
}

function updateDataAjax() {
	$.ajax({
		type: "POST",
		url: REST_API_URI,
		// The key needs to match your method's input parameter (case-sensitive).
		data: JSON.stringify({P_ACTION: A_UPDATE}),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			updateData(data);
		},
		failure: function(errMsg) {
		    alert(errMsg);
		}
	});
	/*
    $.ajax({
		type: "POST",
		url: "json_test.txt",
		data: {P_ACTION: A_UPDATE},
		complete: function(e, xhr, settings){
			switch(e.status){
			case 500:
				alert('500 internal server error!');
				break;
			case 404:
				alert('404 Page not found!');
				break;
			case 401:
		 		alert('401 unauthorized access');     
				break;       
			}
		}           
		}).done(function( data ) {
		var obj = jQuery.parseJSON(data);

		//console.log(obj["players"]);
		console.log(obj.success)
		if (obj.success == 1){

			player_id = 1;
			var activePlayerId = "0";
			for(i = 1; i <= 8; ++i){
				if(obj["players"][i-1]["id"] == ownPlayerID){
					player_id_current = "me";
					--player_id;
				}
				else {
					player_id_current = player_id;
				}





				if(obj["roles"]["activePlayer"] == obj["players"][i-1]["id"]){
					activePlayerId = i;
	    			$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(126,191,113,0.7)");
	    			$(".player_"+player_id_current+"_box .player_inner").css("border","2px solid #fff");
				}
				else {
	    			$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(150,150,150,0.7)");
	    			$(".player_"+player_id_current+"_box .player_inner").css("border","0");
				}





	        	$(".player_"+player_id_current+"_box .player_money").html(obj["players"][i-1]["money"]+"€");
	        	$(".player_"+player_id_current+"_box .player_name").html(obj["players"][i-1]["name"]);
	        	$(".player_"+player_id_current+"_box .player_current_bet").html(obj["players"][i-1]["setThisRound"]);

	        	++player_id;
			}
			for(index_cards = 1; index_cards <= 5; ++i){
				console.log(obj["card"+index_cards]);
				if(obj["card"+index_cards] != 0){
					$("img.card")[index_cards-1].src(obj["card"+index_cards]);
				}
			}


		}
		else if (obj.error == 1){


		}
	}); // Ajax*/
}
$(document).ready(function () {
	updateDataAjax();
	var updateFuncInterval = setInterval(updateDataAjax, 1000);
});