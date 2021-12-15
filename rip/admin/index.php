<?php

session_start();

if(isset($_SESSION['logged_user'])){
	require 'index2.php';
	
}else{
	require '../nezareg/index.php';

}