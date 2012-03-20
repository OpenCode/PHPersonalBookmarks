<?php

	//include "class/password_protect.php";

	// API Cookie status
	if (isset($_GET['cookie_status'])){
		$content = '-';
		if (!isset($_COOKIE['verify'])) {
			$content = '0';
		} else {
			$content = '1';
		}
		echo $content;
		}

	// API Logout
	if (isset($_GET['logout'])){
		if ( setcookie("verify", '', 0, '/')){
			if (isset($_GET['redirect_url'])){
				header('Location: ' . $_GET['redirect_url']);
				exit();
				}
			else {
				$content = '1';
				}
			}
		else {
			$content = '0';
			}
		echo $content;
		}

?>
