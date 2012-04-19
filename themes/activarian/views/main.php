<?php
/**
 * Activarian theme main template
 */
?>
<!-- main body -->
<div id="main" class="clearingfix">
	<div id="mainmiddle" class="floatbox withright">

	<?php if($site_message != '') { ?>
		<div class="green-box">
			<h3><?php echo $site_message; ?></h3>
		</div>
	<?php } ?>
	
	
		<!-- How to section-->
		<div id="howto" class="minimizable">
			<div class="minheader">
			About
			<span class="minbutton">[<a href="javascript:toggleLayer('aboutminbutton', 'howto_collapse')" id="aboutminbutton"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span>
			</div>
			<div id="howto_collapse">
				<table>
					<tr>
						<td>
							<h1 class="blackAndBold"> TAKE ACTION<BR/>PARTICIPATE NOW</BR>SHARE EXPERIENCES</h1>
							<a href="<?php echo url::base(); ?>reports/submit">
								<div id="bigreportbutton"></div>								
							</a>
						</td>
						<td>
							<div class="pics" id="howtopics">
							<div id="nav"></div>
							<?php 
								//get the images in the give folder
								$folder = DOCROOT . "themes/activarian/images/howto";
								$files = scandir($folder);
								foreach($files as $file)
								{
									//make sure it's not a folder
									if(is_dir($file)){continue;}
									//make sure it's of the right file format
									$extention = strtolower(substr($file, strlen($file)-3));
									if($extention == "jpg" OR $extention == "gif" OR $extention == "png")
									{
										echo '<img src="'.url::base().'themes/activarian/images/howto/'.$file.'"/>';
									}
								}
								
							?>
							</div>
							<script type="text/javascript">
								
								$('#howtopics').cycle({
									fx:     'scrollRight',
									speed:  'fast',
									timeout: 4000,
									pager:  '#nav',
									slideExpr: 'img'
								});
							</script>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /How to section-->
		<!--Reports section-->
		<div id="howto" class="minimizable">
			<div class="minheader">
				Reports
				<span class="minbutton">[<a href="javascript:toggleLayer('reportminbutton', 'reports_collapse')" id="reportminbutton"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span>
			</div>
			<div id="reports_collapse">
			<h1 class="blackAndBold"> <?php echo Kohana::lang('ui_main.reports');?></h1>
				<!--begin adding in the reports view-->
				<?php draw_report_list(); ?>
				<!--end adding in the reports view-->
			</div>
		</div>

		<!-- /Reports section-->

		
		<!-- right column -->
		<div id="right" class="clearingfix">
		
		<div id="howto" class="minimizable">
			<div class="minheader">
				Filters
				<span class="minbutton">[<a href="javascript:toggleLayer('columnminbutton', 'column_collapse')" id="columnminbutton"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span>
			</div>
		<div id="column_collapse">
	
			<!-- category filters -->
	
		
			<ul id="category_switch" class="category-filters">
				<li><a class="active" id="cat_0" href="#"><span class="swatch" style="background-color:<?php echo "#".$default_map_all;?>"></span><span class="category-title"><?php echo Kohana::lang('ui_main.all_categories');?></span></a></li>
				<?php
					foreach ($categories as $category => $category_info)
					{
						$category_title = $category_info[0];
						$category_color = $category_info[1];
						$category_image = '';
						$color_css = 'class="swatch" style="background-color:#'.$category_color.'"';
						if($category_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$category_info[2])) {
							$category_image = html::image(array(
								'src'=>Kohana::config('upload.relative_directory').'/'.$category_info[2],
								'style'=>'float:left;padding-right:5px;'
								));
							$color_css = '';
						}
						echo '<li><a href="#" id="cat_'. $category .'"><span '.$color_css.'>'.$category_image.'</span><span class="category-title">'.$category_title.'</span></a>';
						// Get Children
						echo '<div class="hide" id="child_'. $category .'">';
                                                if( sizeof($category_info[3]) != 0)
                                                {
                                                    echo '<ul>';
                                                    foreach ($category_info[3] as $child => $child_info)
                                                    {
                                                            $child_title = $child_info[0];
                                                            $child_color = $child_info[1];
                                                            $child_image = '';
                                                            $color_css = 'class="swatch" style="background-color:#'.$child_color.'"';
                                                            if($child_info[2] != NULL && file_exists(Kohana::config('upload.relative_directory').'/'.$child_info[2])) {
                                                                    $child_image = html::image(array(
                                                                            'src'=>Kohana::config('upload.relative_directory').'/'.$child_info[2],
                                                                            'style'=>'float:left;padding-right:5px;'
                                                                            ));
                                                                    $color_css = '';
                                                            }
                                                            echo '<li style="padding-left:20px;"><a href="#" id="cat_'. $child .'"><span '.$color_css.'>'.$child_image.'</span><span class="category-title">'.$child_title.'</span></a></li>';
                                                    }
                                                    echo '</ul>';
                                                }
						echo '</div></li>';
					}
				?>
			</ul>
			<!-- / category filters -->
			
			<?php
			if ($layers)
			{
				?>
				<!-- Layers (KML/KMZ) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.layers_filter');?> <span>[<a href="javascript:toggleLayer('kml_switch_link', 'kml_switch')" id="kml_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
				</div>
				<ul id="kml_switch" class="category-filters">
					<?php
					foreach ($layers as $layer => $layer_info)
					{
						$layer_name = $layer_info[0];
						$layer_color = $layer_info[1];
						$layer_url = $layer_info[2];
						$layer_file = $layer_info[3];
						$layer_link = (!$layer_url) ?
							url::base().Kohana::config('upload.relative_directory').'/'.$layer_file :
							$layer_url;
						echo '<li><a href="#" id="layer_'. $layer .'"
						onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
						<div>'.$layer_name.'</div></a></li>';
					}
					?>
				</ul>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<?php
			if ($shares)
			{
				?>
				<!-- Layers (Other Ushahidi Layers) -->
				<div class="cat-filters clearingfix" style="margin-top:20px;">
					<strong><?php echo Kohana::lang('ui_main.other_ushahidi_instances');?> <span>[<a href="javascript:toggleLayer('sharing_switch_link', 'sharing_switch')" id="sharing_switch_link"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span></strong>
				</div>
				<ul id="sharing_switch" class="category-filters">
					<?php
					foreach ($shares as $share => $share_info)
					{
						$sharing_name = $share_info[0];
						$sharing_color = $share_info[1];
						echo '<li><a href="#" id="share_'. $share .'"><div class="swatch" style="background-color:#'.$sharing_color.'"></div>
						<div>'.$sharing_name.'</div></a></li>';
					}
					?>
				</ul>
				<!-- /Layers -->
				<?php
			}
			?>
			
			
			<br />
		
			<!-- additional content -->
			<?php
			if (Kohana::config('settings.allow_reports'))
			{
				?>
				<div class="additional-content">
					<h5><?php echo Kohana::lang('ui_main.how_to_report'); ?></h5>
					<ol>
						<?php if (!empty($phone_array)) 
						{ ?><li><?php echo Kohana::lang('ui_main.report_option_1')." "; ?> <?php foreach ($phone_array as $phone) {
							echo "<strong>". $phone ."</strong>";
							if ($phone != end($phone_array)) {
								echo " or ";
							}
						} ?></li><?php } ?>
						<?php if (!empty($report_email)) 
						{ ?><li><?php echo Kohana::lang('ui_main.report_option_2')." "; ?> <a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a></li><?php } ?>
						<?php if (!empty($twitter_hashtag_array)) 
									{ ?><li><?php echo Kohana::lang('ui_main.report_option_3')." "; ?> <?php foreach ($twitter_hashtag_array as $twitter_hashtag) {
						echo "<strong>". $twitter_hashtag ."</strong>";
						if ($twitter_hashtag != end($twitter_hashtag_array)) {
							echo " or ";
						}
						} ?></li><?php
						} ?><li><a href="<?php echo url::site() . 'reports/submit/'; ?>"><?php echo Kohana::lang('ui_main.report_option_4'); ?></a></li>
					</ol>

				</div>
			<?php } ?>
			<!-- / additional content -->
			
			<?php
			// Action::main_sidebar - Add Items to the Entry Page Sidebar
			Event::run('ushahidi_action.main_sidebar');
			?>
	
		</div>
		<!-- / right column -->
		</div>
		</div>
	
	
		<!-- content column -->
		<div id="content" class="clearingfix">
		
		<div id="howto" class="minimizable">
			<div class="minheader">
				Map
				<span class="minbutton">[<a href="javascript:toggleLayer('mapminbutton', 'map_collapse')" id="mapminbutton"><?php echo Kohana::lang('ui_main.hide'); ?></a>]</span>
			</div>
		<div id="map_collapse">
		<h1 class="blackAndBold"> Where it's happening</h1>
		
			<div class="floatbox">

				<!-- filters -->
				<div class="filters clearingfix">
					<div style="float:left; width: 100%">
						<strong><?php echo Kohana::lang('ui_main.filters'); ?></strong>
						<ul>
							<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
							<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
							<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
							<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
							<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
						</ul>
					</div>


					<?php
					// Action::main_filters - Add items to the main_filters
					Event::run('ushahidi_action.map_main_filters');
					?>
				</div>
				<!-- / filters -->

				<?php								
				// Map and Timeline Blocks
				echo $div_map;
				echo $div_timeline;
				?>
			</div>
			</div>
			</div>
		</div>
		<!-- / content column -->

	</div>
</div>
<!-- / main body -->

<!-- content -->
<div class="content-container">

	<!-- content blocks -->
	<div class="content-blocks clearingfix">
		<ul class="content-column">
			<?php blocks::render(); ?>
		</ul>
	</div>
	<!-- /content blocks -->

</div>
<!-- content -->





















<?php

function draw_report_list()
{
	// Cacheable Controller
	$content = new View('reportslist');
	
	// Load the alert radius view
	$alert_radius_view = new View('alert_radius_view');
	$alert_radius_view->show_usage_info = FALSE;
	$alert_radius_view->enable_find_location = FALSE;
	$alert_radius_view->css_class = "rb_location-radius";
	
	$content->alert_radius_view = $alert_radius_view;
	
	// Get locale
	$l = Kohana::config('locale.language.0');
	
	// Get the report listing view
	$report_listing_view = _get_report_listing_view($l);
	
	// Set the view
	$content->report_listing_view = $report_listing_view;
	
	// Load the category
	$category_id = (isset($_GET['c']) AND intval($_GET['c']) > 0)? intval($_GET['c']) : 0;
	$category = ORM::factory('category', $category_id);

	if ($category->loaded)
	{
		$translated_title = Category_Lang_Model::category_title($category_id,$l);
		
		// Set the category title
		$content->category_title = ($translated_title)
			? $translated_title
			: $category->category_title;
	}
	else
	{
		$content->category_title = "";
	}

	// Collect report stats
	$content->report_stats = new View('reports_stats');
	// Total Reports

	$total_reports = Incident_Model::get_total_reports(TRUE);

	// Get the date of the oldest report
	$oldest_timestamp = Incident_Model::get_oldest_report_timestamp();
	
	// Get the date of the latest report
	$latest_timestamp = Incident_Model::get_latest_report_timestamp();

	// Round the number of days up to the nearest full day
	$days_since = ceil((time() - $oldest_timestamp) / 86400);
	$avg_reports_per_day = ($days_since < 1)? $total_reports : round(($total_reports / $days_since),2);
	
	// Percent Verified
	$total_verified = Incident_Model::get_total_reports_by_verified(TRUE);
	$percent_verified = ($total_reports == 0) ? '-' : round((($total_verified / $total_reports) * 100),2).'%';
	
	// Category tree view
	$content->category_tree_view = category::get_category_tree_view();
	
	// Additional view content
	$content->oldest_timestamp = $oldest_timestamp;
	$content->latest_timestamp = $latest_timestamp;
	$content->report_stats->total_reports = $total_reports;
	$content->report_stats->avg_reports_per_day = $avg_reports_per_day;
	$content->report_stats->percent_verified = $percent_verified;
	$content->services = Service_Model::get_array();

	echo $content;
	

}
	/**
	 * Helper method to load the report listing view
	 */
	function _get_report_listing_view($locale = '')
	{
		// Check if the local is empty
		if (empty($locale))
		{
			$locale = Kohana::config('locale.language.0');
		}
		
		// Load the report listing view
		$report_listing = new View('reports_listing');
		
		// Fetch all incidents
		$all_incidents = reports::fetch_incidents();
		
		// Pagination
		$pagination = new Pagination(array(
				'style' => 'front-end-reports',
				'query_string' => 'page',
				'items_per_page' => (int) Kohana::config('settings.items_per_page'),
				'total_items' => $all_incidents->count()
				));

		// Reports
		$incidents = Incident_Model::get_incidents(reports::$params, $pagination);
		
		// Swap out category titles with their proper localizations using an array (cleaner way to do this?)
		$localized_categories = array();
		foreach ($incidents as $incident)
		{
			$incident = ORM::factory('incident', $incident->incident_id);
			foreach ($incident->category AS $category)
			{
				$ct = (string)$category->category_title;
				if ( ! isset($localized_categories[$ct]))
				{
					$translated_title = Category_Lang_Model::category_title($category->id, $locale);
					$localized_categories[$ct] = $category->category_title;
					if ($translated_title)
					{
						$localized_categories[$ct] = $translated_title;
					}
				}
			}
		}
		// Set the view content
		$report_listing->incidents = $incidents;
		$report_listing->localized_categories = $localized_categories;
		
		//Set default as not showing pagination. Will change below if necessary.
		$report_listing->pagination = "";

		// Pagination and Total Num of Report Stats
		$plural = ($pagination->total_items == 1)? "" : "s";
		
		// Set the next and previous page numbers
		$report_listing->next_page = $pagination->next_page;
		$report_listing->previous_page = $pagination->previous_page;

		if ($pagination->total_items > 0)
		{
			$current_page = ($pagination->sql_offset/ $pagination->items_per_page) + 1;
			$total_pages = ceil($pagination->total_items/ $pagination->items_per_page);

			if ($total_pages >= 1)
			{
				$report_listing->pagination = $pagination;
				
				// Show the total of report
				// @todo This is only specific to the frontend reports theme
				$report_listing->stats_breadcrumb = $pagination->current_first_item.'-'
											. $pagination->current_last_item.' of '.$pagination->total_items.' '
											. Kohana::lang('ui_main.reports');
			}
			else
			{ // If we don't want to show pagination
				$report_listing->stats_breadcrumb = $pagination->total_items.' '.Kohana::lang('ui_admin.reports');
			}
		}
		else
		{
			$report_listing->stats_breadcrumb = '('.$pagination->total_items.' report'.$plural.')';
		}
		
		// Return
		return $report_listing;
	}

?>
