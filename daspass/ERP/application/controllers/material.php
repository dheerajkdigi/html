<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('materialModel');
        $this->gstSlabs = array('1.5','2','9','13.5');
    }
    public function index()
    {
        //$this->output->enable_profiler(TRUE);
        //isAuthorized();
        $data['materials'] = $this->materialModel->materials();
        $data['content'] = 'material/list';

        $this->load->view('layout',$data);
    }

    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->materialModel->categoryDetail($categoryId);
        $data['inventories'] = $this->materialModel->inventories($categoryId);
        //debug($data);die;
        $data['content'] = 'material/list';
        $this->load->view('layout',$data);
    }

    public function detail($materialId){
        $data['detail'] = $this->materialModel->materialDetail($materialId);
        echo json_encode($data);
    }
    public function add(){
        //isAuthorized();
        $data['gstSlabs']       = $this->gstSlabs;
        $data['materialGroups'] = $this->materialModel->materialGroups();
        $data['form_action']    = base_url().'material/save';
        $data['content']        = 'material/add';
        $this->load->view('layout',$data);
    }
    public function edit($materialId){
        //isAuthorized();
        $data['gstSlabs']       = $this->gstSlabs;
        $data['materialGroups'] = $this->materialModel->materialGroups();
        $data['form_action']    = base_url().'material/update/'.$materialId;
        //$data['categories']     = $this->materialModel->categories();
        $data['material']           = $this->materialModel->materialDetail($materialId);
        $data['content']        = 'material/add';
        //dd($data);
        $this->load->view('layout',$data);
    }
    
    public function save(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);debug($_FILES);die;
        /*
        $materialData['NAME']            = $postData['NAME'];
        $materialData['CATEGORY_ID']     = (int)$postData['CATEGORY_ID'];
        $materialData['QUANTITY']        = (int)$postData['QUANTITY'];
        $materialData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        */
        $materialData = $postData;
        $materialId = $this->materialModel->insert($materialData);
        if($materialId) {
            $this->session->set_flashdata('msg', 'Material Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('material'), 'refresh');
        exit;
    }
    public function update($materialId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        /*
        $materialData['NAME']            = $postData['NAME'];
        $materialData['CATEGORY_ID']     = $postData['CATEGORY_ID'];
        $materialData['QUANTITY']        = (int)$postData['QUANTITY'];
        $materialData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        */
        $materialData = $postData;
        $this->materialModel->update($materialId,$materialData);
        $this->session->set_flashdata('msg', 'material Updated Successfully');
        redirect(base_url('material'), 'refresh');
        exit;
    }
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->materialModel->update($ADD_PACK_ID,$postData);
    }
    public function sub_group_list($materialGroupId) {
        $ajax                       = $this->input->post("ajax",TRUE);
        $data['materialSubGroups']  = $this->materialModel->materialSubGroups($materialGroupId);
        if($ajax) {
            echo json_encode($data);
        }
        else{
            $data['content']    = 'material/sub_group_list';
            $this->load->view('layout',$data);    
        }
    }
    public function add_group(){
        //isAuthorized();
        //$data['materialGroups'] = $this->materialModel->materialGroups();
        $data['form_action']    = base_url().'material/save_group';
        $data['content']        = 'material/add_group';
        $this->load->view('layout',$data);
    }
    public function save_group(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);debug($_FILES);die;
        /*
        $materialData['NAME']            = $postData['NAME'];
        $materialData['CATEGORY_ID']     = (int)$postData['CATEGORY_ID'];
        $materialData['QUANTITY']        = (int)$postData['QUANTITY'];
        $materialData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        */
        $materialData   = $postData;
        //print_r($materialData);exit;
        $materialId     = $this->materialModel->insertGroup($materialData);
        if($materialId) {
            $this->session->set_flashdata('msg', 'Material Group Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('material'), 'refresh');
        exit;
    }
    public function add_sub_group(){
        //isAuthorized();
        $data['materialGroups'] = $this->materialModel->materialGroups();
        $data['form_action']    = base_url().'material/save_sub_group';
        $data['content']        = 'material/add_sub_group';
        $this->load->view('layout',$data);
    }
    public function save_sub_group(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);debug($_FILES);die;
        /*
        $materialData['NAME']            = $postData['NAME'];
        $materialData['CATEGORY_ID']     = (int)$postData['CATEGORY_ID'];
        $materialData['QUANTITY']        = (int)$postData['QUANTITY'];
        $materialData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        */
        $materialData   = $postData;
        //print_r($materialData);exit;
        $materialId     = $this->materialModel->insertSubGroup($materialData);
        if($materialId) {
            $this->session->set_flashdata('msg', 'Material Sub Group Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('material'), 'refresh');
        exit;
    }
}

/* End of file material.php */
/* Location: ./application/controllers/material.php */