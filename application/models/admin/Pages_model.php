<?php

/**
 * pages_model for category function
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in CMS pages list page
     * @param : @table 
     * @author : AKK
     */
    public function get_all_pages($count = '') {
        $start = $this->input->get('start');
        $columns = ['test_id', 'navigation_name', 'active', 'show_in_header', 'show_in_footer', 'p.id'];
        $this->db->select('p.id,@a:=@a+1 AS test_id,navigation_name,active,show_in_header,show_in_footer', false);
        $this->db->where('p.is_delete', '0');
        $keyword = $this->input->get('search');
        if (!empty($keyword['value'])) {
            $this->db->having('navigation_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        $this->db->limit($this->input->get('length'), $this->input->get('start'));
        if ($count == 'count') {
            $res_data = $this->db->get(TBL_PAGES . ' p')->num_rows();
        } else {
            $res_data = $this->db->get(TBL_PAGES . ' p,(SELECT @a:= ' . $start . ') AS a')->result_array();
        }
        return $res_data;
    }

}
