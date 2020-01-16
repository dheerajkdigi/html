<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	public function index()
	{
        //isAuthorized();
        //$this->load->model('userModel');
        $user = $this->session->userdata('user');
        $data['users'] = $this->userModel->users();
        //debug($users);die;
        $data['content'] = 'user/list';
        $this->load->view('layout',$data);
	}
    public function login()
    {
        
        $user = $this->session->userdata('user');
        //debug($user);die;
        if(isset($user->id) and $user->id>0){
            redirect(base_url('user','redirect'));
            exit;
        }
        if($_POST){
            $postData = $this->input->post(null,TRUE);
            $user = $this->userModel->auth($postData);
            //debug($user);
            if($user){
                /*
                $user->authMenus = $this->menuModel->authMenus($user);
                $authFor = $this->menuModel->authFor($user);
                //debug($authFor);die;
                foreach($authFor as $auth){
                    if($auth->controller && $auth->actions){
                        if(!isset($user->authFor[$auth->controller]))
                            $user->authFor[$auth->controller] = array();
                        foreach(explode(',', $auth->actions) as $action){
                            if(!in_array($action,$user->authFor[$auth->controller]))
                                $user->authFor[$auth->controller][] = $action;
                        }
                        //debug($auth->actions);
                        //array_push($user->authFor[$auth->controller], explode(',', $auth->actions));
                        //$user->authFor[$auth->controller] = explode(',', $auth->actions);
                    }
                }
                 * 
                 */
                //debug($user);die;
                $this->session->set_userdata('user',$user);
                redirect(base_url(), 'refresh');
            }
            else{
                $data['email'] = $postData['email'];
                $this->load->view('user/login',$data);
            }
        }
        else
            $this->load->view('user/login');
    }
    public function logout()
    {
        /*
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        /*
        if(session_id() == '') {
            session_start();
        }
         * 
         */
        $this->session->sess_destroy();
        session_unset();
        session_destroy();
        redirect(base_url('user/login','refresh'));
    }
    public function emailExist()
    {
        $email = $this->input->post('email');
        $result = $this->userModel->emailExist($email);
        echo $result;
    }
    public function detail($user_id){
        $userDetail = $this->userModel->userDetail($user_id);
        $data['detail'] = array(
                            'First Name'    => $userDetail->first_name,
                            'Middle Name'   => $userDetail->middle_name,
                            'Last Name'     => $userDetail->last_name,
                            'Email'         => $userDetail->email,
                            'Mobile'        => $userDetail->mobile,
                            'Gender'        => $userDetail->gender,
                            //'Date of Birth' => $userDetail->dob,
                            'Acc Allowed'   => $userDetail->acc_allowed,
                            'Status'        => ($userDetail->IS_ACTIVE) ? 'Active' : 'Inactive',
                        );
        echo json_encode($data);
    }
    public function add(){
        //isAuthorized();
        $this->load->model('roleModel');
        $data['sub_menus'] = $this->getAllSubMenus();
        $data['sites'] = $this->userModel->allSites();
        $data['roles'] = dbResultToArrayById($this->roleModel->roles());
        $data['page_heading'] = 'Add User';
        $data['form_action'] = base_url().'user/save';
        $data['content'] = 'user/add';
        $this->load->view('layout',$data);
    }
    public function edit($user_id){
        //isAuthorized();
        $this->load->model('roleModel');
        $data['sub_menus'] = $this->getAllSubMenus();
        $data['sites'] = $this->userModel->allSites();
        $data['roles'] = dbResultToArrayById($this->roleModel->roles());
        $data['page_heading'] = 'Edit User';
        $data['form_action'] = base_url().'user/update/'.$user_id;
        $data['user'] = $this->userModel->userDetail($user_id);
        $data['user']->permissions = explode(',',$data['user']->permissions);
        //debug($data['user']);
        $data['content'] = 'user/add';
        $this->load->view('layout',$data);
    }
    public function save(){
        //isAuthorized();
        //$this->load->library('form_validation');
        $postData = $this->input->post(null,TRUE);
        //$permissions = $postData['permissions'];
        $postData['password'] = md5($postData['password']);
        if(isset($postData['permissions']))
            $postData['permissions'] = implode(",", $postData['permissions']);
        //debug($postData);die;
        //$this->load->helper('common');
        $user_id = $this->userModel->insert($postData);
        //echo $user_id;echo "<hr/>"; die;
        $this->session->set_flashdata('msg', 'User Added Successfully');
        redirect(base_url('user'), 'refresh');
        exit;
        //debug($postData);die;
    }
    public function update($user_id){
        //isAuthorized();
         //$this->load->library('form_validation');
        $postData = $this->input->post(null,TRUE);
        //debug($postData);die;
        //$permissions = $postData['permissions'];
        unset($postData['email']);
        if(isset($postData['password']) && ($postData['password'] !=''))
            $postData['password'] = md5($postData['password']);
        else
            unset($postData['password']);
        if(isset($postData['permissions']))
            $postData['permissions'] = implode(",", $postData['permissions']);
        //$this->load->helper('common');
        $updated = $this->userModel->update($user_id,$postData);
        //echo $user_id;echo "<hr/>"; die;
        $this->session->set_flashdata('msg', 'User Updated Successfully');
        redirect(base_url('user'), 'refresh');
        exit;
        //debug($postData);die;
    }
    public function getAllSubMenus(){
        $submenus = array();
        foreach($this->menus as $menu){
            $submenus[$menu->id] = $this->menuModel->subMenus($menu->id);
        }
        return $submenus;
    }
    public function changeStatus(){
        //isAuthorized();
        $id = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->userModel->update($id,$postData);
    }
    /*
       function social_login(){
          //$this->load->view('fb'); 
          if($this->input->post('user')){
              $fb_user = $this->input->post('user');
              //debug($fb_user);
              $postData['first_name'] = $fb_user['first_name'];
              $postData['last_name'] = $fb_user['last_name'];
              $postData['email'] = $fb_user['email'];
              $user = $this->userModel->hauth_login($postData);
              $this->session->set_userdata('user',$user);
              echo $user->id;
              //redirect(base_url(), 'refresh');
              //debug($this->input->post('user'));
          }
       } 
       function g_login(){
          // debug($_REQUEST);die;
       }
        function fb_login0()
        {

            $fb_config = array(
                'appId'  => '344766472302947',
                'secret' => 'd0497c9c7cf75c1f10806ee050af3871'
            );

            $this->load->library('facebook', $fb_config);

            $user = $this->facebook->getUser();
            $user = $this->facebook->getSignedRequest();
            debug($_REQUEST);
            debug($user);
            if ($user) {
                debug($user);die;
                try {
                    $data['user_profile'] = $this->facebook
                        ->api('/me');
                } catch (FacebookApiException $e) {
                    $user = null;
                }
            }

            if ($user) {
                $data['logout_url'] = $this->facebook
                    ->getLogoutUrl();
            } else {
                $data['login_url'] = $this->facebook
                    ->getLoginUrl();
            }

            $this->load->view('fb',$data);
        }
    */
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */