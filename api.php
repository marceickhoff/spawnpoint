<?php
	header("Content-Type: application/json; charset=UTF-8");
	require_once 'Steam.class.php';
	echo json_encode(Steam::get(true));
?>