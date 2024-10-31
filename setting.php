<div class="wrap">
	<h2><?php _e('Parspal Setting', 'parspal'); ?></h2>
	<form method="post" action="options.php">
		<table class="form-table">
			<?php wp_nonce_field('update-options');?>
			<tr><th colspan="2"><h3><?php _e('General Setting', 'parspal'); ?></h4></th></tr>
			<tr>
				<td width="20%"><?php _e('Your Server IP:', 'parspal'); ?></td>
				<td>
					<code><?php echo $_SERVER['SERVER_ADDR']; ?></code>
					<br /><span style="font-size: 10px"><?php _e('Your Server IP server for the Parspal', 'parspal'); ?></span>
				</td>
			</tr>

			<tr>
				<td width="20%"><?php _e('Merchant ID:', 'parspal'); ?></td>
				<td>
					<input type="text" dir="ltr" name="MerchantID" value="<?php echo get_option('MerchantID'); ?>"/>
					<br /><span style="font-size: 10px"><?php _e('Your Merchant ID in the Parspal', 'parspal'); ?></span>
				</td>
			</tr>

			<tr>
				<td width="20%"><?php _e('Port Password:', 'parspal'); ?></td>
				<td>
					<input type="text" dir="ltr" name="port_password" value="<?php echo get_option('port_password'); ?>"/>
					<br /><span style="font-size: 10px"><?php _e('Your Port Password in the Parspal', 'parspal'); ?></span>
				</td>
			</tr>

			<tr>
				<td>
					<p class="submit">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="MerchantID,port_password" />
					<input type="submit" class="button-primary" name="Submit" value="به روز رساني" />
					</p>
				</td>
			</tr>
		</table>
	</form>
</div>