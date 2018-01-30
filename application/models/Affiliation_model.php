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
    public function get_all_affiliation($type = 'result', $data = array(), $start = 0, $offset = 5) {
        $this->db->select('a.*,ac.name as category,con.name as con_name,st.name as s_name,c.name as c_name');
        $this->db->join(TBL_AFFILIATIONS_CATEGORY . ' ac', 'ac.id=a.category_id AND ac.is_delete=0', 'left');
        $this->db->join(TBL_COUNTRY . ' con', 'con.id=a.country', 'left');
        $this->db->join(TBL_STATE . ' st', 'st.id=a.state', 'left');
        $this->db->join(TBL_CITY . ' c', 'c.id=a.city', 'left');
        if (isset($data) && !empty($data)) {
            if (isset($data['category'])) {
//                $this->db->where('ac.name LIKE ' . $this->db->escape('%' . $data['category'] . '%' . ''));
                $this->db->where('ac.slug LIKE ' . $this->db->escape('%' . $data['category'] . '%' . ''));
            }
            if (isset($data['keyword'])) {
                $this->db->having('a.name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . '') . ' OR a.description LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . '') . ' OR con_name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . '') . ' OR s_name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . '') . ' OR c_name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . ''));
            }
        }
        if ($type == 'count') {
            $res_data = $this->db->get(TBL_AFFILIATIONS . ' a')->num_rows();
        } else {
            $this->db->limit($offset, $start);
            $this->db->where(['a.is_delete' => '0', 'a.is_approved' => 1]);
            $res_data = $this->db->get(TBL_AFFILIATIONS . ' a')->result_array();
        }
        return $res_data;
    }

}

/* End of file Category_model.php */
/* Location: ./application/models/Affiliation_model.php */