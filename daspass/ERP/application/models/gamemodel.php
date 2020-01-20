<?php
class GameModel extends CI_Model {

    function games($categoryId){

        $limit = 100;
        $offset = 0 ;
        $query = $this->db->order_by('POSITION', 'ASC')->get_where('game', array('category_id' => $categoryId), $limit, $offset);
         //order by ADD_PACK_ID desc
        //$query = $this->db->query($qry);
        return $result = $query->result();
        //debug($result);die;
    }

    function gameDetail($gameId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('game', array('id' => $gameId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('game', $data);
        return $this->db->insert_id();
    }

    function update($gameId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('game', $data, array('ID'=> $gameId)); 
    }

    function insertContent($data){
        $contentData['PACK_ID']     = $data['PACK_ID'];
        $contentData['CREATED_BY']      = $this->session->userdata('user')->email;
        //$contentData['CONTENT_TYPE_ID'] = $data['CONTENT_TYPE_ID'];
        
        foreach($data['M_CONTENT_ID'] as $key=>$M_CONTENT_ID) {
            $contentData['M_CONTENT_ID'] = $M_CONTENT_ID;
            $contentData['ARRANGE']        = $key+1;
            $contentData['CREATED_ON']     = date("Y-m-d H:i:s");

            $this->db->insert('t_game_content_tmp', $contentData);
        }
        //return $this->db->insert('t_addgames_tmp', $data);
    }

    function updateContent($data){
        $contentData['PACK_ID']     = $data['PACK_ID'];
        //$contentData['CONTENT_TYPE_ID'] = $data['CONTENT_TYPE_ID'];
        //$del_query = "delete from t_game_content_tmp where PACK_ID=".$contentData['PACK_ID']." and M_CONTENT_ID not in('".implode("','",$data['M_CONTENT_ID'])."')";
        $this->db->where('PACK_ID', $contentData['PACK_ID']);
        $this->db->where_not_in('M_CONTENT_ID', $data['M_CONTENT_ID']);
       
        $this->db->delete('t_game_content_tmp');
        // echo $this->db->last_query();
        //$this->query($del_query);
        foreach($data['M_CONTENT_ID'] as $key=>$M_CONTENT_ID) {
            $contentData['M_CONTENT_ID'] = $M_CONTENT_ID;
            $contentData['ARRANGE']        = $key+1;
            
            $query = $this->db->get_where('t_game_content_tmp',array('PACK_ID'=>$contentData['PACK_ID'],'M_CONTENT_ID'=>$contentData['M_CONTENT_ID']));
            if($query->num_rows()==0){
                $contentData['CREATED_ON']     = date("Y-m-d H:i:s");
                $contentData['CREATED_BY']      = $this->session->userdata('user')->email;
                $this->db->insert('t_game_content_tmp', $contentData);
            }
            else{
                $contentData['MODIFIED_BY']      = $this->session->userdata('user')->email;
                $this->db->update('t_game_content_tmp', $contentData, array('PACK_ID'=> $contentData['PACK_ID'], 'M_CONTENT_ID'=> $contentData['M_CONTENT_ID'] )); 
            }
            //echo $this->db->last_query();
        } 
        //return $this->db->insert('t_addgames_tmp', $data);
    }
    
    function contentTypes($status = 0){
        if($status)
            $this->db->where('IS_ACTIVE' , 1);
        $query = $this->db->get('t_content_type');
        //echo $this->db->last_query();
        return $query->result();
    }

    function searchContent($data) {
        $m_content_ids = str_replace(' ','',$data['CONTENTID']);
        $query = $this->db->query("select CD.M_CONTENT_ID, CD.CONTENT_TYPE, CD.CONTENT_DISPLAY_TITLE, CD.LANGUAGES, 
                                    FD.FILE_PATH_LOCATION_S3
                                    FROM t_content_dtl_tmp CD
                                    LEFT JOIN t_files_dtl_tmp FD ON FD.M_CONTENT_ID = CD.M_CONTENT_ID 
                                        AND FILE_TYPE_NAME = 'Display Image' AND FILE_WIDTH = 50
                                    WHERE CD.M_CONTENT_ID in ($m_content_ids)
                                    GROUP BY CD.M_CONTENT_ID
                                    ORDER BY FIELD ( CD.M_CONTENT_ID,$m_content_ids)");
        //echo $this->db->last_query();die;
        return $query->result();
    }

    function contentDetail($game_id){
        $query = $this->db->query("select CD.M_CONTENT_ID, CD.CONTENT_TYPE, CD.CONTENT_DISPLAY_TITLE, CD.LANGUAGES, 
                                    FD.FILE_PATH_LOCATION_S3                                     
                                    FROM t_game_content_tmp PC
                                    INNER JOIN t_content_dtl_tmp CD ON PC.M_CONTENT_ID = CD.M_CONTENT_ID
                                    LEFT JOIN t_files_dtl_tmp FD ON FD.M_CONTENT_ID = CD.M_CONTENT_ID 
                                        AND FILE_TYPE_NAME = 'Display Image' AND FILE_WIDTH = 50
                                    WHERE PC.PACK_ID = '$game_id' GROUP BY CD.M_CONTENT_ID ORDER BY PC.ARRANGE ASC");
        return $query->result();
    }

    function setPositioning($updateArray){
        $this->db->update_batch('game',$updateArray, 'ID'); 
    }
}
?>