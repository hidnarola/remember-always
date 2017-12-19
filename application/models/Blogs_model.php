<?php

/**
 * Provider_model to manage service providers
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get providers for datatable
     * @param string $type - Either result or count
     * @return array for result or int for count
     */
    public function get_blogs($type = 'result', $data = array(), $start = 0, $offset = 5) {
        $this->db->select('title,image,description,b.slug,u.firstname,u.lastname,b.created_at');
        $this->db->join(TBL_USERS . ' u', 'u.id=b.user_id AND u.is_delete=0', 'left');
        $this->db->where(['b.is_delete' => 0, 'b.is_active' => 1]);
        $this->db->order_by('b.id DESC');
        if ($type == 'result') {
            $this->db->limit($offset, $start);
            $query = $this->db->get(TBL_BLOG_POST . ' b');
            return $query->result_array();
        } else {
            $query = $this->db->get(TBL_BLOG_POST . ' b');
            return $query->num_rows();
        }
    }

}

/* End of file Provider_model.php */
/* Location: ./application/models/admin/Provider_model.php */