/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/

$(document).ready(function(){
	
	//Yes checkbox if checked the member's list will be shown if not, the list will be hidden and all checked input will be unchecked
	$('.checkbox-sublist').change(function(){
		var checkboxYesID = $(this).attr('id');
		var tdcomments = $(this).parent().next().next().attr("id");

		if((this).checked) {
			$('#members-' + checkboxYesID).show();
		} else {
			$('#members-' + checkboxYesID).hide();
			$('#members-' + checkboxYesID + ' input[type=checkbox]').prop('checked', false);
			$('#' + tdcomments + '> div').remove();
		}
	});

	$('.checkbox-member').change(function(){
		var checkboxMemberID = $(this).attr('id');
		var user = $("#" + checkboxMemberID + " + label").text();
		var tcomment = $(this).parent().parent().next().attr('id');

		if((this.checked)) {
			$('#'+tcomment).append("<div " +  "class=comments-for-user id=comment-" + checkboxMemberID + "> " + 
								   "<span " + "id='span-" + tcomment + "-" + "user" + "'>" + user + ":</span>" + 
								   "<input" + " name='" + tcomment + "-" + user.toLowerCase() + "' " + 
								   "id='" + tcomment + "-" + user.toLowerCase() + "' type=text>" + " </div>");
		} else {
			$("#comment-" + checkboxMemberID).remove();
		}
	});

	$('#submit-checklist').click(function(){
	    
		hourSubmit = 16;
		hourLastSubmit = 21;

		$.post("hourToSubmit.php", {hour: hourSubmit},function(data){
			nowHour = parseInt(data);
		
			if (hourSubmit > nowHour || hourLastSubmit < nowHour) {
				alert(	"It is not yet time to submit the housekeeping form. Please submit the form from 4:00pm to 9:00pm only.");
			} else {

				if (confirm("Are you sure you want to submit the houskeeping form?") == true) {
			 
					var checkBoxes = $('.checkbox-sublist');
					var checkedBoxIDList = []
					var dataList = [];

					for (var i = 0; i < checkBoxes.length; i++) {
						if (checkBoxes[i]['checked'] == true) {
							var checkedBoxID = checkBoxes[i]['id'];
							checkedBoxIDList.push(checkedBoxID);
						}		
					}

					if (!(checkedBoxIDList.length == 0)) {
						for (var j = 0; j < checkedBoxIDList.length; j++) {
							var checkList = $('#' + checkedBoxIDList[j]).parent().prev().text();
							var commentsColumn = $('#' + checkedBoxIDList[j]).parent().next().next();
							var commentsChildrenCount = commentsColumn[0]['childElementCount'];

							if ( commentsChildrenCount == 0) {
								alert("You have not checked any member for " + checkList);
								break;
							} else {

								for (var k = 0; k < commentsChildrenCount; k++) {
									var user = commentsColumn[0]['children'][k]['children'][0]['innerText'].replace(':','');
									var userComment = commentsColumn[0]['children'][k]['children'][1]['value'];
									var shredderData = {shredder: user, checklist: checkList, comment: userComment};
									dataList.push(shredderData);
								}

							}

						}
					}

					if (checkedBoxIDList.length <= dataList.length) {
						var housekeepingData = JSON.stringify({housekeeping: dataList});

						$.post("checklistHandler.php", {cleanData: housekeepingData}, function(data){
							alert(data);
						});
					}
			    }
			}   
		});

	});

});