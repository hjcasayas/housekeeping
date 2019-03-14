$(document).ready(function(){

//AUTOLOADS

	// get users' information
	$.post("read.php", {users: ""}, function(data){
		$('#users-table-tbody').html(data);
	});


	// get years
	$.post('read.php', {years: ""}, function(data){
		$('#contributions-years').html(data);
	});

	// get months
	$.post('read.php', {months: ""}, function(data){
		$('#contributions-months').html(data);
	});	
	// payment.php
	$.post('read.php', {payday: ""}, function(data){
		$('#contributions-payday').html(data);
	});	

	// contributions.php
	$.post('read.php', {paid: ''}, function(data){
		$('#contributions-table-tbody').html(data);
	});

//ACTIONS
	
	// generate members that is not yet able to pay during selected payday
	$('#generate-contributors').on('click', function(){
		var year = $('#contributions-years').val();
		var month = $('#contributions-months').val();
		var payday = $('#contributions-payday').val();
		$.post('read.php', {generate: "", theYear: year, theMonth: month, thePayday: payday}, function(data){
			$('.contributors-container').html(data);
		});
	});

	// now checkbox is checked
	$(document).on('change', '.now-paid',function(){
		var timeInput =	$(this).parent().prev();
		
		if (this.checked) {
			$.post('read.php', {today: ""}, function(data){
				timeInput.val(data);
			});
			timeInput.attr("readonly", true);
		} else {
			timeInput.val("");
			timeInput.removeAttr('readonly');
		}
	});	

	// updating the payment - update is clicked
	$(document).on('click', '#update-payment', function(){
		var member = $(this).parent().prev().prev().prev()[0]['outerText'];
		var payment = $(this).parent().prev().prev()[0]['childNodes'][0]['value'];
		var datePaid = $(this).parent().prev()[0]['firstChild']['value'];

		var theMonth = $('#theMonth').text();
		var theYear = $('#theYear').text();
		var thePayday = $('#thePayday').text();

		if ( ($.trim(payment) == '') || ($.trim(datePaid) == '') ) {
			alert('Either the Payment or Date Paid is empty');
		} else {
			$.post('add.php', {updatePayment:"", member: member, payment: payment, datePaid: datePaid, theMonth: theMonth, theYear: theYear, thePayday: thePayday}, function(data){
				if (data=='success') {
					$('.contributors-container').empty();
					$.post('read.php', {generate: "", theYear: theYear, theMonth: theMonth, thePayday: thePayday}, function(data){
						$('.contributors-container').html(data);
					});
				} else {
					$('.error').html(data);
				}
			});
		}
		$.post('contributionshandler.php');
	});

//FUNCTIONS

});