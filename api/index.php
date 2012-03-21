<?php

	// test if the code is set
	function code_in_array($code, $array){
		include_once "code.php";
		if (in_array($code, $CODE)) {
			return true;
			}
		else {
			return false;
			}
		}

	// API Cookie status
	if ((isset($_GET['cookie_status'])) && (isset($_GET['code']))){
		$content = 'ERROR';
		if (code_in_array($_GET['code'])) {
			$content = '1';
		} else {
			$content = '0';
		}
		echo $content;
		}

	// API Logout
	if ((isset($_GET['logout'])) && (isset($_GET['code']))){
		if ((code_in_array($_GET['code'])) && (setcookie("verify", '', 0, '/'))){
			if (isset($_GET['redirect_url'])){
				header('Location: ' . $_GET['redirect_url']);
				exit();
				}
			}
		}

?>
