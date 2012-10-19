$(document).ready(function(){
// jQuery inicio
	$.ajax({
		   type: "GET",
		   dataType: "json",
//		   url: "https://agencia.attask-ondemand.com/attask/api/project/4f0316d600144b5c5d6e9af10d3f8859?method=get",
		   url: "http://localhost/_Labs/web/mapadealocacao/src/json.php",
		   success: function(data){
			   console.log(data);
//			   $('.content').html(data);
		   }
		});
// jQuery final
});