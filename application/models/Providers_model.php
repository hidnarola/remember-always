<?php

/**
 * Provider_model to manage service providers
 * @author KU
 * */
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get providers for datatable
     * @param string $type - Either result or count
     * @return array for result or int for count
     */
    public function get_providers($type = 'result', $data = array()) {
//        if (!empty($keyword['value'])) {
//            $this->db->where('(c.name LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
//                    ' OR p.name LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
//                    ' OR p.description LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') .
//                    ' OR p.zipcode LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ')');
//        }

        $this->db->select('p.*,c.name as category');
        $this->db->join(TBL_SERVICE_CATEGORIES . ' c', 'p.service_category_id=c.id AND c.is_delete=0', 'left');
        if (isset($data) && !empty($data)) {
            if (isset($data['category'])) {
               $this->db->where('c.name LIKE ' . $this->db->escape('%' . $data['category'] . '%' . ''));
            }
            if (isset($data['keyword'])) {
               $this->db->where('p.name LIKE ' . $this->db->escape('%' . $data['keyword'] . '%' . ''));
            }

            if (isset($data['location'])) {
                $latitude = $longitude = '';
                $latitude = $data['lat'];
                $longitude = $data['long'];
                if ($latitude != '' && $longitude != '') {
                    $this->db->select('( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( p.latitute ) ) * cos( radians( p.longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( p.latitute ) ) ) ) AS distance');
                    $this->db->having('distance <', 50);
                }
            }
        }
        $this->db->where(['p.is_delete' => 0]);
//        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($type == 'result') {
//            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' p');
            return $query->result_array();
        } else {
            $query = $this->db->get(TBL_SERVICE_PROVIDERS . ' p');
            return $query->num_rows();
        }
    }

}

/* End of file Provider_model.php */
/* Location: ./application/models/admin/Provider_model.php */