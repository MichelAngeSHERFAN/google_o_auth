<?php require "google_o_auth.php";?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">
	<title>Converter</title>
	<!-- vuejs -->
	<script src="vue.min.js"></script>
</head>

<body style="background-color:#ccc">
	<div id="app">
		<div class="w3-main w3-padding" style="margin-top:50px">
			<div style="padding:0">
				<div class="w3-card-2 w3-half w3-center w3-white" style="float:none; margin:auto">
					<header class="w3-container w3-blue">
						<h3>KC Converter</h3>
					</header>

					<div class="w3-container">
						<p>
							<input type="file" v-on:change="loadFile" />
						</p>
						<div v-if="xml != null">
							<div style="text-align:left;padding-left:10px;" v-for="line in xml">{{line}}<br/></div>
			<br />
						<a :href="csv" class="w3-button w3-green" download="export.csv">Download</a>
						</div>
					</div>
				</div>
				</div>
		</div>
	</div>
	<!-- app -->
	<script src="app.js"></script>
</body>

</html>
