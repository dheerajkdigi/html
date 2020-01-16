<?php
class UserModel extends CI_Model {

    function emailExist($email){
        $query = $this->db->get_where('user',array('email'=>$email));
        return $query->num_rows();
    }
    function auth($data){
        $query = $this->db->get_where('user',array('email'=>$data['email'],'password'=>md5($data['password'])));
        return $query->row();
    }
    function hauthLogin($data){
        $query = $this->db->get_where('user',array('email'=>$data['email']));
        if($query->num_rows())
            return $query->row();
        else{
            $data['created_date'] = date('Y-m-d H:i:s');
            $user_id = $this->db->insert('user', $data);
            $query = $this->db->get_where('user',array('id' =>$user_id));
            return $query->row();
        }
    }
    function users(){
        $query = $this->db->get('user');
        return $query->result();
    }
    function userDetail($user_id){
        $query = $this->db->get_where('user',array('id' =>$user_id));
        return $query->row();
    }
    function insert($data){
        $data['created_date'] = date('Y-m-d H:i:s');
        
        return $this->db->insert('user', $data);
    }
    function update($user_id,$data){
        return $this->db->update('user', $data, array('id'=> $user_id)); 
    }
    
    function allSites(){
        $query = $this->db->get('site');
        return $query->result();
    }
    
}
?>