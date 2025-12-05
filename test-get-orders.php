<?php
session_start();
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = 2;

require 'api/orders/get-orders.php';
