<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $heading ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<?php echo link_tag('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>
<?php echo link_tag('assets/css/user_styles.css'); ?>
</head>
<body>
<div id="container">
  <div id="header">
    <div id="company_name">
    	<a href="<?php echo site_url('home'); ?>">FoodIgniter</a>
    </div>
    <div id="menu">
  		<ul>
     	<li><a href="<?php echo site_url('home'); ?>">Home</a></li>
     	<li><a href="<?php echo site_url('foods'); ?>">Food Menu</a></li>
     	<li><a href="specialdeals">Special Menu</a></li>
     	<li><a href="<?php echo site_url('cart'); ?>">Shopping Cart</a></li>
     	<li><a href="<?php echo site_url('account'); ?>">My Account</a></li>
     	<li><a href="contactus">Contact Us</a></li>
     	</ul>
     </div>
	</div>
<h1><?php echo $heading; ?></h1>
<div id="content">
<div class="content">
	<p><?php echo $message; ?></p>
</div>
</div>
<div id="footer">
    <div class="bottom_menu">
	<a href="<?php echo site_url('home'); ?>">Home Page</a>  |  
	<a href="<?php echo site_url('aboutus'); ?>">About Us</a>  |  
	<a href="<?php echo site_url('foods'); ?>">Food Zone</a>  |  
	<a href="<?php echo site_url('specialdeals'); ?>">Special Deals</a>  |  
    </div>
  	<div class="bottom_addr">&copy; 2012-2013 TastyIgniter. All Rights Reserved</div>
</div>
</div>
</body>
</html>