/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$(document).ready(function(){
	$(document).keypress(function(event){
		if(event.which == 13){
			$('#login-submit').click();
		}
	});
});
