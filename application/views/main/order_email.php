<<<<<<< HEAD
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $text_heading ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="container">
<div id="content">
<table width="80%" class="order_confirmation">
	<tr>
    	<td><?php echo $text_greetings; ?></td>
    </tr>
	<tr>
    	<td><?php echo $message; ?></td>
    </tr>
    <tr>
        <td><h4><?php echo $text_order_details; ?></h4></td>
    </tr>
    <tr>
        <td><?php echo $order_details; ?></td>
    </tr>
   	<tr>
        <td><h4><?php echo $text_order_items; ?></h4></td>
   	</tr>
   	<tr>
   		<td>
			<table>
			<?php foreach ($menus as $menu) { ?>
			<tr>
				<td><?php echo $menu['name']; ?><br />
				<?php if (!empty($menu['options'])) { ?>
					<?php foreach ($menu['options'] as $option_name => $option_value) { ?>
						<div><font size="1"><strong><?php echo $option_name; ?></strong></font></div>
					<?php } ?>
				<?php } ?></td>
			 	<td>x <?php echo $menu['qty']; ?></td>
			 </tr>		
			<?php } ?>
			</table
   		</td>
   	</tr>
   	<tr>
   		<td><?php echo $order_total; ?></td>
   	</tr>
	<?php if ($delivery_address) { ?>
   	<tr>
        <td><h4><?php echo $text_delivery_address; ?></h4></td>
   	</tr>
   	<tr>
   		<td><address><?php echo $delivery_address['address_1']; ?>, <?php echo $delivery_address['address_2']; ?>, <?php echo $delivery_address['city']; ?>, <?php echo $delivery_address['postcode']; ?>, <?php echo $delivery_address['country_name']; ?></address></td>
   	</tr>
	<?php } ?>
   	<tr>
        <td><h4><?php echo $text_local; ?></h4></td>
   	</tr>
   	<tr>
    	<td><?php echo $location_name; ?></td>
   	</tr>
	<tr>
		<td><br /><br /><?php echo $text_thank_you; ?></td>
	</tr>
</table>
</div>
</div>
</body>
=======
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
>>>>>>> 0d7f0809e8d8939f91f8bd00c1efa703e8da114e
</html>