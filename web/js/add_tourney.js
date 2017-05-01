$("#matches-id_tourney").bind("load change",function(){
	var id_tourney = $("#matches-id_tourney").val();
	
	$.ajax({
		url: "add-match",
		type: "GET",
		data: "id_tourney="+id_tourney,
		success: function(data){
			
			$("#matches-team1").html("");
			$("#matches-team2").html("");
			
			if(data.list.length>0){
				for(var i=0;i<=data.list.length;i++){
					
					if(data.list[i]){
						
						$("#matches-team1").append( $('<option value="'+data.list[i].name+'">'+data.list[i].name+'</option>'));
						$("#matches-team2").append( $('<option value="'+data.list[i].name+'">'+data.list[i].name+'</option>'));
					}
				}
			}
		}
	});
});

