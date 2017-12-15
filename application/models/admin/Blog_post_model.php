<?php

/**
 * Post_model for Post related all functions
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_post_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_posts($count = '') {
        $columns = ['p.id', 'p.title', 'p.description', 'p.image', 'p.created_at', 'u.firstname', 'u.lastname', 'p.is_active', 'p.is_view'];
        $keyword = $this->input->get('search');
        $this->db->select('p.id,p.title,p.description,p.image,p.created_at,u.firstname,u.lastname,p.is_active,p.is_view,(SELECT COUNT(*) FROM ' . TBL_BLOG_POST . ' WHERE is_delete=0 AND is_view=1) AS sub_count');
        $this->db->join(TBL_USERS . ' u', 'u.id=p.user_id AND u.is_delete=0', 'left');
        if (!empty($keyword['value'])) {
            $this->db->where('(p.comment LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR firstname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR lastname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR CONCAT(firstname , " " ,lastname) LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ')');
        }
        $this->db->where(['p.is_delete' => 0]);
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($count == 'result') {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $query = $this->db->get(TBL_BLOG_POST . ' p')->result_array();
        } else {
            $query = $this->db->get(TBL_BLOG_POST . ' p')->num_rows();
        }
        return $query;
    }

}

/* End of file Post_model.php */
/* Location: ./application/models/admin/Post_model.php */