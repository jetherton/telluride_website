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
	
	
	
	
	
	
	
	
	
	
	<?php 
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	///Make sure this is only used when on the home page
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	if(Router::$controller == "main") { ?>
	
	<script type="text/javascript" src="<?php echo url::base(); ?>themes/activarian_minimal/js/jquery-ui-personalized-1.5.2.packed.js"></script>	
	<script type="text/javascript" src="<?php echo url::base(); ?>themes/activarian_minimal/js/sprinkle.js"></script>
	
<script type="text/javascript">

<?php @require_once(APPPATH.'views/map_common_js.php'); ?>



	// Tracks the current URL parameters
	var urlParameters = <?php echo json_encode($_GET); ?>;
	var deSelectedFilters = [];
	
	// Lat/lon and zoom for the map
	var latitude2 = <?php echo Kohana::config('settings.default_lat'); ?>;
	var longitude2 = <?php echo Kohana::config('settings.default_lon'); ?>;
	var defaultZoom2 = <?php echo Kohana::config('settings.default_zoom'); ?>;
	
	// Track the current latitude and longitude on the alert radius map
	var currLat, currLon;
	
	// Tracks whether the map has already been loaded
	var mapLoaded = 0;
	
	// Map object
	var map2 = null;
	var radiusMap = null;
	
	if (urlParameters.length == 0)
	{
		urlParameters = {};
	}
	
	$(document).ready(function() {
		  
		// "Choose Date Range"" Datepicker
		var dates = $( "#report_date_from, #report_date_to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "report_date_from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
		  
		/**
		 * Date range datepicker box functionality
		 * Show the box when clicking the "change time" link
		 */
		$(".btn-change-time").click(function(){
			$("#tooltip-box").css({
				'left': ($(this).offset().left - 80),
				'top': ($(this).offset().right)
			}).show();
			
	        return false;
		});
			
		  	
		/**
		 * Change time period text in page header to reflect what was clicked
		 * then hide the date range picker box
		 */
		$(".btn-date-range").click(function(){
			// Change the text
			$(".time-period").text($(this).attr("title"));
			
			// Update the "active" state
			$(".btn-date-range").removeClass("active");
			
			$(this).addClass("active");
			
			// Date object
			var d = new Date();
			
			var month = d.getMonth() + 1;
			if (month < 10)
			{
				month = "0" + month;
			}
			
			if ($(this).attr("id") == 'dateRangeAll')
			{
				// Clear the date range values
				$("#report_date_from").val("");
				$("#report_date_to").val("");
				
				// Clear the url parameters
				delete urlParameters['from'];
				delete urlParameters['to'];
			}
			else if ($(this).attr("id") == 'dateRangeToday')
			{
				// Set today's date
				currentDate = (d.getDate() < 10)? "0"+d.getDate() : d.getDate();
				var dateString = month + '/' + currentDate + '/' + d.getFullYear();
				$("#report_date_from").val(dateString);
				$("#report_date_to").val(dateString);
			}
			else if ($(this).attr("id") == 'dateRangeWeek')
			{
				// Get first day of the week
				var diff = d.getDate() - d.getDay();
				var d1 = new Date(d.setDate(diff));
				var d2 = new Date(d.setDate(diff + 6));
				
				// Get the first and last days of the week
				firstWeekDay = (d1.getDate() < 10)? ("0" + d1.getDate()) : d1.getDate();
				lastWeekDay = (d2.getDate() < 10)? ("0" + d2.getDate()) : d2.getDate();
				
				$("#report_date_from").val(month + '/' + firstWeekDay + '/' + d1.getFullYear());
				$("#report_date_to").val(month + '/' + lastWeekDay + '/' + d2.getFullYear());
			}
			else if ($(this).attr("id") == 'dateRangeMonth')
			{
				d1 = new Date(d.setDate(32));
				lastMonthDay = 32 - d1.getDay();
				
				$("#report_date_from").val(month + '/01/' + d.getFullYear());
				$("#report_date_to").val(month + '/' + lastMonthDay +'/' + d.getFullYear());
			}
			
			// Update the url parameters
			if ($("#report_date_from").val() != '' && $("#report_date_to").val() != '')
			{
				urlParameters['from'] = $("#report_date_from").val();
				urlParameters['to'] = $("#report_date_to").val();
			}
			
			// Hide the box
			$("#tooltip-box").hide();
			
			return false;
		});
		
		
		/**
		 * When the date filter button is clicked
		 */
		$("#tooltip-box a.filter-button").click(function(){
			// Change the text
			$(".time-period").text($("#report_date_from").val()+" to "+$("#report_date_to").val());
			
			// Hide the box
			$("#tooltip-box").hide();
			
			report_date_from = $("#report_date_from").val();
			report_date_to = $("#report_date_to").val();
			
			if ($(this).attr("id") == "applyDateFilter" && report_date_from != '' && report_date_to != '')
			{
				// Add the parameters
				urlParameters["from"] = report_date_from;
				urlParameters["to"] = report_date_to;
				
				// Fetch the reports
				fetchReports();
			}
			
			return false;
		});
		
		// Initialize accordion for Report Filters
		$( "#accordion" ).accordion({autoHeight: false});
		
		// Report hovering events
		addReportHoverEvents();
		
		// 	Events for toggling the report filters
		addToggleReportsFilterEvents();
		
		// Attach paging events to the paginator
		attachPagingEvents();
		
		// Attach the "Filter Reports" action
		attachFilterReportsAction();
		
		// When all the filters are reset
		$("#reset_all_filters").click(function(){
			// Deselect all filters
			$.each($(".filter-list li a"), function(i, item){
				$(item).removeClass("selected");
			});
			
			// Reset the url parameters
			urlParameters = {};
		
			// Fetch all reports
			fetchReports();
			return false;
		});
		
		$("#accordion").accordion({change: function(event, ui){
			if ($(ui.newContent).hasClass("f-location-box"))
			{
				if (typeof radiusMap == 'undefined' || radiusMap == null)
				{
					// Create the map
					radiusMap = createMap("divMap", latitude2, longitude2, defaultZoom2);
					
					// Add the radius layer
					addRadiusLayer(radiusMap, latitude2, longitude2);
					
					drawCircle(radiusMap, latitude2, longitude2);
					
					// Detect map clicks
					radiusMap.events.register("click", radiusMap, function(e){
						var lonlat = radiusMap.getLonLatFromViewPortPx(e.xy);
						var lonlat2 = radiusMap.getLonLatFromViewPortPx(e.xy);
					    m = new OpenLayers.Marker(lonlat);
						markers.clearMarkers();
						markers.addMarker(m);

						currRadius = $("#alert_radius option:selected").val();
						radius = currRadius * 1000

						lonlat2.transform(proj_900913, proj_4326);

						// Store the current latitude2 and longitude2
						currLat = lonlat2.lat;
						currLon = lonlat2.lon;

						drawCircle(radiusMap, currLat, currLon, radius);

						// Store the radius and start locations
						urlParameters["radius"] = currRadius;
						urlParameters["start_loc"] = currLat + "," + currLon;
					});

					// Radius selector
					$("select#alert_radius").change(function(e, ui) {
						var newRadius = $("#alert_radius").val();

						// Convert to Meters
						radius = newRadius * 1000;	

						// Redraw Circle
						currLat = (currLat == null)? latitude2 : currLat;
						currLon = (currLon == null)? longitude2 : currLon;

						drawCircle(radiusMap, currLat, currLon, radius);

						// Store the radius and start locations
						urlParameters["radius"] = newRadius;
						urlParameters["start_loc"] = currLat+ "," + currLon;
					});
				}
			}
		}});


	});
	
	/**
	 * Registers the report hover event
	 */
	function addReportHoverEvents()
	{
		 // Hover functionality for each report
		$(".rb_report").hover(
			function () {
				$(this).addClass("hover");
			}, 
			function () {
				$(this).removeClass("hover");
			}
		);
		
		// Category tooltip functionality
		var $tt = $('.r_cat_tooltip');
		$("a.r_category").hover(
			function () {
				// Place the category text inside the category tooltip
				$tt.find('a').html($(this).find('.r_cat-desc').html());
				
				// Display the category tooltip
				$tt.css({
					'left': ($(this).offset().left - 6),
					'top': ($(this).offset().top - 27)
				}).show();
			}, 
			
			function () {
				$tt.hide();
			}
		);

		// Show/hide categories and location for a report
		$("a.btn-show").click(function(){
			var $reportBox = $(this).attr("href");
		
			// Hide self
			$(this).hide();
			if ($(this).hasClass("btn-more"))
			{
				// Show categories and location
				$($reportBox + " .r_categories, " + $reportBox + " .r_location").slideDown();
			
				// Show the "show less" link
				$($reportBox + " a.btn-less").show();
			}
			else if ($(this).hasClass("btn-less"))
			{
				// Hide categories and location
				$($reportBox + " .r_categories, " + $reportBox + " .r_location").slideUp();
			
				// Show the "show more" link
				$($reportBox + " a.btn-more").attr("style","");
			};
		
			return false;		    
		});
	}
	
	/**
	 * Creates the map and sets the loaded status to 1
	 */
	function createIncidentMap()
	{
		// Creates the map
		map2 = createMap('rb_map-view', latitude2, longitude2, defaultZoom2);
		map2.addControl( new OpenLayers.Control.LoadingPanel({minSize: new OpenLayers.Size(573, 366)}) );
		
		mapLoaded = 1;
	}
	
	function addToggleReportsFilterEvents()
	{
		// Checks if a filter exists in the list of deselected items
		filterExists = function(itemId) {
			if (deSelectedFilters.length == 0)
			{
				return false;
			}
			else
			{
				for (var i=0; i < deSelectedFilters.length; i++)
				{
					if (deSelectedFilters[i] == itemId)
					{
						return true;
					}
				}
				return false;
			}
		};
		
		// toggle highlighting on the filter lists
		$(".filter-list li a").toggle(
			function(){
				$(this).addClass("selected");
				
				// Check if the element is in the list of de-selected items and remove it
				if (deSelectedFilters.length > 0)
				{
					var temp = [];
					for (var i = 0; i<deSelectedFilters.length; i++)
					{
						if (deSelectedFilters[i] != $(this).attr("id"))
						{
							temp.push(deSelectedFilters[i]);
						}
					}
					
					deSelectedFilters = temp;
				}
			},
			function(){
				if ($(this).hasClass("selected"))
				{
					elementId = $(this).attr("id");
					// Add the id of the deselected filter
					if ( ! filterExists(elementId))
					{
						deSelectedFilters.push(elementId);
					}
					
					// Update the parameter value for the deselected filter
					removeDeselectedReportFilter(elementId);
					
				}
				
				$(this).removeClass("selected");
			}
		);
	}
	
	/**
	 * Switch Views map, or list
	 */
	 function switchViews(view)
	 {
		 // Hide both divs
		$("#rb_list-view, #rb_map-view").hide();
		
		// Show the appropriate div
		$($(view).attr("href")).show();
		
		// Remove the class "selected" from all parent li's
		$("#reportslist-box .report-list-toggle a").parent().removeClass("active");
		
		// Add class "selected" to both instances of the clicked link toggle
		$("."+$(view).attr("class")).parent().addClass("active");
		
		// Check if the map view is active
		if ($("#rb_map-view").css("display") == "block")
		{
			// Check if the map has already been created
			if (mapLoaded == 0)
			{
				createIncidentMap();
			}
			
			// Set the current page
			urlParameters["page"] = $(".pager li a.active").html();
			
			// Load the map
			setTimeout(function(){ showIncidentMap() }, 400);
		}
		return false;
	 }
	
	
	
	
	/**
	 * List/map view toggle
	 */
	function addReportViewOptionsEvents()
	{
		$("#reportslist-box .report-list-toggle a").click(function(){
			return switchViews($(this));						
		});
	}
	
	/**
	 * Attaches paging events to the paginator
	 */	
	function attachPagingEvents()
	{
		// Add event handler that allows switching between list view and map view
		addReportViewOptionsEvents();
		
		// Remove page links for the metadata pager
		$("ul.pager a").attr("href", "#");
		
		$("ul.pager a").click(function() {
			// Add the clicked page to the url parameters
			urlParameters["page"] = $(this).html();
			
			// Fetch the reports
			fetchReports();
			return false;
			
		});
		
		$("td.last li a").click(function(){
			pageNumber = $(this).attr("id").substr("page_".length);
			if (Number(pageNumber) > 0)
			{
				urlParameters["page"] = Number(pageNumber);
				fetchReports();
			}
			return false;
		});
		
		return false;
	}
	
	/**
	 * Gets the reports using the specified parameters
	 */
	function fetchReports()
	{
		//check and see what view was last viewed: list, or map.
		var lastDisplyedWasMap = $("#rb_map-view").css("display") != "none";
		
		// Reset the map loading tracker
		mapLoaded = 0;
		
		var loadingURL = "<?php echo url::file_loc('img').'media/img/loading_g.gif'; ?>"
		var statusHtml = "<div style=\"width: 100%; margin-top: 100px;\" align=\"center\">" + 
					"<div><img src=\""+loadingURL+"\" border=\"0\"></div>" + 
					"<p style=\"padding: 10px 2px;\"><h3><?php echo Kohana::lang('ui_main.loading_reports'); ?>...</h3></p>"
					"</div>";
	
		$("#reportslist-box").html(statusHtml);
		
		// Check if there are any parameters
		if ($.isEmptyObject(urlParameters))
		{
			urlParameters = {show: "all"}
		}
		
		// Get the content for the new page
		$.get('<?php echo url::site().'reports/fetch_reports'?>',
			urlParameters,
			function(data) {
				if (data != null && data != "" && data.length > 0) {
				
					// Animation delay
					setTimeout(function(){
						$("#reportslist-box").html(data);
				
						attachPagingEvents();
						addReportHoverEvents();
						deSelectedFilters = [];
						
						//if the map was the last thing the user was looking at:
						if(lastDisplyedWasMap)
						{
							switchViews($("#reportslist-box .report-list-toggle a.map"));
							//$('ul.report-list-toggle li a.map').trigger('click');
						}
						
					}, 400);
				}
			}
		);
	}
	
	/** 
	 * Removes the deselected report filters from the list
	 * of filters for fetching the reports
	 */
	function removeDeselectedReportFilter(elementId)
	{
		// Removes a parameter item from urlParameters
		removeParameterItem = function(key, val) {
			if (! $.isEmptyObject(urlParameters))
			{
				// Get the object type
				objectType = Object.prototype.toString.call(urlParameters[key]);
				
				if (objectType == "[object Array]")
				{
					currentItems  = urlParameters[key];
					newItems = [];
					for (var j=0; j < currentItems.length; j++)
					{
						if (currentItems[j] != val)
						{
							newItems.push(currentItems[j]);
						}
					}
					
					if (newItems.length > 0)
					{
						urlParameters[key] = newItems;
					}
					else
					{
						delete urlParameters[key];
					}
				}
				else if (objectType == "[object String]")
				{
					delete urlParameters[key];
				}
			}
		}
		
		if (deSelectedFilters.length > 0)
		{
			// Check for category filter
			if (elementId.indexOf('filter_link_cat_') != -1){
				catId = elementId.substring('filter_link_cat_'.length);
				removeParameterItem("c", catId);
			}
			else if (elementId.indexOf('filter_link_mode_') != -1)
			{
				modeId = elementId.substring('filter_link_mode_'.length);
				removeParameterItem("mode", modeId);
			}
			else if (elementId.indexOf('filter_link_media_') != -1)
			{
				mediaType = elementId.substring('filter_link_media_'.length);
				removeParameterItem("m", mediaType);
			}
			else if (elementId.indexOf('filter_link_verification_') != -1)
			{
				verification = elementId.substring('filter_link_verification_'.length);
				removeParameterItem("v", verification);
				
			}
		}
	}
	
	/**
	 * Adds an event handler for the "Filter reports" button
	 */
	function attachFilterReportsAction()
	{
		$("#applyFilters").click(function(){
			
			// 
			// Get all the selected categories
			// 
			var category_ids = [];
			$.each($(".fl-categories li a.selected"), function(i, item){
				itemId = item.id.substring("filter_link_cat_".length);
				// Check if category 0, "All categories" has been selected
				category_ids.push(itemId);
			});
			
			if (category_ids.length > 0)
			{
				urlParameters["c"] = category_ids;
			}
			
			// 
			// Get the incident modes
			// 
			var incidentModes = [];
			$.each($(".fl-incident-mode li a.selected"), function(i, item){
				modeId = item.id.substring("filter_link_mode_".length);
				incidentModes.push(modeId);
			});
			
			if (incidentModes.length > 0)
			{
				urlParameters["mode"] = incidentModes;
			}
			
			// 
			// Get the media type
			// 
			var mediaTypes = [];
			$.each($(".fl-media li a.selected"), function(i, item){
				mediaId = item.id.substring("filter_link_media_".length);
				mediaTypes.push(mediaId);
			});
			
			if (mediaTypes.length > 0)
			{
				urlParameters["m"] = mediaTypes;
			}
			
			// Get the verification status
			var verificationStatus = [];
			$.each($(".fl-verification li a.selected"), function(i, item){
				statusVal = item.id.substring("filter_link_verification_".length);
				verificationStatus.push(statusVal);
			});
			if (verificationStatus.length > 0)
			{
				urlParameters["v"] = verificationStatus;
			}
			
			// Fetch the reports
			fetchReports();
			return false;
		});
	}
	
	/**
	 * Handles display of the incidents current incidents on the map
	 * This method is only called when the map view is selected
	 */
	function showIncidentMap()
	{
		// URL to be used for fetching the incidents
		fetchURL = '<?php echo url::site().'json/index' ;?>';
		
		// Generate the url parameter string
		parameterStr = "";
		$.each(urlParameters, function(key, value){
			if (parameterStr == "")
			{
				parameterStr += key + "=" + value.toString();
			}
			else
			{
				parameterStr += "&" + key + "=" + value.toString();
			}
		});
		
		// Add the parameters to the fetch URL
		fetchURL += '?' + parameterStr;
		
		// Fetch the incidents
		
		// Set the layer name
		var layerName = '<?php echo Kohana::lang('ui_main.reports')?>';
				
		// Get all current layers with the same name and remove them from the map
		currentLayers = map2.getLayersByName(layerName);
		for (var i = 0; i < currentLayers.length; i++)
		{
			map2.removeLayer(currentLayers[i]);
		}
				
		// Styling for the incidents
		reportStyle = new OpenLayers.Style({
			pointRadius: "8",
			fillColor: "#30E900",
			fillOpacity: "0.8",
			strokeColor: "#197700",
			strokeWidth: 3,
			graphicZIndex: 1
		});
				
		// Apply transform to each feature before adding it to the layer
		preFeatureInsert = function(feature)
		{
			var point = new OpenLayers.Geometry.Point(feature.geometry.x, feature.geometry.y);
			OpenLayers.Projection.transform(point, proj_4326, proj_900913);
		};
				
		// Create vector layer
		vLayer = new OpenLayers.Layer.Vector(layerName, {
			projection: map2.displayProjection,
			extractAttributes: true,
			styleMap: new OpenLayers.StyleMap({'default' : reportStyle}),
			strategies: [new OpenLayers.Strategy.Fixed()],
			protocol: new OpenLayers.Protocol.HTTP({
				url: fetchURL,
				format: new OpenLayers.Format.GeoJSON()
			})
		});
				
		// Add the vector layer to the map
		map2.addLayer(vLayer);
		
		// Add feature selection events
		addFeatureSelectionEvents(map2, vLayer);
	}
	
	/**
	 * Clears the filter for a particular section
	 * @param {string} parameterKey: Key of the parameter remove from the list of url parameters
	 * @param {string} filterClass: CSS class of the section containing the filters
	 */
	function removeParameterKey(parameterKey, filterClass)
	{
		if (typeof parameterKey == 'undefined' || typeof parameterKey != 'string')
			return;
		
		if (typeof $("."+filterClass) == 'undefined')
			return;
		
		// Deselect
		$.each($("." + filterClass +" li a.selected"), function(i, item){
			$(item).removeClass("selected");
		});
		
		// Remove the parameter key from urlParameters
		delete urlParameters[parameterKey];
	}
</script>

	
	<?php } ?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
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
			<a href="<?php echo url::base();?>">
				<img src="<?php echo url::base();?>themes/activarian_minimal/images/logo_ipad.jpg"/>
			</a>			
		</div>
		<!-- / header -->

		<!-- main body -->
		<div id="middle">
			<div class="background layoutleft">

							<!-- mainmenu -->
				<div id="mainmenu" class="clearingfix">
					<ul>
						<?php nav::main_tabs($this_page, array('reports'=>'reports')); ?>
					</ul>

				</div>
				<!-- / mainmenu -->
