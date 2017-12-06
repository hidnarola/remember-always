<?php

/**
 * Post_model for Post related all functions
 * @author Akk
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_posts($count = '', $user_id = null) {
        $columns = ['p.id', 'p.comment', 'p.created_at', 'u.firstname', 'u.lastname'];
        $keyword = $this->input->get('search');
        $this->db->select('p.id,p.comment,p.created_at,u.firstname,u.lastname');
        $this->db->join(TBL_USERS . ' u', 'u.id=p.user_id AND u.is_delete=0', 'left');
        $this->db->join(TBL_PROFILES . ' pf', 'pf.id=p.profile_id AND pf.is_delete=0', 'left');
        if (!empty($keyword['value'])) {
            $this->db->where('(p.comment LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR firstname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR lastname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR CONCAT(firstname , " " ,lastname) LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ')');
        }
        $this->db->where(['p.is_delete' => 0]);
        if($user_id != null && is_numeric($user_id)){
            $this->db->where(['pf.user_id' => $user_id]);
        }
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($count == 'result') {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $query = $this->db->get(TBL_POSTS . ' p')->result_array();
        } else {
            $query = $this->db->get(TBL_POSTS . ' p')->num_rows();
        }
        return $query;
    }

}

/* End of file Post_model.php */
/* Location: ./application/models/admin/Post_model.php */