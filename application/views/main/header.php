<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $heading ?></title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<?php echo link_tag('assets/css/user_styles.css'); ?>
</head>
<body>
<div id="container">
  <div id="menu">
    <div id="company_name">
    	<a href="<?php echo site_url('home'); ?>">FoodIgniter</a>
    </div>
  	<ul>
     <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
     <li><a href="<?php echo site_url('foods'); ?>">Food Menu</a></li>
     <li><a href="specialdeals">Special Menu</a></li>
     <li><a href="<?php echo site_url('cart'); ?>">Shopping Cart</a></li>
     <li><a href="<?php echo site_url('account'); ?>">My Account</a></li>
     <li><a href="contactus">Contact Us</a></li>
     </ul>
  </div>
<div id="header">
	<h1><?php echo $heading; ?></h1>
</div>
<div id="content">
<div id="notification"></div>