<?php

include_once '../src/rsa.php';

use zpfei\hasher\Rsa;


session_start();

if (empty($_POST)) {
	$rsa = new Rsa();
	$keys = $rsa->createKeys();
	$_SESSION['privateKey'] = $keys['privateKey'];
	$publicKey = $keys['publicKey'];
	include_once 'index.html';
} else {
	echo "加密数据:<br/> username: {$_POST['username']}<br/> password: {$_POST['password']} <br/>";
	$username = Rsa::decode($_SESSION['privateKey'],base64_decode($_POST['username']));
	$password = Rsa::decode($_SESSION['privateKey'],base64_decode($_POST['password']));
	echo "<hr/>解密数据:<br/> username: {$username}<br/> password: {$password} <br/>";
}


?>