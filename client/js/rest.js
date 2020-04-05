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