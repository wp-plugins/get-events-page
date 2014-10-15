//
// GetEvents Helper functions to Signin, check if connected and validate the form
//

var geteventsServer = 'https://getevents.co';
var geteventsPluginPath = window.location;

function signInWithEmail(email, password) {

	var dataCredentials = {
		email: email,
		password: password
	};

	signIn(dataCredentials);
}

function signInWithKey(accountId, api_key) {

	var dataCredentials = {
		account_id: accountId,
		api_key: api_key
	};

	signIn(dataCredentials);
}

function signIn(dataCredentials) {
	jQuery('#getevents-signin').hide();

	jQuery.ajax({
		type: 'POST',
		url: geteventsServer + '/platforms/sign-in',
		crossDomain: true,
		data: dataCredentials,
		success: function (json) {
			var status = json.status;

			if (status == 'ok') {
				var email = json.account.email;
				var api_token = json.account.api_token;
				var account = json.account;
				var eventlisting = json.eventlisting;
				var script = json.script;

				var requestData = {
					action: 'connect_account',
					api_token: api_token,
					account: account,
					email: email,
					eventlisting: eventlisting,
					script: script
				};

				jQuery.ajax({
					type: "GET",
					url: geteventsPluginPath + 'getevents_admin.php',
					data: requestData,
					success: function (response) {
						var windowLocation = geteventsPluginPath.origin + geteventsPluginPath.pathname + geteventsPluginPath.search.replace('&action=disconnect', '');
						window.location.href = windowLocation;
					},
					error: function (res) {
						jQuery("#error-signin").text("Email or Password not recognised").show().fadeOut(5000);
						jQuery('#getevents-signin').fadeIn(2000);
					}
				});
			} else {
				jQuery("#error-signin").text("Email or Password not recognised").show().fadeOut(5000);
				jQuery('#getevents-signin').fadeIn(2000);
			}

		},
		error: function (jq, st, error) {
			console.log(error);
		}
	});


}

function geteventsCreateUser() {
	console.log('geteventsCreateUser');
	var myWindow = window.open(geteventsCreateUserURL, '_self');
}


function checkEmailAddress() {
	var email = jQuery("#user_email").val();
	var atpos = email.indexOf("@");
	var dotpos = email.lastIndexOf(".");

	if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
		document.getElementById('error-email').innerHTML = "Please Enter a Valid Email Address";
		jQuery("#user_email").focus();
		return false;
	} else {
		document.getElementById('error-email').innerHTML = "";
	}
}

function checkPassword() {
	var pass = jQuery("#user_password").val();
	if (pass == '') {
		document.getElementById('error-password').innerHTML = "Please Enter a Password";
		jQuery("#user_password").focus();
		return false;
	} else {
		document.getElementById('error-password').innerHTML = "";
	}
}

jQuery(document).ready(function () {

	jQuery("#getevents-connect-button").click(function () {

		jQuery("#getevents-connect").fadeOut(function () {
			jQuery("#user_login").fadeIn();
			jQuery('#user_email').focus();
		});

	});

	jQuery("#getevents-signin-button").click(function () {
		var email = jQuery("#user_email").val();
		var password = jQuery("#user_password").val();

		if (checkEmailAddress() == false) {
			return false;
		}

		if (checkPassword() == false) {
			return false;
		}

		signInWithEmail(email, password);
	});

});