<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('categoryModel');
    }
    public function index()
    {
        $data['categories'] = $this->categoryModel->categories();
        $data['content'] = 'category/list';
        $this->load->view('layout',$data);
    }
    public function list($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['categorys'] = $this->categoryModel->categorys($categoryId);
        $data['content'] = 'category/list';
        $this->load->view('layout',$data);
    }
    public function detail($category_id){
        $data['category'] = $this->categoryModel->categoryDetail($category_id);
        $data['content'] = 'category/detail';
        $this->load->view('layout',$data);
    }
    public function add(){
        //isAuthorized();
        $data['form_action']    = base_url('category/save');
        $data['content']        = 'category/add';
        $this->load->view('layout',$data);
    }
    public function edit($categoryId){
        //isAuthorized();
        $data['form_action']    = base_url('category/update/'.$categoryId);
        $data['category']       = $this->categoryModel->categoryDetail($categoryId);
        //debug($data);die;
        $data['content']        = 'category/add';
        $this->load->view('layout',$data);
    }
    
    public function save(){
        //isAuthorized();
        $categoryData['NAME'] = $this->input->post('NAME',TRUE);
        $categoryId = $this->categoryModel->insert($categoryData);
        if($categoryId) {
            $this->session->set_flashdata('msg', 'Category Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('category'), 'refresh');
        exit;
    }
    public function update($categoryId){
        //isAuthorized();
        $categoryData['NAME'] = $this->input->post('NAME',TRUE);
        $this->categoryModel->update($categoryId,$categoryData);
        $this->session->set_flashdata('msg', 'Category Updated Successfully');
        redirect(base_url('category'), 'refresh');
        exit;
    }
   
    
   
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->categoryModel->update($ADD_PACK_ID,$postData);
    }
    
    public function setPositioning() {
        $positions = $this->input->post('position',TRUE);
        foreach($positions as $key => $categoryId){
            $updateArray[] = array(
                'ID'        => $categoryId,
                'position'  => $key+1
            );
        }
        //debug($updateArray);die;
        $this->categoryModel->setPositioning($updateArray);
        $this->session->set_flashdata('msg', 'Category Rearranged Successfully');
        redirect(base_url('category'), 'refresh');
        exit;
    }
    
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */