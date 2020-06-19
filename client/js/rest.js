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