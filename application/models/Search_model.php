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
                if ($keyword != '') {
                    $this->db->where('(firstname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR lastname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR CONCAT(firstname," ",lastname) LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR life_bio LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
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
                $this->db->select('s.slug,s.name,s.image,s.description,"service_provider" as type ');
                $this->db->where(['s.is_delete' => 0, 's.is_active' => 1]);
                // if keyword is not empty
                if ($keyword != '') {
                    $this->db->where('(s.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR s.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                // if location is not empty
                if ($location != '') {
                    $this->db->where('(s.location LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ')');
                    $this->db->join(TBL_CITY . ' as c', 's.city=c.id', 'left');
                    $this->db->join(TBL_STATE . ' as st', 's.state=st.id', 'left');
                }
                $this->db->order_by('s.id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' s');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' s');
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'affiliation') {
                $this->db->select('a.slug,a.name,a.image,a.description,"affiliation" as type');
                $this->db->where(['a.is_delete' => 0, 'a.is_approved' => 1]);
                if ($keyword != '') {
                    $this->db->where('(a.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR a.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                // if location is not empty
                if ($location != '') {
                    $this->db->where('(cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ')');
                    $this->db->join(TBL_COUNTRY . ' as cn', 'a.country=cn.id', 'left');
                    $this->db->join(TBL_STATE . ' as st', 'a.state=st.id', 'left');
                    $this->db->join(TBL_CITY . ' as c', 'a.city=c.id', 'left');
                }
                $this->db->order_by('a.id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_AFFILIATIONS . ' a');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_AFFILIATIONS . ' a');
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'blog') {
                $this->db->select('slug,title as name,image,description,"blog" as type');
                $this->db->where(['is_delete' => 0, 'is_active' => 1]);
                if ($keyword != '') {
                    $this->db->where('(title LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                $this->db->order_by('id DESC');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_BLOG_POST);
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_BLOG_POST);
                    $result = $query->num_rows();
                }
            } else {
                $where_profile = $where_provider = $where_affiliation = $where_blog = '';
                if ($keyword != '') {
                    $where_profile = ' AND (p.firstname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR p.lastname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR CONCAT(p.firstname," ",p.lastname) LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR p.life_bio LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')';
                    $where_provider = ' AND (sp.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR sp.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')';
                    $where_affiliation = ' AND (a.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR a.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')';
                    $where_blog = ' AND (b.title LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR b.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')';
                }
                $sql = 'SELECT s.* FROM (SELECT id,CONCAT(firstname," ",lastname) as name,slug,profile_image as image,life_bio as description,"profile" as type '
                        . 'FROM ' . TBL_PROFILES . ' p '
                        . 'WHERE p.is_delete=0 AND p.is_published=1' . $where_profile
                        . ' UNION ALL '
                        . 'SELECT sp.id,sp.name,sp.slug,sp.image,sp.description,"service_provider" as type '
                        . 'FROM ' . TBL_SERVICE_PROVIDERS . ' sp '
                        . 'WHERE sp.is_delete=0 AND sp.is_active=1' . $where_provider .
                        ' UNION ALL ' .
                        'SELECT a.id,a.name,a.slug,a.image,a.description,"affiliation" as type '
                        . 'FROM ' . TBL_AFFILIATIONS . ' a '
                        . 'WHERE a.is_delete=0 AND a.is_approved=1' . $where_affiliation .
                        ' UNION ALL ' .
                        'SELECT b.id,b.title as name,b.slug,b.image,b.description,"blog" as type '
                        . 'FROM ' . TBL_BLOG_POST . ' b '
                        . 'WHERE b.is_delete=0 AND b.is_active=1' . $where_blog . ') as s';

                if ($location != '') {
                    $sql = 'SELECT s.* FROM (SELECT id,CONCAT(firstname," ",lastname) as name,slug,profile_image as image,life_bio as description,"profile" as type '
                            . 'FROM ' . TBL_PROFILES . ' p '
                            . 'WHERE p.is_delete=0 AND p.is_published=1' . $where_profile
                            . ' UNION ALL '
                            . 'SELECT sp.id,sp.name,sp.slug,sp.image,sp.description,"service_provider" as type '
                            . 'FROM ' . TBL_SERVICE_PROVIDERS . ' sp LEFT JOIN ' . TBL_STATE . ' st ON sp.state = st.id LEFT JOIN ' . TBL_CITY . ' c ON sp.city=c.id '
                            . 'WHERE sp.is_delete=0 AND sp.is_active=1 AND (sp.location LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') . ')' . $where_provider .
                            ' UNION ALL ' .
                            'SELECT a.id,a.name,a.slug,a.image,a.description,"affiliation" as type '
                            . 'FROM ' . TBL_AFFILIATIONS . ' a LEFT JOIN ' . TBL_COUNTRY . ' cn ON a.country=cn.id LEFT JOIN ' . TBL_STATE . ' sts ON a.state=sts.id LEFT JOIN ' . TBL_CITY . ' ci ON a.city=ci.id '
                            . 'WHERE a.is_delete=0 AND a.is_approved=1 AND (cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR sts.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ' OR ci.name LIKE ' . $this->db->escape('%' . $location . '%') .
                            ')' . $where_affiliation .
                            ' UNION ALL ' .
                            'SELECT b.id,b.title as name,b.slug,b.image,b.description,"blog" as type '
                            . 'FROM ' . TBL_BLOG_POST . ' b '
                            . 'WHERE b.is_delete=0 AND b.is_active=1' . $where_blog . ') as s';
                }

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
            if ($keyword != '') {
                $this->db->where('(firstname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                        ' OR lastname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                        ' OR CONCAT(firstname," ",lastname) LIKE ' . $this->db->escape('%' . $keyword . '%') .
                        ' OR life_bio LIKE ' . $this->db->escape('%' . $keyword . '%') .
                        ')');
            }
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

    /**
     * Get auto complete results based on search
     * @param string $search_text
     * @return arr
     */
    function find($search_text) {
        $sql = 'SELECT s.* FROM (SELECT CONCAT(firstname," ",lastname) as name,slug,profile_image as image,"profile" as type '
                . 'FROM ' . TBL_PROFILES . ' p '
                . 'WHERE p.is_delete=0 AND p.is_published=1 AND (p.firstname LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' OR p.lastname LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' OR CONCAT(p.firstname," ",p.lastname) LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ')'
                . ' UNION ALL '
                . 'SELECT sp.name,sp.slug,sp.image,"service_provider" as type '
                . 'FROM ' . TBL_SERVICE_PROVIDERS . ' sp '
                . 'WHERE sp.is_delete=0 AND sp.is_active=1 AND sp.name LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' UNION ALL ' .
                'SELECT a.name,a.slug,a.image,"affiliation" as type '
                . 'FROM ' . TBL_AFFILIATIONS . ' a'
                . ' WHERE a.is_delete=0 AND a.is_approved=1 AND a.name LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' UNION ALL ' .
                'SELECT b.title as name,b.slug,b.image,"blog" as type '
                . 'FROM ' . TBL_BLOG_POST . ' b '
                . ' WHERE b.is_delete=0 AND b.is_active=1 AND b.title LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ') s ORDER BY name ASC';
        $data = $this->db->query($sql);
        return $data->result_array();
    }

}

/* End of file Search_model.php */
/* Location: ./application/models/Search_model.php */