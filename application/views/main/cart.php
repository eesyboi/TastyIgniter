<div class="content">
	<?php if ($foods) {?>
	<?php echo validation_errors(); ?>
	<?php echo form_open('cart') ?>
    <table width="90%" height="auto" align="center" cellspacing="10">
        <thead>
        <tr>
        	<th>Food Photo</th>
        	<th align="left">Food</th>
            <th>Quantity</th>
        	<th>Food Price</th>
        	<th>Total Cost</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ($foods as $food) { ?>
		<tr>
			<td align="center"><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $food['food_photo']; ?>" width="80" height="70"></a></td>
			<td width="50%"><?php echo $food['food_name']; ?><br />
				<?php echo $food['food_description']; ?><br />
				<?php echo $food['category_name']; ?>
			</td>
			<td align="center"><select name="quantity[<?php echo $food['key']; ?>]">
				<option value="<?php echo $food['quantity_value']; ?>"><?php echo $food['quantity_value']; ?></option>
				<option value="2">2</option>
				<option value="3">3</option>
			</select></td>
			<td align="center"><?php echo $food['food_price']; ?></td>
        	<td align="center"><?php echo $food['sub_total']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="3" align="right"><input type="submit" name="submit" value="Update Cart" /></td>
			<td align="right"><strong>Total:</strong></td>
			<td align="center"><?php echo $total; ?></td>
		</tr>
        </tbody>
    </table>
	</form>
	<?php } else { ?>
		<p><?php echo $text_no_foods; ?></p>
	<?php } ?>
</div>
<div class="buttons">
	<div class="left"><a href="<?php echo $continue; ?>">Continue</a></div>
	<div class="right"><a href="<?php echo $checkout; ?>">Checkout Now</a></div>
</div>