<?php defined('SYSPATH') or die('No direct script access.');
/**
 * CatOrgs Hook
 *
 
 * @author	   John Etherton <john@ethertontech.com> 
 * @package	   Cat Orgs
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class catorgs {
	
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
		if(Router::$controller == "reports")
		{
			plugin::add_javascript("catorgs/js/catorgs.js");
			
			Event::add('ushahidi_action.report_form', array($this, '_add_cats_frontent'));	 //adds the big map  tab
			Event::add('ushahidi_action.report_form_admin', array($this, '_add_cats_frontent'));	 //adds the big map  tab
		}
	}//end add()
	
	//renders the front end
	public function _add_cats_frontent()
	{
		//get the orgs
		$orgs = ORM::factory('category')
			->where('parent_id', '12')
			->find_all();
		$orgs_array = array();
		$first_org = null;
		$select = null;
		foreach($orgs as $org)
		{
			if($first_org == null)
			{
				$first_org = $org->id;
			}
			$orgs_array[$org->id] = $org->category_title;
		}
		
		//if there's an id
		$id = Event::$data;
		if($id AND intval($id) != 0)
		{
			//check if there's a link between one of the org cats and this incident
			foreach($orgs as $org)
			{
				$link = ORM::factory('incident_category')
					->where('incident_id', $id)
					->where('category_id', $org->id)
					->find();
				if($link->loaded)
				{
					$first_org = $org->id;
					$select = $org->id;
				}
			}
		}
		
		echo '<div class="report_row">';
		echo '<h4>Organization</h4>';
		echo  form::dropdown('orgs',$orgs_array, $select, 'id="orgs" onchange="orgclick(); return false;"');
		echo  form::checkbox('incident_category[]', $first_org, true, 'id="orgscheck" style="display:none;"');
		echo '</div>';
	}
}

new catorgs;