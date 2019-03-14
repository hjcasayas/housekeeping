/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$(document).ready(function() {

	$.post('read.php', {paid: ""}, function(data){
		$('#contributions-table-tbody').html(data);
	});

});