<?php

ob_start();
session_start();

if ($_POST['id']) {
	$_SESSION['hackfest_teams']['id'] = $_POST['id'];
	$_SESSION['hackfest_teams']['hackfest_category_id'] = $_POST['hackfest_category_id'];
}

?>
