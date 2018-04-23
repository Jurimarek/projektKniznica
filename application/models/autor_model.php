<?php
/**
 * Created by PhpStorm.
 * User: Jurik
 * Date: 16.4.2018
 * Time: 21:42
 */

class autor_model extends CI_Model
{

    function getRows($id = "")
    {
        if (!empty($id)) {
            $query = $this->db->get_where('autor', array('id' => $id));
            return $query->row_array();
        } else {
            $query = $this->db->get('autor');
            return $query->result_array();
        }
    }

//vlozenie zaznamu
    public function insert($data = array())
    {
        $insert = $this->db->insert('autor', $data);
        if ($insert) {
            return $this->db->insert_id();
        } else {
            return false;
        }

    }

// aktualizacia zaznamu
    public function update($data, $id)
    {
        if (!empty($data) && !empty($id)) {
            $update = $this->db->update('autor', $data,
                array('id' => $id));
            return $update ? true : false;
        } else {
            return false;
        }
    }

// odstranenie zaznamu
    public function delete($id)
    {
        $delete = $this->db->delete('autor', array('id' => $id));
        return $delete ? true : false;
    }
}