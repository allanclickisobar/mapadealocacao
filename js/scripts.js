$(document).ready(function(){
// jQuery inicio
	$.ajax({
		   type: "GET",
		   dataType: "jsonp",
		   url: "https://agencia.attask-ondemand.com/attask/api/task?ID=5047ef2a0003bcacb6f6d79674fa937a/get",
		   success: function(data){
			   console.log(data);
		     //$('.content').html(data);
		   }
		});
// jQuery final
});