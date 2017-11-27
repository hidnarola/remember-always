<?php

/**
 * Manage users table related database operation
 * @author KU
 */
class Users_model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Return user detail
     * @param string/array $where
     * @param string/array $select
     * @return array
     */
    public function get_user_detail($where, $select = '*') {
        $this->db->select($select);
        $this->db->where($where);
        return $this->db->get(TBL_USERS)->row_array();
    }

    /**
     * Set cookie with passed email id
     * @param string $email
     * @return boolean
     */
    public function activate_admin_remember_me($email) {
        $encoded_email = $this->encrypt->encode($email);
        set_cookie(REMEMBER_ME_ADMIN_COOKIE, $encoded_email, time() + (3600 * 24 * 360));
        return true;
    }

    /**
     * Get users for data table
     * @param string $type - Either result or count
     * @return array for result or int for count
     */
    public function get_users($type = 'result') {
        $columns = ['id', 'profile_image', 'firstname', 'lastname', 'email', 'created', 'is_active'];
        $keyword = $this->input->get('search');

        if (!empty($keyword['value'])) {
            $this->db->where('(firstname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ' OR lastname LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ' OR email LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ' OR CONCAT(firstname , " " ,lastname) LIKE ' . $this->db->escape('%' . $keyword['value'] . '%') . ')');
        }

        $this->db->where(['role!=' => 'admin', 'is_delete' => 0]);
        $this->db->order_by($columns[$this->input->get('order')[0]['column']], $this->input->get('order')[0]['dir']);
        if ($type == 'result') {
            $this->db->limit($this->input->get('length'), $this->input->get('start'));
            $query = $this->db->get(TBL_USERS);
            return $query->result_array();
        } else {
            $query = $this->db->get(TBL_USERS);
            return $query->num_rows();
        }
    }

    /**
     * Check email exist or not for unique email
     * @param string $email
     * @return array
     */
    public function check_unique_email($email) {
        $this->db->where('email', $email);
        $this->db->where('is_delete', 0);
        $query = $this->db->get(TBL_USERS);
        return $query->row_array();
    }

}
