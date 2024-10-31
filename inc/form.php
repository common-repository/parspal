<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>style.css" type="text/css" />
<div class="payment-form">
	<form action="" method="post">
		<table width="100%">
			<tr>
				<td><?php _e('Your name', 'parspal'); ?></td>
				<td>
					<input type="text" name="payer_name" class="parspal-input" value="<?php echo $current_user->display_name; ?>"/>
					<span class="description-require">*</span>
				</td>
			</tr>

			<tr>
				<td><?php _e('Your email', 'parspal'); ?></td>
				<td>
					<input type="text" name="payer_email" dir="ltr" class="parspal-input" value="<?php echo $current_user->user_email; ?>"/>
					<span class="description-require">*</span>
				</td>
			</tr>

			<tr>
				<td><?php _e('Your mobile', 'parspal'); ?></td>
				<td>
					<input type="text" name="payer_mobile" dir="ltr" value="09" class="parspal-input"/>
					<span class="description-require">*</span>
				</td>
			</tr>

			<tr>
				<td><?php _e('Price', 'parspal'); ?></td>
				<td>
					<input type="text" name="payer_price" dir="ltr" class="parspal-input"/>
					<span class="description-require">*</span>
					<br /><span class="description-field"><?php _e('To toman', 'parspal'); ?></span>
				</td>
			</tr>

			<tr>
				<td><?php _e('Description Payment', 'parspal'); ?></td>
				<td>
					<textarea name="description_payment" class="parspal-input"></textarea>
					<span class="description-require">*</span>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<input type="submit" name="submit_payment" value="<?php _e('Submit', 'parspal'); ?>" class="parspal-submit"/>
				</td>
			</tr>
		</table>
	</form>
</div>