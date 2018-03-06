<?php

/**
 * Profile_model to manage profiles related activities
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all profiles created by user
     * @param string $type - either result or count
     * @return array/number depends on type
     */
    public function get_profiles($type = 'result') {
        $columns = ['p.id', 'p.profile_image', 'p.firstname', 'p.lastname', 'p.life_bio', 'u.firstname', 'p.created_at', 'p.most_visited', 'p.notable'];
        $keyword = $this->input->get('search');
        $this->db->select('p.id,p.profile_image,p.firstname,p.lastname,p.life_bio,CONCAT(u.firstname," ",u.lastname) created_by,p.created_at,p.most_visited,p.notable');
        $this->db->join(TBL_USERS . ' u', 'u.id=p.user_id AND u.is_delete=0', 'left');

        if (!empty($keyword['value'])) {
            $this->db->where('(p.firstname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR p.lastname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR p.life_bio LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR u.firstname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR u.lastname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR CONCAT(u.firstname," ",u.lastname) LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR DATE_FORMAT(p.created_at,\'%d %b %Y\') LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
                    ' OR p.created_at LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ')');
        }
        $this->db->where(['p.is_delete' => 0, 'p.is_published' => 1]);
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($type == 'result') {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $query = $this->db->get(TBL_PROFILES . ' p')->result_array();
        } else {
            $query = $this->db->get(TBL_PROFILES . ' p')->num_rows();
        }
        return $query;
    }

}

/* End of file Profile_model.php */
/* Location: ./application/models/admin/Profile_model.php */