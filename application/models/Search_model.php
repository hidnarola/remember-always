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
        $keyword = trim($this->input->get('keyword'));
        $location = trim($this->input->get('location'));
        $result = [];
        if ($search_type != '') {
            if ($search_type == 'profile') {
                $this->db->select('slug,CONCAT(firstname," ",lastname) as name,profile_image as image,life_bio as description,"profile" as type,cn.name as country,st.name as state,c.name as city,p.date_of_birth,p.date_of_death');
                $this->db->where(['is_delete' => 0, 'is_published' => 1]);
                if ($keyword != '') {
                    $this->db->where('(firstname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR lastname LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR CONCAT(firstname," ",lastname) LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR life_bio LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                if ($location != '') {
                    $location_arr = explode(',', $location);
                    $loc_count = count($location_arr);
                    if ($loc_count > 1) {
                        $new_arr = [];
                        foreach ($location_arr as $arr) {
                            $new_arr[] = 'cn.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'st.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'c.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                        }
                        $new_string = '(' . implode(' OR ', $new_arr) . ')';
                        $this->db->where($new_string);
                    } else {
                        $this->db->where('(cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')');
                    }
                }
                $this->db->order_by('created_at', 'DESC');
                $this->db->join(TBL_COUNTRY . ' as cn', 'p.country=cn.id', 'left');
                $this->db->join(TBL_STATE . ' as st', 'p.state=st.id', 'left');
                $this->db->join(TBL_CITY . ' as c', 'p.city=c.id', 'left');

                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_PROFILES . ' p');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_PROFILES . ' p');
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'service_provider') {
                $this->db->select('s.slug,s.name,s.image,s.description,"service_provider" as type,cn.name as country,st.name as state,c.name as city,"" date_of_birth,"" date_of_death');
                $this->db->where(['s.is_delete' => 0, 's.is_active' => 1]);
                // if keyword is not empty
                if ($keyword != '') {
                    $this->db->where('(s.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR s.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                // if location is not empty
                if ($location != '') {

                    $location_arr = explode(',', $location);
                    $loc_count = count($location_arr);
                    if ($loc_count > 1) {
                        $new_arr = [];
                        foreach ($location_arr as $arr) {
                            $new_arr[] = 's.location LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'cn.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'st.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'c.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                        }
                        $new_string = '(' . implode(' OR ', $new_arr) . ')';
                        $this->db->where($new_string);
                    } else {
                        $this->db->where('(s.location LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')');
                    }
                }
                $this->db->order_by('s.name');
                $this->db->join(TBL_COUNTRY . ' as cn', 's.country=cn.id', 'left');
                $this->db->join(TBL_STATE . ' as st', 's.state=st.id', 'left');
                $this->db->join(TBL_CITY . ' as c', 's.city=c.id', 'left');

                if ($type == 'result') {

                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' s');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' s');
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'affiliation') {
                $this->db->select('a.slug,a.name,a.image,a.description,"affiliation" as type,cn.name as country,st.name as state,c.name as city,"" date_of_birth,"" date_of_death');
                $this->db->where(['a.is_delete' => 0, 'a.is_approved' => 1]);
                if ($keyword != '') {
                    $this->db->where('(a.name LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR a.description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                // if location is not empty
                if ($location != '') {
                    $location_arr = explode(',', $location);
                    $loc_count = count($location_arr);
                    if ($loc_count > 1) {
                        $new_arr = [];
                        foreach ($location_arr as $arr) {
                            $new_arr[] = 'cn.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'st.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $new_arr[] = 'c.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                        }
                        $new_string = '(' . implode(' OR ', $new_arr) . ')';
                        $this->db->where($new_string);
                    } else {
                        $this->db->where('(cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')');
                    }
                }
                $this->db->join(TBL_COUNTRY . ' as cn', 'a.country=cn.id', 'left');
                $this->db->join(TBL_STATE . ' as st', 'a.state=st.id', 'left');
                $this->db->join(TBL_CITY . ' as c', 'a.city=c.id', 'left');
                $this->db->order_by('a.name');
                if ($type == 'result') {
                    $this->db->limit($offset, $start);
                    $query = $this->db->get(TBL_AFFILIATIONS . ' a');
                    $result = $query->result_array();
                } else {
                    $query = $this->db->get(TBL_AFFILIATIONS . ' a');
                    $result = $query->num_rows();
                }
            } elseif ($search_type == 'blog') {
                $this->db->select('slug,title as name,image,description,"blog" as type,"" as counry,"" as state,"" as city,"" date_of_birth,"" date_of_death');
                $this->db->where(['is_delete' => 0, 'is_active' => 1]);
                if ($keyword != '') {
                    $this->db->where('(title LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ' OR description LIKE ' . $this->db->escape('%' . $keyword . '%') .
                            ')');
                }
                $this->db->order_by('title');
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
                $location_profile = $location_provider = $location_affiliation = '';
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
                if ($location != '') {

                    $location_arr = explode(',', $location);
                    $loc_count = count($location_arr);
                    if ($loc_count > 1) {
                        $profile_arr = $provider_arr = $affiliation_arr = [];
                        foreach ($location_arr as $arr) {
                            $profile_arr[] = 'pc.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $profile_arr[] = 'ps.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $profile_arr[] = 'pci.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');

                            $provider_arr[] = 'c.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $provider_arr[] = 'st.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $provider_arr[] = 'sc.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');

                            $affiliation_arr[] = 'cn.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $affiliation_arr[] = 'sts.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                            $affiliation_arr[] = 'ci.name LIKE ' . $this->db->escape('%' . trim($arr) . '%');
                        }
                        $location_profile = ' AND (' . implode(' OR ', $profile_arr) . ')';
                        $location_provider = ' AND (' . implode(' OR ', $provider_arr) . ')';
                        $location_affiliation = ' AND (' . implode(' OR ', $affiliation_arr) . ')';
                    } else {
                        $location_profile = ' AND (pc.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR ps.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR pci.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')';
                        $location_provider = ' AND (c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR sc.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')';
                        $location_affiliation = ' AND (cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR sts.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ' OR ci.name LIKE ' . $this->db->escape('%' . $location . '%') .
                                ')';
                    }
                }

                $sql = 'SELECT s.* FROM (SELECT p.id,CONCAT(firstname," ",lastname) as name,slug,profile_image as image,life_bio as description,"profile" as type,pc.name as country,ps.name as state,pci.name as city,p.date_of_birth,p.date_of_death,p.created_at '
                        . 'FROM ' . TBL_PROFILES . ' p '
                        . ' LEFT JOIN ' . TBL_COUNTRY . ' pc ON p.country=pc.id LEFT JOIN ' . TBL_STATE . ' ps ON p.state = ps.id LEFT JOIN ' . TBL_CITY . ' pci ON p.city=pci.id '
                        . 'WHERE p.is_delete=0 AND p.is_published=1' . $where_profile . $location_profile
                        . ' UNION ALL '.
                        'SELECT a.id,a.name,a.slug,a.image,a.description,"affiliation" as type,cn.name as country,sts.name as state,ci.name as city,"" date_of_birth,"" date_of_death,a.created_at '
                        . 'FROM ' . TBL_AFFILIATIONS . ' a LEFT JOIN ' . TBL_COUNTRY . ' cn ON a.country=cn.id LEFT JOIN ' . TBL_STATE . ' sts ON a.state=sts.id LEFT JOIN ' . TBL_CITY . ' ci ON a.city=ci.id '
                        . 'WHERE a.is_delete=0 AND a.is_approved=1 ' . $where_affiliation . $location_affiliation .
                        ' UNION ALL ' .
                        'SELECT b.id,b.title as name,b.slug,b.image,b.description,"blog" as type,"" as country,"" as state,"" as city,"" date_of_birth,"" date_of_death,b.created_at '
                        . 'FROM ' . TBL_BLOG_POST . ' b '
                        . 'WHERE b.is_delete=0 AND b.is_active=1' . $where_blog . ') as s';


                $sql .= ' ORDER BY FIELD(type, "profile") DESC,created_at DESC,s.name';
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
            $where_profile = $where_provider = $where_affiliation = $where_blog = '';
            $location_profile = $location_provider = $location_affiliation = '';
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
            if ($location != '') {
                $location_profile = ' AND (pc.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR ps.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR pci.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ')';
                $location_provider = ' AND (c.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR st.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR sc.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ')';
                $location_affiliation = ' AND (cn.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR sts.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ' OR ci.name LIKE ' . $this->db->escape('%' . $location . '%') .
                        ')';
            }

            $sql = 'SELECT s.* FROM (SELECT p.id,CONCAT(firstname," ",lastname) as name,slug,profile_image as image,life_bio as description,"profile" as type,pc.name as country,ps.name as state,pci.name as city,p.date_of_birth,p.date_of_death,p.created_at '
                    . 'FROM ' . TBL_PROFILES . ' p '
                    . ' LEFT JOIN ' . TBL_COUNTRY . ' pc ON p.country=pc.id LEFT JOIN ' . TBL_STATE . ' ps ON p.state = ps.id LEFT JOIN ' . TBL_CITY . ' pci ON p.city=pci.id '
                    . 'WHERE p.is_delete=0 AND p.is_published=1' . $where_profile . $location_profile
                    . ' UNION ALL ' .
                    'SELECT a.id,a.name,a.slug,a.image,a.description,"affiliation" as type,cn.name as country,sts.name as state,ci.name as city,"" date_of_birth,"" date_of_death,a.created_at '
                    . 'FROM ' . TBL_AFFILIATIONS . ' a LEFT JOIN ' . TBL_COUNTRY . ' cn ON a.country=cn.id LEFT JOIN ' . TBL_STATE . ' sts ON a.state=sts.id LEFT JOIN ' . TBL_CITY . ' ci ON a.city=ci.id '
                    . 'WHERE a.is_delete=0 AND a.is_approved=1 ' . $where_affiliation . $location_affiliation .
                    ' UNION ALL ' .
                    'SELECT b.id,b.title as name,b.slug,b.image,b.description,"blog" as type,"" as country,"" as state,"" as city,"" date_of_birth,"" date_of_death,b.created_at '
                    . 'FROM ' . TBL_BLOG_POST . ' b '
                    . 'WHERE b.is_delete=0 AND b.is_active=1' . $where_blog . ') as s';


            $sql .= ' ORDER BY FIELD(s.type, "profile") DESC,created_at DESC,s.name';
            if ($type == 'result') {
                $sql .= ' LIMIT ' . $start . ',' . $offset;
                $query = $this->db->query($sql);
                $result = $query->result_array();
            } else {
                $query = $this->db->query($sql);
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
        /* $sql = 'SELECT s.* FROM (SELECT CONCAT(firstname," ",lastname) as name,slug,profile_image as image,"profile" as type '
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
          ') s ORDER BY name ASC'; */
        $sql = 'SELECT s.* FROM (SELECT CONCAT(firstname," ",lastname) as name,slug,profile_image as image,"profile" as type '
                . 'FROM ' . TBL_PROFILES . ' p '
                . 'WHERE p.is_delete=0 AND p.is_published=1 AND (p.firstname LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' OR p.lastname LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' OR CONCAT(p.firstname," ",p.lastname) LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ')'
                . ' UNION ALL ' .
                'SELECT a.name,a.slug,a.image,"affiliation" as type '
                . 'FROM ' . TBL_AFFILIATIONS . ' a'
                . ' WHERE a.is_delete=0 AND a.is_approved=1 AND a.name LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ' UNION ALL ' .
                'SELECT b.title as name,b.slug,b.image,"blog" as type '
                . 'FROM ' . TBL_BLOG_POST . ' b '
                . ' WHERE b.is_delete=0 AND b.is_active=1 AND b.title LIKE ' . $this->db->escape('%' . $search_text . '%') .
                ') s ORDER BY FIELD(type, "profile") DESC,name ASC';
        $data = $this->db->query($sql);
        return $data->result_array();
    }

}

/* End of file Search_model.php */
/* Location: ./application/models/Search_model.php */