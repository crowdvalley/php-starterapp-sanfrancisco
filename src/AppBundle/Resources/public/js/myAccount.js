$(document).ready(function() {
	// update profile
	$("#btn_update_profile1").click(function(event) {
		event.preventDefault();
		validate = validateProfileAjax();
		if(validate == true){
			updateProfileAjax($(this));
		}		
	});
	/*$("#btn_update_profile2").click(function(event) {
		event.preventDefault();
		validate = validateProfile2Ajax();
		if(validate == true){
			updateProfile2Ajax($(this));
		}
	});*/
	// end update profile
	
	// update password
	$("#btn_update_password").click(function(e){
		e.preventDefault();
		$('#passTab .status').html('');
		validate = validateFormChangePassword();
		if(validate == true){
			updatePassword($(this));
		}
	});
	// end update password
	
	$("#update_profile1").find(".required").keyup( function() {
		validateProfileAjax();
	});
	$("#update_password").find(".required").keyup( function() {
		validateFormChangePassword();
	});
	$("#overview-tab").on('click', function(){
		$(".row ul.nav").find(".active").removeClass("active");
	})
});

function updateProfileAjax(thisObj) {
	var form = $("#update_profile1");
	$('#btn_update_profile1').text('Updating...');
	$("#btn_update_profile1").prop("disabled", "disabled");
	$.ajax({
		url : form.attr("action"),
		type: "POST",
		data : form.serialize(),
		success: function(response, textStatus, jqXHR){//console.log(data.url);
			$('#editTab .status').html('');
			if (response.status == 0) {
				$("#bio_info").text($("#bio").val());
				$("#investment_preferences_info").text($("#investment_preferences").val());
				if ($('input:checkbox[name=HNW_individual]:checked').val() == 1)
					$('#HNW_individual_check').prop('checked', true);
				else
					$('#HNW_individual_check').prop('checked', false);
				if ($('input:checkbox[name=self_certified_investor]:checked').val() == 1)
					$('#self_certified_investor_check').prop('checked', true);
				else
					$('#self_certified_investor_check').prop('checked', false);
				$("#person_name").text($("#fname").val()+' '+$("#lname").val());
				$("#person_city").text($("#city").val());
				$("#person_country").text($("#country").val());
                $("#person_phone").text($("#phone").val());
				$("#overview-tab").click();
			} 
			$("#btn_update_profile1").prop("disabled", false);
			$('#btn_update_profile1').text('Save');
			
		}
	});
}

function validateProfileAjax(){
	var $selector =  $("#update_profile1");
	var $messages = '{"fname":"First Name ",' +
					'"lname":"Last Name "}';
	var $rules = '{"fname":{"text": true},' +
				'"lname":{"text": true}}';

	return validateForm($selector, $rules, $messages);

}

/*function updateProfile2Ajax(thisObj) {
	var form = $("#update_profile2");
	var $this = thisObj;
	var alreadyClicked = $this.data('clicked');
	if (alreadyClicked)
		return false;
	$this.data('clicked', true);
	$('#nameTab .status').html('Updating...').css("margin-left", "20px");
	$.ajax({
		url : form.attr("action"),
		type: "POST",
		data : form.serialize(),
		success: function(response, textStatus, jqXHR){//console.log(data.url);
			$('#nameTab .status').html('');
			if (response.status == 0) {
				$this.data('clicked', false);
				$("#person_name").text($("#fname").val()+' '+$("#lname").val());
				$("#overview-tab").click();
				$("#name-tab").parent().removeClass('active');
			} else {
				$this.data('clicked', false);
			}
		},
		error: function (jqXHR, textStatus, errorThrown){
		}
	});
}*/

function validateFormChangePassword(){
	var $selector =  $("#update_password");
	var $messages = '{"new_password":"Password ",' +
			'"new_password_again":"Password "}';
	var $rules = '{"current_password":{"text": true},' +
			'"new_password":{"minlength":6},' +
			'"new_password_again":{"equalTo":"new_password"}}';

	return validateForm($selector, $rules, $messages);

}

function updatePassword(thisObj) {
	var form = $("#update_password");
	$('#btn_update_password').text('Updating...');
	$("#btn_update_password").prop("disabled", "disabled");
	$.ajax({
		url : form.attr("action"),
		type: "POST",
		data : form.serialize(),
		success: function(response, textStatus, jqXHR){
			if (response.status == 0)
			{
				window.location.href = response.url;
			} else {
				$('#passTab .status').html('Your current password was wrong.');
			}
			$("#btn_update_password").prop("disabled", false);
			$('#btn_update_password').text('Save');
		},
		error: function (jqXHR, textStatus, errorThrown){
		}
	});
}

function updateProfileImage(data, path, callback) {
	$.ajax({
		type: 'POST',
		cache: false,
		dataType: 'html',
		url: path,
		data: data,
		success: function (html, status, xhr) {
			callback(data);
		}
	});
}
		
var saveImage = function () {
	var image = $('#file_profile_image').attr('s3_url');
	var image_save_path = $('#file_profile_image').attr('image_save_path');
	updateProfileImage({'info_profile_image': image}, image_save_path, function (options) {
		location.reload();
	});
}

var saveAccrediationPassport = function () {
	var image_array = [];
	var passport_image = $('#accrediation_passport');
	image_array.push({
		"name": $(passport_image).attr('filename'),
		"s3_url": $(passport_image).attr('s3_url')
	});
	var image_save_path = $('#accrediation_passport').attr('image_save_path');
	updateProfileImage({'proof_of_identity': image_array}, image_save_path, function (options) {
		location.reload();
	});
}

var saveAccrediationBill = function () {
	var image_array = [];
	var bill_image = $('#accrediation_bill');
	image_array.push({
		"name": $(bill_image).attr('filename'),
		"s3_url": $(bill_image).attr('s3_url')
	});
	var image_save_path = $('#accrediation_bill').attr('image_save_path');
	updateProfileImage({'accr_proof': image_array}, image_save_path, function (options) {
		location.reload();
	});
}