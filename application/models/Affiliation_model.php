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
        $this->db->select('a.*,ac.name as category');
        $this->db->join(TBL_AFFILIATIONS_CATEGORY . ' ac', 'ac.id=a.category_id AND ac.is_delete=0', 'left');
// if (!empty($keyword['value'])) {
//            $this->db->having('name LIKE "%' . $keyword['value'] . '%" OR category_name LIKE "%' . $keyword['value'] . '%"', NULL);
//        }
        if (isset($data) && !empty($data)) {
            if (isset($data['category'])) {
                $this->db->where('c.name LIKE ' . $this->db->escape('%' . $data['category'] . '%' . ''));
            }
            if (isset($data['keyword'])) {
                $this->db->where('p.name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . ''));
            }

            if (isset($data['location'])) {
                if (isset($data['lat']) && isset($data['long']) && !isset($data['location'])) {
                    $latitude = $longitude = '';
                    $latitude = $data['lat'];
                    $longitude = $data['long'];
                    if ($latitude != '' && $longitude != '') {
                        $this->db->select('( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( p.latitute ) ) * cos( radians( p.longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( p.latitute ) ) ) ) AS distance');
                        $this->db->having('distance <', 50);
                    }
                } else {
                    $this->db->where('p.zipcode LIKE ' . $this->db->escape('%' . $data['location'] . '%' . ''));
                }
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