/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$(document).ready(function() {
	$('#defaultPassword').change(function(){
		if (this.checked) {
			$('#password').val("clean@123");
			$('#confirm_password').val("clean@123");
			$('#password').attr("readonly", true);
			$('#confirm_password').attr("readonly", true);
		} else {
			$('#password').val("");
			$('#confirm_password').val("");
			$('#password').removeAttr('readonly');
			$('#confirm_password').removeAttr('readonly');
		};
	});
});
