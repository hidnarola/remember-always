<?php

/**
 * Category_model for category function
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Affiliation_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_all_affiliation($count = '') {
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $keyword = $this->input->get('search');
        $columns = ['a.id', 'a.name', 'a.created_at', 'ac.name as category_name', 'is_approved', 'is_delete'];
        $this->db->select('a.id,a.name,a.created_at,ac.name as category_name,is_approved,a.is_delete', false);
        $this->db->join(TBL_AFFILIATIONS_CATEGORY . ' ac', 'ac.id=a.category_id AND ac.is_delete=0', 'left');
//        $sql = "SELECT * FROM ("
//                . "SELECT id,affiliation_text as name,'1' as free_text,created_at,'NULL' as category_name,is FROM " . TBL_PROFILE_AFFILIATIONTEXTS . " 
//                        UNION ALL
//                       SELECT p.id,a.name,'0' as free_text,p.created_at,ac.name as category_name FROM " . TBL_PROFILE_AFFILIATION . " p JOIN " . TBL_AFFILIATIONS . " a on p.affiliation_id=a.id LEFT JOIN " . TBL_AFFILIATIONS_CATEGORY . " ac on ac.id=a.category_id WHERE a.is_delete=0 
//                    ) a WHERE name LIKE '%" . $keyword . "%' category_name LIKE '%" . $keyword . "%' order by created_at " . "LIMIT" . $length . "," . $start;
        if (!empty($keyword['value'])) {
            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR category_name LIKE "%' . $keyword['value'] . '%"', NULL);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        $this->db->where('a.is_delete', '0');
        if ($count == 'count') {
            $res_data = $this->db->get(TBL_AFFILIATIONS . ' a')->num_rows();
        } else {
            $this->db->limit($length, $start);
            $res_data = $this->db->get(TBL_AFFILIATIONS . ' a')->result_array();
        }
        return $res_data;
    }

}

/* End of file Category_model.php */
/* Location: ./application/models/admin/Category_model.php */