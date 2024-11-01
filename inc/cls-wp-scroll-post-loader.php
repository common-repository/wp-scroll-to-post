<?php
/**
 * General action, hooks loader
*/
class WSP_Loader {

	protected $wsp_actions;
	protected $wsp_filters;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->wsp_actions = array();
		$this->wsp_filters = array();
	}

	function add_action( $hook, $component, $callback ){
		$this->wsp_actions = $this->add( $this->wsp_actions, $hook, $component, $callback );
	}

	function add_filter( $hook, $component, $callback ){
		$this->wsp_filters = $this->add( $this->wsp_filters, $hook, $component, $callback );
	}

	private function add( $hooks, $hook, $component, $callback ){
		$hooks[] = array( 'hook' => $hook, 'component' => $component, 'callback' => $callback );
		return $hooks;
	}

	public function wsp_run(){
		foreach( $this->wsp_filters as $hook ){
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach( $this->wsp_actions as $hook ){
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
?>