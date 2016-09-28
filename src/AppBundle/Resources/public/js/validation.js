//function validate form
function validateForm($selector, $rules, $message){
	var id = '';
	var $message = $.parseJSON($message);
	var $rules = $.parseJSON($rules);
	var $val = '';
	var regexNumber=/^[0-9]+$/;
	var regexEmail=/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var errorStr = '';
	var msgStr = '';
	var error = 0;
	var submit = 1;
	$selector.find(".required").each(function( index ) {
		errorStr = '';
		id = $(this).attr( "id" );
		$val = $("#"+id).val();
		if($val.length > 0){
			error = 0;
		}
		else{
			error = 1;
		}
		if(typeof $message[id]  !== "undefined" ){
			msgStr = $message[id];
		}
		else{
			msgStr = 'This field';
		}
		if(typeof $rules[id]  !== "undefined"){
			if(typeof $rules[id].text !== "undefined" && $rules[id].text == true ){
				if ($val == '' )
				{
					errorStr = errorStr + '<p id="txt-'+id+'">'+ msgStr +' is required.</p>';
					error = 1;
				}
				else{
					$("#txt-"+id).remove();
				}
			}
			if(typeof $rules[id].email !== "undefined" && $rules[id].email == true ){
				if ((!regexEmail.test($val) && $val.length > 0) || ($val.length == 0))
				{
					errorStr = errorStr + '<p id="em-'+id+'">Email is incorrect.</p>';
					error = 1;
				}
				else{
					$("#em-"+id).remove();
				}
			}
			if(typeof $rules[id].number !== "undefined" && $rules[id].number == true ){
				if ((!$val.match(regexNumber) && $val.length > 0) || ($val.length == 0))
				{
					errorStr = errorStr + '<p id="nb-'+id+'">'+ msgStr +' should be number.</p>';
					error = 1;
				}
				else{
					$("#nb-"+id).remove();
				}
			}
			if(typeof $rules[id].length !== "undefined" && $val.length > 0){
				if ($val.length != $rules[id].length)
				{
					errorStr = errorStr +  '<p id="lgt-'+id+'">'+ msgStr +' should be ' + $rules[id].length + ' characters.</p>';
					error = 1;
				}
				else{
					$("#lgt-"+id).remove();
				}
			}
			if(typeof $rules[id].minlength !== "undefined"){

				if ($val.length < $rules[id].minlength)
				{
					errorStr = errorStr +  '<p id="minlgt-'+id+'">'+ msgStr +' at least ' + $rules[id].minlength + ' characters.</p>';
					error = 1;
				}
				else{
					$("#minlgt-"+id).remove();
				}
			}
			if(typeof $rules[id].maxlength !== "undefined" && $val.length > 0){
				if ($val.length > $rules[id].maxlength)
				{
					errorStr = errorStr +  '<p id="maxlgt-'+id+'">'+ msgStr +' should be limited to no more than ' + $rules[id].maxlength + ' characters.</p>';
					error = 1;
				}
				else{
					$("#maxlgt-"+id).remove();
				}
			}
			if(typeof $rules[id].equalTo !== "undefined" ){
				var equalTo = $('#'+$rules[id].equalTo).val();
				if ($val != equalTo)
				{
					errorStr = errorStr +  '<p id="eq-'+id+'"> Password is incorrect</p>';
					error = 1;
				}
				else{
					$("#eq-"+id).remove();
				}
			}
		}
		if(error == 1){
			$(this).parents(".input-group").find('.error-list').remove();
			errorStr = '<div class="error-list">'+ errorStr + '</div>';
			$(this).parents(".input-group").append(errorStr);
			$(this).parents(".input-group").addClass('error');
			submit = 0;
		}
		else{
			$(this).parents(".input-group").removeClass('error');
		}
	});

	if(submit == 1){
		return true;
	}
	else{
		return false;
	}
}