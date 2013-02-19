<div id="contact-form">
	<?php if (isset($_POST['submit'])) {

	//if (defined('WP_DEBUG') && WP_DEBUG) allt_print($_POST);

	$spam = filter_var(trim($_POST['spamcheck']), FILTER_SANITIZE_STRING);
	$from = filter_var(trim(strip_tags($_POST['from'])), FILTER_SANITIZE_STRING);
	$email = trim($_POST['email']);
	$subject = filter_var(trim( $_POST['subject']), FILTER_SANITIZE_STRING);
	//$message = filter_var( trim( $_POST['text'] ), FILTER_SANITIZE_STRING);
	$message = wp_kses_post($_POST['text']);

	if (isset($_POST['cc'])) $cc = intval($_POST['cc']);
	else $cc = FALSE;

	if (!empty($spam)) {
		$spam_error = __('Spammer? The spam protection field needs to be empty.', ALLT_TXT_DOMAIN);
		$has_error = TRUE;
	}

	if (empty($from)) {
		$from_error = __('Please enter your name.', ALLT_TXT_DOMAIN);
		$has_error  = TRUE;
	}

	if (empty($email)) {
		$email_error = __('Please enter your e-mail adress.', ALLT_TXT_DOMAIN);
		$has_error = TRUE;
	} else if (!is_email($email)) {
		$email_error = __('Please enter a valid e-mail adress.', ALLT_TXT_DOMAIN);
		$has_error = TRUE;
	}

	if (empty($subject)) {
		$subject_error = __('Please enter a subject.', ALLT_TXT_DOMAIN);
		$has_error = TRUE;
	}

	if (empty($message)) {
		$message_error = __('Please enter a message.', ALLT_TXT_DOMAIN);
		$has_error = TRUE;
	}

	if (!isset($has_error)) {
		if (is_email(allt_opt_get('general_email'))) $email_to = allt_opt_get('general_email');
		else $email_to = get_option('admin_email');
		$subject = $subject . ' ' . __('[via contact form] from', ALLT_TXT_DOMAIN) . ' ' . $from;
		$body = __('Message:', ALLT_TXT_DOMAIN) . ' ' . $message . "\n\n" .
			__('Name:', ALLT_TXT_DOMAIN ) . ' ' . $from . "\n" .
			__('E-mail:', ALLT_TXT_DOMAIN ) . ' ' . $email . "\n" .
			$headers  = 'From: ' . $from . ' <' . $email . '>' . "\r\n";
		if ($cc) $headers .= 'Reply-To: ' . $email;

		if (wp_mail($email_to, $subject, $body, $headers)) $email1_sent = TRUE;
		if ($cc && wp_mail($email, __( 'CC:', ALLT_TXT_DOMAIN ) . ' ' . $subject, $body, $headers)) $email2_sent = TRUE;
	}
} ?>

	<form action="<?php the_permalink(); ?>" method="post" class="form-horizontal">
		<fieldset>
			<?php // Errors
			if (isset($spam_error)) echo '<div class="alert alert-error">' . $spam_error . '</div>';
			if (isset($email1_sent)) {
				echo '<div class="alert alert-success">';
				echo __('Thank you, your message was successfully sent. ', ALLT_TXT_DOMAIN);
				if (isset($email2_sent)) echo __('A confirmation e-mail has also been sent to your address.', ALLT_TXT_DOMAIN);
				echo '</div>';
			} ?>

			<div class="control-group <?php if (isset($from_error)) echo 'error'; ?>">
				<label for="from" class="control-label">
					<?php _e('Name', ALLT_TXT_DOMAIN); ?>
				</label>
				<div class="controls">
					<input class="input-xlarge" type="text" id="from" name="from" placeholder="<?php _e('Your name', ALLT_TXT_DOMAIN); ?>" value="<?php if ( isset( $from ) ) echo $from; ?>" />
					<?php if (isset($from_error)) echo '<span class="help-inline">' . $from_error . '</span>'; ?>
				</div>
			</div>

			<div class="control-group <?php if (isset($email_error)) echo 'error'; ?>">
				<label for="email" class="control-label">
					<?php _e('E-mail', ALLT_TXT_DOMAIN); ?>
				</label>
				<div class="controls">
					<input class="input-xlarge" type="text" placeholder="<?php _e('john@doe.com', ALLT_TXT_DOMAIN); ?>" id="email" name="email" value="<?php if ( isset( $email ) ) echo $email; ?>" />
					<?php if (isset($email_error)) echo '<span class="help-inline">' . $email_error . '</span>'; ?>
				</div>
			</div>

			<div class="control-group <?php if (isset($subject_error)) echo 'error'; ?>">
				<label for="subject" class="control-label">
					<?php _e('Subject', ALLT_TXT_DOMAIN); ?>
				</label>
				<div class="controls">
					<input class="input-xlarge" type="text" placeholder="<?php _e('Message', ALLT_TXT_DOMAIN); ?>" id="subject" name="subject" value="<?php if ( isset( $subject ) ) echo $subject; ?>" />
					<?php if (isset($subject_error)) echo '<span class="help-inline">' . $subject_error . '</span>'; ?>
				</div>
			</div>

			<div class="control-group <?php if (isset($message_error)) echo 'error'; ?>">
				<label for="text" class="control-label">
					<?php _e('Message', ALLT_TXT_DOMAIN); ?>
				</label>
				<div class="controls">
					<textarea rows="10" id="text" name="text" placeholder="<?php _e('Your message &#x0085;', ALLT_TXT_DOMAIN); ?>"><?php if ( isset( $message ) ) echo $message; ?></textarea>
					<?php if (isset($message_error)) echo '<span class="help-inline">' . $message_error . '</span>'; ?>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<label for="cc">
						<input type="checkbox" class="checkbox" id="cc" name="cc" value="1" <?php if ( isset( $cc ) ) checked('1', $cc ); ?> />
						<?php _e('Receive a copy of this message?', ALLT_TXT_DOMAIN ); ?>
					</label>
				</div>
			</div>

			<div class="control-group" style="display: none !important;">
				<label for="text">
					<?php _e('Spam protection', ALLT_TXT_DOMAIN); ?>
				</label>
				<div class="controls">
					<input name="spamcheck" class="spamcheck" type="text" />
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input class="submit button" type="submit" name="submit" value="<?php _e('Send e-mail', ALLT_TXT_DOMAIN); ?>" />
				</div>
			</div>
		</fieldset>
	</form>
</div>