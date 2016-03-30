<?php
class general extends CI_Controller {

	
	function __construct() {

		parent::__construct();

        // Enable profiling: Turn this off on deploy
        //$this->output->enable_profiler(TRUE);

	}
	
	function index() {
        $data['schools'] = $this->map->all_schools();

        
		$this->load->view('map', $data);

	}
	function trainers($miles = 10,$trainer = null) {
        $data['miles'] = $miles;
        
        $data['fwni_schools'] = $this->map->fwni_schools();
        
        $data['trainers'] = $this->map->trainers($miles,$trainer);

        
		$this->load->view('trainer', $data);

	}
	function trainers_each($miles = 10,$trainer = null) {
        $data['miles'] = $miles;
        
        $data['fwni_schools'] = $this->map->fwni_schools();
        
        $data['trainers'] = $this->map->trainers($miles,$trainer);

        
		$this->load->view('trainer_each', $data);

	}
	function find_groups($miles = 10,$trainer_id) {

        $data['groups'] = $this->map->groupings($miles,$trainer_id);
        
        
		$this->load->view('grouping', $data);

	}
	function find_groups_all($miles = 10) {

        $data['groups'] = $this->map->grouping_all($miles);
        
        
		$this->load->view('grouping_all', $data);

	}
}