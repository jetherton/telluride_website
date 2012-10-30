<div id="content">
	<div class="content-bg">
		<!-- start contacts block -->
		<div class="big-block">
		<div class="report_left">
			<h1><?php echo Kohana::lang('ui_main.contact'); ?></h1>
			<div id="contact_us" class="contact">
				<?php
				if ($form_error)
				{
					?>
					<!-- red-box -->
					<div class="red-box">
						<h3>Error!</h3>
						<ul>
							<?php
							foreach ($errors as $error_item => $error_description)
							{
								print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
							}
							?>
						</ul>
					</div>
					<?php
				}

				if ($form_sent)
				{
					?>
					<!-- green-box -->
					<div class="green-box">
						<h3><?php echo Kohana::lang('ui_main.contact_message_has_send'); ?></h3>
					</div>
					<?php
				}								
				?>
				<?php print form::open(NULL, array('id' => 'contactForm', 'name' => 'contactForm')); ?>
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_name'); ?>:</strong><br />
					<?php print form::input('contact_name', $form['contact_name'], ' class="text"'); ?>
				</div>
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_email'); ?>:</strong><br />
					<?php print form::input('contact_email', $form['contact_email'], ' class="text"'); ?>
				</div>
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_phone'); ?>:</strong><br />
					<?php print form::input('contact_phone', $form['contact_phone'], ' class="text"'); ?>
				</div>
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_subject'); ?>:</strong><br />
					<?php print form::input('contact_subject', $form['contact_subject'], ' class="text"'); ?>
				</div>								
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_message'); ?>:</strong><br />
					<?php print form::textarea('contact_message', $form['contact_message'], ' rows="4" cols="40" class="textarea long" ') ?>
				</div>		
				<div class="report_row">
					<strong><?php echo Kohana::lang('ui_main.contact_code'); ?>:</strong><br />
					<?php print $captcha->render(); ?><br />
					<?php print form::input('captcha', $form['captcha'], ' class="text"'); ?>
				</div>
				<div class="report_row">
					<input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.contact_send'); ?>" class="btn_submit" />
				</div>
				<?php print form::close(); ?>
			</div>
			</div>
			<!-- end of report_left -->
			<div class="report_right" style="padding: 0px 20px 20px 20px;">
			<h1>Activarian Telluride</h1>
			<h2>A network of global citizens based in Telluride, Colorado</h2>
			<p>
			<br/><br/>Jack Baringer<br/><br/>
			Jack.activarian@gmail.com<br/><br/>
			<a href="http://activariannetwork.org/">http://activariannetwork.org/</a><br/><br/>
			202-486-5539<br/><br/>
			Telluride, Colorado, USA
			</p>
			
			</div>
		</div>
		<!-- end contacts block -->
	</div>
</div>