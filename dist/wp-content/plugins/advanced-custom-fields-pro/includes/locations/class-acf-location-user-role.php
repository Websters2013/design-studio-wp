<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('acf_location_user_role') ) :

class acf_location_user_role extends acf_location {
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->name = 'user_role';
		$this->label = __("User Role",'acf');
		$this->category = 'user';
		
		
		// construct
    	parent::__construct();
    	
	}
	
	
	/*
	*  rule_match
	*
	*  This function is used to match this location $rule to the current $screen
	*
	*  @type	function
	*  @date	3/01/13
	*  @since	3.5.7
	*
	*  @param	$match (boolean) 
	*  @param	$rule (array)
	*  @return	$options (array)
	*/
	
	function rule_match( $result, $rule, $screen ) {
		
		// vars
		$user_id = acf_maybe_get( $screen, 'user_id' );
		$user_role = acf_maybe_get( $screen, 'user_role' );
		
		
		// not a user
		if( !$user_id ) return false;
		
		
		// new user
		if( $user_id == 'new' ) {
			
			$result = ( $rule['value'] == get_option('default_role') );
			
		} else {
			
			$result = ( user_can($user_id, $rule['value']) );
			
		}
		
		
		// reverse if 'not equal to'
        if( $rule['operator'] === '!=' ) {
	        	
        	$result = !$result;
        
        }
		
		
		// match
		return $result;
		
	}
	
	
	/*
	*  rule_operators
	*
	*  This function returns the available values for this rule type
	*
	*  @type	function
	*  @date	30/5/17
	*  @since	5.6.0
	*
	*  @param	n/a
	*  @return	(array)
	*/
	
	function rule_values( $choices, $rule ) {
		
		// global
		global $wp_roles;
		
		
		// vars
		$choices = array( 'all' => __('All', 'acf') );
		$choices = array_merge( $choices, $wp_roles->get_names() );
		
		
		// return
		return $choices;
		
	}
	
}

// initialize
acf_register_location_rule( 'acf_location_user_role' );

endif; // class_exists check

?>