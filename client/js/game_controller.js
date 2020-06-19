$.getScript("client/js/rest_consts.js");
console.log("TEST");

function setCookie(cname, cvalue, exdays = 36500) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getPlayerID(){
	return getCookie(COOKIE_PLAYER_ID);
}

function setPlayerID(id){
	return setCookie(COOKIE_PLAYER_ID, id);
}

if(getPlayerID() == ""){
  console.log("No cookie ID");
}



function joinGame(){
	$.ajax({
		type: "POST",
		url: REST_API_URI,
		data: JSON.stringify({P_ACTION: A_ENTER_GAME}),
		contentType: "application/json; charset=utf-8",
		dataType: "json",
		success: function(data){
			return(data);
		},
		failure: function(errMsg) {
		    alert(errMsg);
		}
	});
}

$("#player_action_call").click(function() {
	$.ajax({
		type: "POST",
		url: REST_API_URI,
		data: JSON.stringify({P_ACTION: A_CALL}),
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
});

$('.overlay_action_raise').on('click', function () {
    $('#action_raise_content_box').removeClass('active');
    $('.overlay_action_raise').removeClass('active');
    $('#action_raise_content_box_outer').css("z-index", "-1");
});


function updateRaiseValue() {
	$("#raiseValueSpan").html($("#raiseValue").val() + "€");
};

$("#raise_button").click(function() {
	$.ajax({
		type: "POST",
		url: REST_API_URI,
		data: JSON.stringify({P_ACTION: A_RAISE, RAISE_VALUE: $("#raiseValue").val()}),
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

	// Hide all the divs for raising:
    $('#action_raise_content_box').removeClass('active');
    $('.overlay_action_raise').removeClass('active');
	$('#action_raise_content_box_outer').css("z-index", "-1");
});


$("#player_action_raise").click(function() {

	updateRaiseValue();

    $('#action_raise_content_box').addClass('active');
    $('.overlay_action_raise').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    $('#action_raise_content_box_outer').css("z-index", "1");


});
$("#player_action_fold").click(function() {
	$.ajax({
		type: "POST",
		url: REST_API_URI,
		data: JSON.stringify({P_ACTION: A_FOLD}),
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
});







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