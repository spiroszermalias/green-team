<?php

    $to = "info@green-team.gr";
	$from = $_REQUEST['email'];
	$name = $_REQUEST['name'];
	$cmessage = $_REQUEST['message'];
	if(isset($_POST['g-recaptcha-response'])){
		$captcha=$_POST['g-recaptcha-response'];
	  }
	  if(!$captcha){
		echo '<h2>Please check the the captcha form.</h2>';
		exit;
	  }
	  $secretKey = "6Lca2zQaAAAAAEViw4hqAqyR__T9Qta0CbI4QKBT";
	  $ip = $_SERVER['REMOTE_ADDR'];
	  // post request to server
	  $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
	  $response = file_get_contents($url);
	  $responseKeys = json_decode($response,true);
	  // should return JSON with success as true
	  if($responseKeys["success"]) {
		if (isset($from) && isset($name) && isset($cmessage)) {
			$subject = $_REQUEST['subject'];
			$headers = "From: $from";
			$headers = "From: " . $from . "\r\n";
			$headers .= "Reply-To: ". $from . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		
			$logo = 'img/logo.png';
			$link = 'http://green-team.gr';
		
			$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
			$body .= "<table style='width: 100%;'>";
			$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
			$body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
			$body .= "</td></tr></thead><tbody><tr>";
			$body .= "<td style='border:none;'><strong>Name:</strong> {$name}</td>";
			$body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
			$body .= "</tr>";
			$body .= "<tr><td style='border:none;'><strong>Subject:</strong> {$csubject}</td></tr>";
			$body .= "<tr><td></td></tr>";
			$body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
			$body .= "</tbody></table>";
			$body .= "</body></html>";
		
			$send = mail($to, $subject, $body, $headers);
			 echo "<script>window.close();</script>";
		}
	  } else {
			  echo '<h2>Spam</h2>';
	  }
    
?>