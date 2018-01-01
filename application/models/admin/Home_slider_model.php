<?php

/**
 * home_slider_model for home slider functions
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_slider_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_all_slider($count = '') {
        $start = $this->input->get('start');
        $columns = ['test_id', 'description', 'image', 'is_active', 's.id'];
        $this->db->select('s.id,@a:=@a+1 AS test_id,description,image,is_active', false);
        $this->db->where('s.is_delete', '0');
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
//            $this->db->having('description LIKE "%' . $keyword['value'] . '%" OR is_active LIKE "%' . $keyword['value'] . '%"', NULL);
            $this->db->where('description LIKE ' . $this->db->escape('%' . $keyword['value'] . '%'));
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($count == 'count') {
            $res_data = $this->db->get(TBL_SLIDER . ' s')->num_rows();
        } else {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $res_data = $this->db->get(TBL_SLIDER . ' s,(SELECT @a:= ' . $start . ') AS a')->result_array();
        }
        return $res_data;
    }

}

/* End of file Home_slider_model.php */
/* Location: ./application/models/admin/Home_slider_model.php */