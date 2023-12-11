<?php

if(isset($_POST['m'])){
		if($_POST['m'] == '1') {		
			$email = $_POST['email'];
			$name = $_POST['name'];
			$message = $_POST['message'];
			
			$message = "Mittente: $name.\nEmail: $email.\nMessaggio: $message";
            
			$headers = "From: $name <$email>";
			session_start();
			$send = true;
			
			$return_message = "";
			$return_status = 0;
			
			if(isset($_SESSION["LAST_MAIL_TIME"])) {
				$diffInSeconds = date_create()->getTimestamp() - $_SESSION["LAST_MAIL_TIME"];
				$minutes = 5;
				if($diffInSeconds <= $minutes * 60) {
					$send = false;
					$return_message = "Attendi ".intval( ($minutes * 60 - $diffInSeconds) / 60)." minuti per inviare una nuova Mail.";
					$return_status = 100;
				}
			}
			
			if($send) {
				$_SESSION["LAST_MAIL_TIME"] =  date_create()->getTimestamp();
				mail("rosario9617@gmail.com", "Hai un nuovo messaggio da $name", $message, $headers);
				$return_message = 'Grazie per avermi contattato! Ti farò sapere al più presto.';
				$return_status = 200;
			}
			
			echo '{"status":'.$return_status.',"message":"'.$return_message.'"}';
		}
	}
?>