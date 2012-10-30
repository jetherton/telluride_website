<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo $site_name; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
	<?php echo $header_block; ?>
		<?php
	// Action::header_scripts - Additional Inline Scripts from Plugins
	Event::run('ushahidi_action.header_scripts');
	?>
</head>

<body id="page">
  <!-- top bar-->
  <div id="top-bar">
    <!-- searchbox -->
		<div id="searchbox">
			
			<!-- languages -->
			<?php echo $languages;?>
			<!-- / languages -->

			<!-- searchform -->
			<?php echo $search; ?>
			<!-- / searchform -->
			
			<!-- user actions -->
			<div id="loggedin_user_action" class="clearingfix">
				<?php if($loggedin_username != FALSE){ ?>
					<a href="<?php echo url::site().$loggedin_role;?>"><?php echo $loggedin_username; ?></a> <a href="<?php echo url::site();?>logout/front"><?php echo Kohana::lang('ui_admin.logout');?></a>
				<?php } else { ?>
					<a href="<?php echo url::site()."members/";?>"><?php echo Kohana::lang('ui_main.login'); ?></a>
				<?php } ?>
			</div>
			<!-- / user actions -->
    </div>
  </div>
  <!-- / searchbox -->


	<!-- wrapper -->
	<div class="rapidxwpr floatholder">

		<!-- header -->
		<div id="header">
			
			<!-- logo -->
			<?php if($banner == NULL){ ?>
			<div id="logo">
				<a href="http://www.activariannetwork.org"><img class="aligncenter" title="am" src="<?php echo url::site(); ?>themes/bueno/images/activariannetworkweblogo3.png" alt="" width="400" height="44" /></a>
			</div>
			
			<div id="logo2"><a href="https://market.android.com/details?id=org.activariannetwork.occupy.app&feature=search_result#?t=W251bGwsMSwyLDEsIm9yZy5hY3RpdmFyaWFubmV0d29yay5vY2N1cHkuYXBwIl0." TARGET="_blank"><img class="aligncenter" title="am" src="<?php echo url::site(); ?>themes/bueno/images/am2.png" alt="" width="156" height="60" /></a>&nbsp&nbsp<a href="http://itunes.apple.com/us/app/occupy-i-witness/id481565033?mt=8&ls=1" TARGET="_blank"><img class="aligncenter" title="as" src="<?php echo url::site(); ?>themes/bueno/images/as4.png" alt="" width="156" height="60" /></a></div>
			
			<div id="logo3"></div>
			
			<?php }else{ ?>
			<a href="<?php echo url::site();?>"><img src="<?php echo url::base().Kohana::config('upload.relative_directory')."/".$banner; ?>" alt="<?php echo $site_name; ?>" /></a>
			<?php } ?>
			<!-- / logo -->
			
			<!-- submit incident -->
			<?php echo $submit_btn; ?>
			<!-- / submit incident -->
			
		</div>
		<!-- / header -->

		<!-- main body -->
		<div id="middle">
			<div class="background layoutleft">

				<!-- mainmenu -->
				<div id="mainmenu" class="clearingfix">
					<ul>
						<?php nav::main_tabs($this_page); ?>
					</ul>

				</div>
				<!-- / mainmenu -->
