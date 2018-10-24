<?php
	print 111111111111;
?>


<html>

	<head>
	</head>


	<body>

		<script>
document.getElementById("demo").innerHTML = 5 + 6;
</script>

		<script src="https://apis.google.com/js/platform.js" async defer></script>

		lllllll

		<meta name="google-signin-client_id" content="523553006265-bkdhtk2f17kcuf2li521st0rtfu4pqe7.apps.googleusercontent.com">
		
		ppppppp

		<div class="g-signin2" data-onsuccess="onSignIn"></div>

		hhhhhhhhhhhh

<script type="text/javascript">
		/*The Sign-In client object.*/
		var auth2;
		/* Initializes the Sign-In client. */
		var initClient = function() {
		    gapi.load('auth2', function(){
		        /*Retrieve the singleton for the GoogleAuth library and set up the client.*/
		        auth2 = gapi.auth2.init({
		            client_id: 'CLIENT_ID.apps.googleusercontent.com'
		        });

		        // Attach the click handler to the sign-in button
		        auth2.attachClickHandler('signin-button', {}, onSuccess, onFailure);
		    });
		};

		/**
		 * Handle successful sign-ins.
		 */
		var onSuccess = function(user) {
		    console.log('Signed in as ' + user.getBasicProfile().getName());
		 };

		/**
		 * Handle sign-in failures.
		 */
		var onFailure = function(error) {
		    console.log(error);
		};
</script>

<!-- 		<script type="text/javascript">
			function onSignIn(googleUser) {
				print(44444)
				var profile = googleUser.getBasicProfile();
				console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
				console.log('Name: ' + profile.getName());
				console.log('Image URL: ' + profile.getImageUrl());
				console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
			}
		</script> -->

		<?php print 3333333333333333; ?>





	</body>
</html>