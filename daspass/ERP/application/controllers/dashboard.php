<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function index()
    {
        $data['content'] = 'dashboard';
        $this->load->view('layout',$data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */