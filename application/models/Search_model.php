<?php

/**
 * Search_model for global search functionality
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get search results
     * @param string $type - either result or count
     * @param int $start
     * @param int $offset
     * @return array or count based on type
     */
    public function get_results($type = 'result', $start = 0, $offset = 12) {
        $search_type = $this->input->get('type');
        $keyword = $this->input->get('keyword');
        $location = $this->input->get('location');
        $result = [];
        if ($search_type != '') {
            if ($search_type == 'profile') {
                $this->db->select('slug,CONCAT(firstname," ",lastname) as name,profile_image as image,life_bio as description,"profile" as type');
                $this->db->where(['is_delete' => 0, 'is_published' => 1]);
                $this->db->order_by('id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_PROFILES);
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_PROFILES);
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'service_provider') {
                $this->db->select('slug,name,image,description,"service_provider" as type ');
                $this->db->where(['is_delete' => 0, 'is_active' => 1]);
                $this->db->order_by('id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS);
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS);
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'affiliation') {
                $this->db->select('slug,name,image,description,"affiliation" as type');
                $this->db->where(['is_delete' => 0, 'is_approved' => 1]);
                $this->db->order_by('id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_AFFILIATIONS);
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_AFFILIATIONS);
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'blog') {
                $this->db->select('slug,title as name,image,description,"blog" as type');
                $this->db->where(['is_delete' => 0, 'is_active' => 1]);
                $this->db->order_by('id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_BLOG_POST . ' b');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_BLOG_POST . ' b');
                    $result = $query->num_rows();
                }
            } else {

                $sql = 'SELECT s.* FROM (SELECT id,CONCAT(firstname," ",lastname) as name,slug,profile_image as image,life_bio as description,"profile" as type '
                        . 'FROM ' . TBL_PROFILES . ' '
                        . 'WHERE is_delete=0 AND is_published=1'
                        . ' UNION ALL '
                        . 'SELECT id,name,slug,image,description,"service_provider" as type '
                        . 'FROM ' . TBL_SERVICE_PROVIDERS . ' '
                        . 'WHERE is_delete=0 AND is_active=1' .
                        ' UNION ALL ' .
                        'SELECT id,name,slug,image,description,"affiliation" as type '
                        . 'FROM ' . TBL_AFFILIATIONS . ' '
                        . 'WHERE is_delete=0 AND is_approved=1' .
                        ' UNION ALL ' .
                        'SELECT id,title as name,slug,image,description,"blog" as type '
                        . 'FROM ' . TBL_BLOG_POST . ' '
                        . 'WHERE is_delete=0 AND is_active=1) as s';

                $sql .= ' ORDER BY s.id DESC';
                if ($type == 'result') {
                    $sql .= ' LIMIT ' . $start . ',' . $offset;
                    $query = $this->db->query($sql);
                    $result = $query->result_array();
                } else {
                    $query = $this->db->query($sql);
                    $result = $query->num_rows();
                }
            }
        } else {
            $this->db->select('slug,CONCAT(firstname," ",lastname) as name,profile_image as image,life_bio as description,"profile" as type');
            $this->db->where(['is_delete' => 0, 'is_published' => 1]);
            $this->db->order_by('id DESC');
            if ($type == 'result') {
                $this->db->limit($offset, $start);
                $query = $this->db->get(TBL_PROFILES . ' p');
                $result = $query->result_array();
            } else {
                $query = $this->db->get(TBL_PROFILES . ' p');
                $result = $query->num_rows();
            }
        }
        return $result;
    }

}

/* End of file Search_model.php */
/* Location: ./application/models/Search_model.php */