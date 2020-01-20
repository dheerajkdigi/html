<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('gameModel');
        $this->load->model('categoryModel');
    }
    public function index()
    {
        //$this->output->enable_profiler(TRUE);
        //isAuthorized();
        $data['categories'] = $this->categoryModel->categories();
        $data['content'] = 'game/category_list';
        $this->load->view('layout',$data);
    }
    public function list($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->categoryModel->categoryDetail($categoryId);
        $data['games'] = $this->gameModel->games($categoryId);
        //debug($data);die;
        $data['content'] = 'game/list';
        $this->load->view('layout',$data);
    }
    public function detail($game_id){
        $data['game'] = $this->gameModel->gameDetail($game_id);
        $data['content'] = 'game/detail';
        $this->load->view('layout',$data);
    }
    public function add(){
        //isAuthorized();
        //$data['languages']      = $this->gameModel->languages(1);
        $data['categories']     = $this->categoryModel->categories();
        $data['form_action']    = base_url().'game/save';
        $data['content']        = 'game/add';
        $this->load->view('layout',$data);
    }
    public function edit($gameId){
        //isAuthorized();
        $data['form_action']    = base_url().'game/update/'.$gameId;
        $data['categories']     = $this->categoryModel->categories();
        $data['game']           = $this->gameModel->gameDetail($gameId);
        $data['content']        = 'game/add';
        //debug($data);
        $this->load->view('layout',$data);
    }
    
    public function save(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);debug($_FILES);die;
        $gameData['NAME']               = $postData['NAME'];
        $gameData['CATEGORY_ID']        = (int)$postData['CATEGORY_ID'];
        
        if($_FILES['game_image']['name']){
            $gameData['IMAGE']       = $this->upload_thumbnail()['uploadLocation'];
        }
        if($_FILES['game_zip']['name']){
            $gameData['GAME_LOCATION']       = $this->upload_game_zip()['uploadLocation'];
        }
        if($gameData['IMAGE'] && $gameData['GAME_LOCATION']){
            $game_id = $this->gameModel->insert($gameData);
            $this->session->set_flashdata('msg', 'Game Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('game'), 'refresh');
        exit;
    }
    public function update($gameId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        
        $gameData['NAME']               = $postData['NAME'];
        $gameData['CATEGORY_ID']        = $postData['CATEGORY_ID'];
        //debug($gameData);die;
        if($_FILES['game_image']['name']){
            $gameData['IMAGE']       = $this->upload_thumbnail()['uploadLocation'];
        }
        if($_FILES['game_zip']['name']){
            $gameData['GAME_LOCATION']       = $this->upload_game_zip()['uploadLocation'];
        }
        //debug($gameData);die;
        $this->gameModel->update($gameId,$gameData);
        $this->session->set_flashdata('msg', 'Game Updated Successfully');
        redirect(base_url('game'), 'refresh');
        exit;
    }
    function do_upload()
    {
        $config['upload_path']  = './uploads/game/';
        $config['allowed_types']= 'gif|jpg|png';
        $config['max_size']	    = '100';
        $config['max_width']    = '100';
        $config['max_height']   = '100';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('game_image')) {
            $error = array('error' => $this->upload->display_errors());
            debug($error);die;
            $this->load->view('upload_form', $error);
        } else {
            $data = $this->upload->data();
            return substr($config['upload_path'],1).$data['file_name'];
            $this->load->view('upload_success', $data);
        }
    }
    private function upload_thumbnail()
    {
        $config['upload_path']  = './games/thumbnails/';
        $config['allowed_types']= 'gif|jpg|png';
        /*
        $config['max_size']     = '100';
        $config['max_width']    = '100';
        $config['max_height']   = '100';
        */

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('game_image')) {
            $error = array('error' => $this->upload->display_errors());
            echo "ImageError:";
            debug($error);die;
            $this->load->view('upload_form', $error);
        } else {
            $data = $this->upload->data();
            //return substr($config['upload_path'],1).$data['file_name'];
            return array("uploadLocation" => substr($config['upload_path'],1).$data['file_name']);
            $this->load->view('upload_success', $data);
        }
    }
    private function upload_game_zip()
    {
        $categoryId = $this->input->post('category_id',TRUE);
        $gameName = $this->input->post('NAME',TRUE);
        $gameLocation = "/games/play/".md5($gameName.date("ymdHis"))."/";
        $config['upload_path']  = './uploads/';
        $config['allowed_types']        = 'zip';
             
        //$this->load->library('upload', $config);
        $this->upload->initialize($config);    
        if ( ! $this->upload->do_upload('game_zip'))
        {
            $params = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $full_path = $data['upload_data']['full_path'];
                 
            $zip = new ZipArchive;
     
            if ($zip->open($full_path) === TRUE)
            {
                if($categoryId == 1){
                    for ($i = 0; $i < $zip->numFiles; $i++)
                    {
                        $filename = $zip->getNameIndex($i);
                        $newname;
                        $arr=explode('.',$full_path );
                        if(substr_count($arr[0],"_")==2) {
                            $underscorearr=explode('_',$arr[0] );
                            $newname=$underscorearr[1].'_'.$underscorearr[2];
                        }
                        else {
                            $newname=$arr[0];
                        }
                        $nameindex=$i+1;
                        echo $newname.='.00'.$nameindex;
                        //$zip->renameName($filename,$newname);
                    }
                }
                return;
                $zip->extractTo(FCPATH.$gameLocation);
                $zip->close();
            }
     
            $params = array('success' => 'Extracted successfully!','zip'=>$zip);
        }
        //$this->_file_mime_type($_FILES['game_zip']); 
        //var_dump($this->file_type);debug($params);exit;
        //return $params;
        return array("uploadLocation" => $gameLocation);
        //$this->load->view('file_upload_result', $params);
    }
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->gameModel->update($ADD_PACK_ID,$postData);
    }
    public function contentDetail($game_id){
        //echo $game_id;die;
        $data['gameDetail']     = $this->gameModel->gameDetail($game_id);
        $data['contentDetail']  = $this->gameModel->contentDetail($game_id);
        echo json_encode($data);
    }
    public function play(){
        //die("Play");
        $this->load->view('games/BaloonParadise/index');
        //$this->load->view('layout',$data);
    }
    public function setPositioning(){
        
        $categoryId = $this->input->post('category_id',TRUE);
        $positions = $this->input->post('position',TRUE);
        foreach($positions as $key => $gameId){
            $updateArray[] = array(
                'ID'=>$gameId,
                'position' => $key+1
            );
        }
        //debug($updateArray);die;
        $this->gameModel->setPositioning($updateArray);
        $this->session->set_flashdata('msg', 'Games Rearranged Successfully');
        redirect(base_url('game/list/'.$categoryId), 'refresh');
        exit;
    }
    
}

/* End of file game.php */
/* Location: ./application/controllers/game.php */