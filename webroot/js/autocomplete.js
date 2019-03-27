	$(document).ready(function(){	
		
$("#search").keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
    	e.preventDefault();
    	var src = $("#search").val();
    	src = src.trim();
    	if(src.length > 1)
    		window.location.replace("http://localhost/cakelibrary/books/search/"+src);
    }
});
		$("#autocomplete").autocomplete({
			source: function(request, response) {
				$.ajax({ 
					url:'/cakelibrary/authors/autocomplete/'+request.term ,
					method: 'GET',
					dataType:'json',
					success: function(res) {
						response(res);
					}
				});
			}	
		});	
		
		
		
		
		
		
	});