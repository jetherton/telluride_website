<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Cloudmade Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class cloudmade {
	
	private $layers;
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{		
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		// Add JS for Map Settings Page
		$api_url_all = Kohana::config('settings.api_url_all');
		$api_url_all .= html::script(url::base().'plugins/cloudmade/views/js/cloudmade.js');
		Kohana::config_set('settings.api_url_all', $api_url_all);
		
		// Add a Sub-Nav Link
		Event::add('ushahidi_filter.map_base_layers', array($this, '_add_layer'));
		
		// Reconfigure the default map api
		if (Kohana::config('settings.default_map') == "cloudmade")
		{
			Kohana::config_set('settings.api_url', "<script type=\"text/javascript\" src=\"".url::base()."plugins/cloudmade/views/js/cloudmade.js\"></script>" );
		}
	}
	
	public function _add_layer()
	{
		$this->layers = Event::$data;
		$this->layers = $this->_create_layer();
		
		// Return layers object with new Cloudmade Layer
		Event::$data = $this->layers;
	}
	
	public function _create_layer()
	{
		// Cloudmade Map Object
		$layer = new stdClass();
		$layer->active = TRUE;
		$layer->name = 'cloudmade';
		$layer->openlayers = 'CloudMade';
		$layer->title = 'CloudMade';
		$layer->description = 'Cloudmade styled tiles';
		$layer->api_url = url::base()."plugins/cloudmade/views/js/cloudmade.js";
		$layer->data = array(
			'key' => Kohana::config('cloudmade.api_key'),
			'styleId' => Kohana::config('cloudmade.styleid')
		);
		$this->layers[$layer->name] = $layer;
		
		return $this->layers;
	}
}

new cloudmade;