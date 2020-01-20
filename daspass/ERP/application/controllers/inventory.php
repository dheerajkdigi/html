<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends MY_Controller {
    public function index()
    {
        //$this->output->enable_profiler(TRUE);
        //isAuthorized();
        $data['categories'] = $this->inventoryModel->categories();
        $data['content'] = 'inventory/inventory_cats';
        $this->load->view('layout',$data);
    }

    public function catList(){
        $data['categories'] = $this->inventoryModel->categories();
        $data['content'] = 'inventory/cat_list';
        $this->load->view('layout',$data);
    }
    public function catAdd(){
        $data['form_action']    = base_url().'inventory/catSave';
        $data['content']        = 'inventory/cat_add';
        $this->load->view('layout',$data);
    }
    public function catEdit($categoryId){
        //isAuthorized();
        $data['form_action']    = base_url('inventory/catUpdate/'.$categoryId);
        $data['category']       = $this->inventoryModel->categoryDetail($categoryId);
        //debug($data);die;
        $data['content']        = 'inventory/cat_add';
        $this->load->view('layout',$data);
    }
    public function catSave(){
        //isAuthorized();
        $categoryData['NAME'] = $this->input->post('NAME',TRUE);
        $categoryData['UNIT'] = $this->input->post('UNIT',TRUE);
        $categoryId = $this->inventoryModel->catInsert($categoryData);
        if($categoryId) {
            $this->session->set_flashdata('msg', 'Category Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('inventory/catList'), 'refresh');
        exit;
    }

    public function catUpdate($categoryId){
        //isAuthorized();
        $categoryData['NAME'] = $this->input->post('NAME',TRUE);
        $categoryData['UNIT'] = $this->input->post('UNIT',TRUE);
        $this->inventoryModel->catUpdate($categoryId,$categoryData);
        $this->session->set_flashdata('msg', 'Category Updated Successfully');
        redirect(base_url('inventory/catList'), 'refresh');
        exit;
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->inventoryModel->categoryDetail($categoryId);
        $data['inventories'] = $this->inventoryModel->inventories($categoryId);
        //debug($data);die;
        $data['content'] = 'inventory/list';
        $this->load->view('layout',$data);
    }

    public function detail($inventory_id){
        $data['inventory'] = $this->inventoryModel->inventoryDetail($inventory_id);
        $data['content'] = 'inventory/detail';
        $this->load->view('layout',$data);
    }
    public function add(){
        //isAuthorized();
        //$data['languages']      = $this->inventoryModel->languages(1);
        $data['categories']     = $this->inventoryModel->categories();
        $data['form_action']    = base_url().'inventory/save';
        $data['content']        = 'inventory/add';
        $this->load->view('layout',$data);
    }
    public function edit($inventoryId){
        //isAuthorized();
        $data['form_action']    = base_url().'inventory/update/'.$inventoryId;
        $data['categories']     = $this->inventoryModel->categories();
        $data['inventory']           = $this->inventoryModel->inventoryDetail($inventoryId);
        $data['content']        = 'inventory/add';
        //debug($data);
        $this->load->view('layout',$data);
    }
    
    public function save(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);debug($_FILES);die;
        $inventoryData['NAME']            = $postData['NAME'];
        $inventoryData['CATEGORY_ID']     = (int)$postData['CATEGORY_ID'];
        $inventoryData['QUANTITY']        = (int)$postData['QUANTITY'];
        $inventoryData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        
        $inventory_id = $this->inventoryModel->insert($inventoryData);
        if($inventory_id) {
            $this->session->set_flashdata('msg', 'inventory Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('inventory'), 'refresh');
        exit;
    }
    public function update($inventoryId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        $inventoryData['NAME']            = $postData['NAME'];
        $inventoryData['CATEGORY_ID']     = $postData['CATEGORY_ID'];
        $inventoryData['QUANTITY']        = (int)$postData['QUANTITY'];
        $inventoryData['MIN_QUANTITY']    = (int)$postData['MIN_QUANTITY'];
        $this->inventoryModel->update($inventoryId,$inventoryData);
        $this->session->set_flashdata('msg', 'Inventory Updated Successfully');
        redirect(base_url('inventory'), 'refresh');
        exit;
    }
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->inventoryModel->update($ADD_PACK_ID,$postData);
    }
}

/* End of file inventory.php */
/* Location: ./application/controllers/inventory.php */