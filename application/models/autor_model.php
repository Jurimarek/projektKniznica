<?php
/**
 * Created by PhpStorm.
 * User: Jurik
 * Date: 16.4.2018
 * Time: 21:42
 */

 function getRows($id= "")
 {
     if (!empty($id)) {
         $query = $this->db->get_where('autor', array('id' => $id));
         return $query->row_array();
     } else {
         $query = $this->db->get('autor');
         return $query->result_array();
     }
 }


// vlozenie zaznamu
public function insert($data = array()) {
    $insert = $this->db->insert('autor', $data);
    if($insert){
        return $this->db->insert_id();
    }else {
        return false;
    }
 }
