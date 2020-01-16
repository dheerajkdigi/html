<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler($this->config->item('debug'));
        $this->isLocal = 1;
        
        if(($this->router->fetch_class()=='user' && $this->router->fetch_method()=='login') || ($this->router->fetch_class()=='hauth'))
        {}
        else
            if(!$this->auth())
                redirect (base_url('user/login'),'redirect');
                
    }
    public function auth(){
        $user = $this->session->userdata('user');
        if(isset($user->id) and $user->id>0)
            return true;
        else
            return false;
    }
}
