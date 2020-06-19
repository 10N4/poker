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




    	$("#pod_money").html((ajaxData["pod"]).toLocaleString("de")+"€");
    	$("#call_value").html(" (" + (ajaxData["currentBet"]).toLocaleString("de")+"€)");

		if(ajaxData["roles"]["activePlayer"] == ajaxData["players"][i-1]["id"]){
			activePlayerId = i;
			//$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(126,191,113,0.7)");
			//$(".player_"+player_id_current+"_box .player_inner").css("border","2px solid #fff");
			$(".player_"+player_id_current+"_box .player_img").addClass("player_active");
			$(".player_"+player_id_current+"_box .player_name_box").addClass("player_active");
			$(".player_"+player_id_current+"_box .player_money_box").addClass("player_active");
			
		}
		else {
			//$(".player_"+player_id_current+"_box .player_inner").css("background-color","rgba(150,150,150,0.7)");
			//$(".player_"+player_id_current+"_box .player_inner").css("border","0");
			$(".player_"+player_id_current+"_box .player_img").removeClass("player_active");
			$(".player_"+player_id_current+"_box .player_name_box").removeClass("player_active");
			$(".player_"+player_id_current+"_box .player_money_box").removeClass("player_active");
		}





    	$(".player_"+player_id_current+"_box .player_money").html((ajaxData["players"][i-1]["money"]).toLocaleString("de")+"€");
    	if(player_id_current != "me"){
    		$(".player_"+player_id_current+"_box .player_name").html((ajaxData["players"][i-1]["name"]).toUpperCase());
    	}
    	if(ajaxData["players"][i-1]["lastAction"] != ""){
    		$(".player_"+player_id_current+"_box .player_current_bet").html(ajaxData["players"][i-1]["lastAction"]);
    		$(".player_"+player_id_current+"_box .speech").css("display", "block");
    	}
    	else {
    		$(".player_"+player_id_current+"_box .player_current_bet").html();
    		$(".player_"+player_id_current+"_box .speech").css("display", "none");
    	}
		if(ajaxData["players"][i-1]["lastAction"] == "Fold"){
			$(".player_"+player_id_current+"_box").css("opacity", "0.5");
		}
		else {
			$(".player_"+player_id_current+"_box").css("opacity", "1");
		}

    	++player_id;
	}
	for(index_cards = 1; index_cards <= 5; ++index_cards){
		//console.log(ajaxData["card"+index_cards]);
		if(ajaxData["card"+index_cards]["card"] != "0"){
			$("img.img_card:eq("+(index_cards-1)+")").attr("src", "client/cards/" + ajaxData["card"+index_cards]["card"] + ".svg");
		}
		else {
			$("img.img_card:eq("+(index_cards-1)+")").attr("src", "client/cards/empty.svg");
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
}
$(document).ready(function () {
	updateDataAjax();
	var updateFuncInterval = setInterval(updateDataAjax, 1000);
});