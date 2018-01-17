<?php

/**
 * Community model to manage online community functionality.
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Community_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses : this function is used to get result based on datatable in service categories list page
     * @param : @table 
     * @author : AKK
     */
    public function get_results($type = 'result', $start = 0, $offset = 5) {
        $this->db->select('q.title,q.user_id,q.slug,q.description,u.firstname,u.lastname,u.facebook_id,u.google_id,u.profile_image,IF(ans.answers IS NULL,0,ans.answers) answers,q.created_at');
        $this->db->join('(SELECT count(id) as answers,question_id FROM ' . TBL_ANSWERS . ' WHERE is_delete=0 GROUP BY question_id) ans', 'q.id=ans.question_id', 'left');
        $this->db->join(TBL_USERS . ' u', 'q.user_id=u.id', 'left');

        if ($this->input->get('keyword') != '') {
            $keyword = $this->input->get('keyword');
            $this->db->where('(q.title LIKE ' . $this->db->escape('%' . $keyword . '%') . ' OR q.description LIKE ' . $this->db->escape('%' . $keyword . '%') . ')');
        }
        if ($type == 'count') {
            $res_data = $this->db->get(TBL_QUESTIONS . ' q')->num_rows();
        } else {
            $this->db->order_by('q.id DESC');
            $this->db->limit($offset, $start);
            $this->db->where(['q.is_delete' => '0']);
            $res_data = $this->db->get(TBL_QUESTIONS . ' q')->result_array();
        }
        return $res_data;
    }

}

/* End of file Community_model.php */
/* Location: ./application/models/Community_model.php */