<title>KC Converter</title>
<!-- <body style="-webkit-background-size: cover;background-size: cover;" background="./img/faded_blue_wallpaper.png"></body> -->
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="img/logo_kc.png">

<?php
// Values got from Google API
$googleClientID = '523553006265-bkdhtk2f17kcuf2li521st0rtfu4pqe7.apps.googleusercontent.com';
$googleClientSecret = 'epFWS-9FaiBptttMZKPBGAVY';
// URL we'll send the user to first to get their authorization
$authorizeURL = 'https://accounts.google.com/o/oauth2/v2/auth';
// Google's OpenID Connect token endpoint
$tokenURL = 'https://www.googleapis.com/oauth2/v4/token';
// The URL for this script, used as the redirect URL
$baseURL = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];

//echo '<p>base url: '.$baseURL.'</p>';

echo '<div class="center-cropped">
    <img src="./img/logo_kc.png" alt="logo" />
     </div>';

// Start a session so we have a place to store things between redirects
session_start();
// Start the login process by sending the user to Google's authorization page
if(isset($_GET['action']) && $_GET['action'] == 'login') {
	unset($_SESSION['user_id']); // in case of already logged in user
	// Generate a random hash and store in the session
	$_SESSION['state'] = bin2hex(random_bytes(16));
	$params = array(
		'response_type' => 'code',
		'client_id' => $googleClientID,
		'redirect_uri' => $baseURL,
		'scope' => 'openid email',
		'state' => $_SESSION['state']
	);
	// Redirect the user to Google's authorization page
	header('Location: ' . $authorizeURL . '?' . http_build_query($params));
	die();
}

if(isset($_GET['action']) && $_GET['action'] == 'logout') {
	unset($_SESSION['user_id']);
	header('Location: '.$baseURL);
	die();
}

// When Google redirects the user back here, there will be a "code" and "state" parameter in the query string
if(isset($_GET['code'])) {
	// Verify the state matches our stored state
	if(!isset($_GET['state']) || $_SESSION['state'] != $_GET['state']) {
		header('Location: ' . $baseURL . '?error=invalid_state');
		die();
	}
	// Exchange the auth code for a token
	// initialisation de la session
	$ch = curl_init($tokenURL);
	// configuration des options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
	'grant_type' => 'authorization_code',
	'client_id' => $googleClientID,
	'client_secret' => $googleClientSecret,
	'redirect_uri' => $baseURL,
	'code' => $_GET['code']
	]));
	// exécution de la session
	$response = curl_exec($ch);
	$data = json_decode($response, true);

	// Split the JWT string into three parts
	$jwt = explode('.', $data['id_token']);

	// Extract the middle part, base64 decode it, then json_decode it
	$userinfo = json_decode(base64_decode($jwt[1]), true);

	$_SESSION['user_id'] = $userinfo['sub'];
	$_SESSION['email'] = $userinfo['email'];

	// While we're at it, let's store the access token and id token
	// so we can use them later
	$_SESSION['access_token'] = $data['access_token'];
	$_SESSION['id_token'] = $data['id_token'];
	$_SESSION['userinfo'] = $userinfo;

	header('Location: ' . $baseURL);
	die();
}


// If there is a user ID in the session
// the user is already logged in
if(!isset($_GET['action'])) {
//    print('333333333333333');
	if(!empty($_SESSION['user_id'])) {
	//      print(222222222222222);
	//      echo '<h3>Logged In</h3>';
	//      echo '<p>User ID: '.$_SESSION['user_id'].'</p>';
//	echo '<p class="state">Email: '.$_SESSION['email'].'</p>';
	if (empty($_SESSION['userinfo']['hd'])) {
        echo '<h3 align="center">Access denied</h3>';
        //      echo '<h3 align="center">You can\'t acces this site your not from Keep Cool.</h3>';
        //  echo '<h3 align="center">Please connect with your Keep Cool e-mail address.</h3>';
			// echo '<p><a href="?action=logout">Log Out</a></p>';
			unset($_SESSION['user_id']);
			echo '<p class="state"><a href="?action=login"> ---> Try log In again <--- </a></p>';
			// header('Location: '.$baseURL);
			die();
		} else if (!empty($_SESSION['userinfo']['hd']) and
			((($_SESSION['userinfo']['hd'] == "keepcool.fr") == true)) or
			(($_SESSION['userinfo']['hd'] == "keepcool.com") == true) or
			(($_SESSION['userinfo']['hd'] == "keepcool.me") == true)) {
			/* echo '<h3 class="state">++++++++++++++++++++++++++++++++++++++++++++++++</h3>'; */
			/* echo '<h3 class="state">Your are from Keep Cool you can access this site</h3>'; */
			/* echo '<h3 class="state">++++++++++++++++++++++++++++++++++++++++++++++++</h3>'; */
			unset($_SESSION['user_id']); // So the person don't stay Logged In
			// header('Location: https://keepcool.fr');
			//die();
		}
		echo '<h5 class="bottom-logout"><a href="?action=logout">Log Out</a></h5>';
		/* echo '<h3>ID Token</h3>'; */
		/* echo '<pre>'; */
		/* print_r($_SESSION['userinfo']); */
		/* echo '</pre>'; */

		/* echo '<h3>User Info</h3>'; */
		/* echo '<pre>'; */
		// initialisation de la session
		// $ch = curl_init('https://www.googleapis.com/oauth2/v3/userinfo');
		// configuration des options
		/* curl_setopt($ch, CURLOPT_HTTPHEADER, [ */
		/* 	'Authorization: Bearer '.$_SESSION['access_token'] */
		/* ]); */
		// exécution de la session
		// curl_exec($ch);
		echo '</pre>';
	} else {
		//print(1111111111111);
        echo '<h2 class="heading">Google authentication</h2>';
		echo '<h3 class="state">Not logged in</h3>';
		echo '<p class="state"><a href="?action=login">Log In</a></p>';
		die();
	}
	//  die();
}
?>