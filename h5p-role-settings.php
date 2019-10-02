<?php
/*
Plugin Name: 	H5P Role Settings
Description: 	Gives editors the right to add new types of LOs in H5P
Version: 		0.1
Author: Alex Furr
License: GPL

*/

if ( ! defined( 'ABSPATH' ) ) { // Prevent direct access
	die();
}

// Check if the H5P plugin is active

$h5pRoles = new h5pRoles();

class h5pRoles
{
	var $version = '0.1';


	//~~~~~
	function __construct ()
	{
		$this->addWPActions();
	}


	function addWPActions ()
	{
		add_action( 'plugins_loaded', array( $this, 'my_plugin_init' ) );
	}


   function my_plugin_init()
   {

      if( class_exists( 'H5P_Plugin' ) )
      {

         //Force use the H5P hub
         $enable_hub = get_option('h5p_hub_is_enabled', TRUE);
         if($enable_hub<>1)
         {
            update_option('h5p_hub_is_enabled', 1);
         }

         // If they can delete others pages but can't manage the H5P libraries then add the cap to all editors
         if(current_user_can('delete_others_pages') && !current_user_can('manage_h5p_libraries'))
         {
            $role = get_role( 'editor' );
            $role->add_cap( 'manage_h5p_libraries' );
         }
      }
   }

}

?>
