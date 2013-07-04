<div class="content">
	<table width="1000" align="center" style="text-align:center">
		<CAPTION><h3>CURRENT STATUS</h3></CAPTION>
		<thead>
    		<th>Members Registered</th>
   			<th>Orders Placed</th>
    		<th>Orders Processed</th>
    		<th>Orders Pending</th>  
    		<th>Table(s) Reserved</th>
    		<th>Table(s) Allocated</th>
    		<th>Table(s) Pending</th>
    		<th>PartyHall(s) Reserved</th>
    		<th>PartyHall(s) Allocated</th>
    		<th>PartyHall(s) Pending</th>    
        </thead>
		<tbody>
		<tr>
			<td><?php echo $total_members; ?></td>
			<td><?php echo $total_orders; ?></td>
			<td><?php echo $total_orders_processed; ?></td>
			<td><?php echo $total_orders_pending; ?></td>
			<td><?php echo $total_tables_reserved; ?></td>
			<td><?php echo $total_tables_allocated; ?></td>
			<td><?php echo $total_tables_pending; ?></td>
			<td><?php echo $total_partyhalls_reserved; ?></td>
			<td><?php echo $total_partyhalls_allocated; ?></td>
			<td><?php echo $total_partyhalls_pending; ?></td>
		</tr>
		</tbody>
	</table>
<hr>
	<?php echo form_open('admin/dashboard') ?>
    <table width="360" align="center">
    <CAPTION><h3>CUSTOMERS' RATINGS (100%)</h3></CAPTION>
    	<tr>
        	<td>Select Food</td>
            <td><select name="food" id="food">
			<?php foreach ($foods as $food) { ?>
  				<option value="<?php echo $food['food_id']; ?>"> - <?php echo $food['food_name']; ?> - </option>  	

			<?php } ?>
            </select></td>
            <td><input type="submit" name="Submit" value="Show Ratings" /></td>
         </tr>
    </table>
	</form>
	<table width="900" align="center">
		</thead>
    		<th></th>
    		<th>Excellent</th>
    		<th>Good</th>
    		<th>Average</th>
    		<th>Bad</th>
    		<th>Worse</th>
    	</thead>
    	<tbody>
			<td><?php echo $rating_food_name; ?></td>
			<td><?php echo $excellent_value; ?> (<?php echo $excellent_rate; ?>%)</td>
			<td><?php echo $good_value; ?> (<?php echo $good_rate; ?>%)</td>
			<td><?php echo $average_value; ?> (<?php echo $average_rate; ?>%)</td>
			<td><?php echo $bad_value; ?> (<?php echo $bad_rate; ?>%)</td>
			<td><?php echo $worse_value; ?> (<?php echo $worse_rate; ?>%)</td>
    	</tbody>
    </table>
<hr>  
<!--Results <?php echo print_r($ratings_results) ?>
  <br /><br /><br /><br /><br />-->
</div>