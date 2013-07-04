<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title ?></title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<?php echo link_tag('assets/css/admin_styles.css'); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<h1><?php echo $title ?></h1>
	</div>
  	<div id="menu"><ul>
		<li><a href="<?php echo base_url('admin/dashboard'); ?>">Dashboard/Profile</a> | </li>
		<li><a href="<?php echo base_url('admin/categories'); ?>">Categories</a> | </li>
		<li><a href="<?php echo base_url('admin/foods'); ?>">Foods</a> | </li>
		<li><a href="accounts.php">Accounts</a> | </li>
		<li><a href="orders.php">Orders</a> | </li>
		<li><a href="reservations.php">Reservations</a> | </li>
		<li><a href="specials.php">Specials</a> | </li>
		<li><a href="allocation.php">Staff</a> | </li>
		<li><a href="messages.php">Messages</a> | </li>
		<li><a href="options.php">Settings</a> | </li>
		<li><a href="<?php echo base_url('admin/logout'); ?>">Logout</a></li>
     </ul>
    </div>
	<div id="content">
		<div id="notification"></div>