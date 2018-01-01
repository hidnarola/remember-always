<?php

/**
 * Category_model for category function
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_all_categories($count = '') {
        $start = $this->input->get('start');
        $columns = ['id', 'name', 's.id'];
        $this->db->select('s.id,name', false);
        $this->db->where('s.is_delete', '0');
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($count == 'count') {
            $res_data = $this->db->get(TBL_SERVICE_CATEGORIES . ' s')->num_rows();
        } else {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $res_data = $this->db->get(TBL_SERVICE_CATEGORIES . ' s')->result_array();
        }
        return $res_data;
    }

    /**
     * @uses : this function is used to get result based on datatable in affiliations categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_all_affiliation_categories($count = '') {
        $start = $this->input->get('start');
        $columns = ['test_id', 'name', 'ac.id'];
        $this->db->select('ac.id,@a:=@a+1 AS test_id,name', false);
        $this->db->where('ac.is_delete', '0');
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        if ($count == 'count') {
            $res_data = $this->db->get(TBL_AFFILIATIONS_CATEGORY . ' ac')->num_rows();
        } else {
            $res_data = $this->db->get(TBL_AFFILIATIONS_CATEGORY . ' ac,(SELECT @a:= ' . $start . ') AS a')->result_array();
        }
        return $res_data;
    }

}

/* End of file Category_model.php */
/* Location: ./application/models/admin/Category_model.php */