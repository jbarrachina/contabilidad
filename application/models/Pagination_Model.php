<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagination_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

// Count all record of table "contact_info" in database.
    public function record_count() {
        return $this->db->count_all("apuntes");
    }

// Fetch data according to per_page limit.
    public function fetch_data($limit, $id) {
        $this->db->limit($limit);
        $this->db->where('id', $id);
        $query = $this->db->get("apuntes");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return false;
    }

}

?>