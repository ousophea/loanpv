<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Accounts extends CI_Model {

    function signin() {

        $this->db->from(TABLE_PREFIX . 'users');
        $this->db->where('use_name', $this->input->post('username'));
        $this->db->where('use_pass', get_password($this->input->post('password')));
        $this->db->where('use_status', 1);
        $this->db->join(TABLE_PREFIX.'groups','use_gro_id=gro_id');
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            $data->result_array();
            $user = $data->result_array[0];
            unset($user['use_pass']);
            $this->session->set_userdata('user', $user);
            $this->session->set_userdata('group', $group);
            return TRUE;
        } else {
            return false;
        }
    }

    function findAllAccounts($num_row, $from_row) {
        $this->db->order_by('use_id', 'desc');

        if ($this->input->post('use_name') != '') {
            $this->db->like('use_name', $this->input->post('use_name'));
        }
        if ($this->input->post('use_email') != '') {
            $this->db->like('use_email', $this->input->post('use_email'));
        }

        // Keep pagination for filter status
        if ($this->input->post('use_status') != '') {
            $this->session->set_userdata('use_status', $this->input->post('use_status'));
        }
        if ($this->input->post('submit') && $this->input->post('use_status') == '') {
            $this->session->set_userdata('use_status', '');
        }
        if ($this->session->userdata('use_status') != '') {
            $this->db->where('use_status', $this->session->userdata('use_status'));
        }
        // Keep pagination for filter group
        if ($this->input->post('use_gro_id') && $this->input->post('use_gro_id') != '') {
            $this->session->set_userdata('use_gro_id', $this->input->post('use_gro_id'));
        }
        if ($this->input->post('submit') && $this->input->post('use_gro_id') == '') {
            $this->session->set_userdata('use_gro_id', '');
        }
        if ($this->session->userdata('use_gro_id') && $this->session->userdata('use_gro_id') != '') {
            $this->db->where('use_gro_id', $this->session->userdata('use_gro_id'));
        }
        //-----------------------

        $this->db->limit($num_row, $from_row);
        $this->db->from(TABLE_PREFIX . 'users');
        $this->db->join(TABLE_PREFIX . 'groups', 'use_gro_id=gro_id', 'left');
        $this->db->where('use_name <>', "Administrator");
        $this->db->group_by('use_id');
        return $this->db->get();
    }

    function countAllAccounts() {

        // Keep pagination for filter status
        if ($this->input->post('use_status') != '') {
            $this->session->set_userdata('use_status', $this->input->post('use_status'));
        }
        if ($this->input->post('submit') && $this->input->post('use_status') == '') {
            $this->session->set_userdata('use_status', '');
        }
        if ($this->session->userdata('use_status') != '') {
            $this->db->where('use_status', $this->session->userdata('use_status'));
        }
        // Keep pagination for filter group
        if ($this->input->post('tbl_groups_gro_id') && $this->input->post('tbl_groups_gro_id') != '') {
            $this->session->set_userdata('tbl_groups_gro_id', $this->input->post('tbl_groups_gro_id'));
        }
        if ($this->input->post('submit') && $this->input->post('tbl_groups_gro_id') == '') {
            $this->session->set_userdata('tbl_groups_gro_id', '');
        }
        if ($this->session->userdata('tbl_groups_gro_id') && $this->session->userdata('tbl_groups_gro_id') != '') {
            $this->db->where('tbl_groups_gro_id', $this->session->userdata('tbl_groups_gro_id'));
        }
        //-----------------------

        $this->db->from(TABLE_PREFIX . 'users');
        $this->db->join(TABLE_PREFIX . 'user_group', 'use_id=tbl_users_use_id', 'left');
        $this->db->group_by('use_id');
        $data = $this->db->get();
        return $data->num_rows();
    }

    /**
     * Add new group
     * @return true/false
     */
    function add() {
        $data = $this->input->post();
//        $group_id = $data['use_gro_id'];
//        unset($data['use_passc']);
//        unset($data['use_gro_id']);
        $data['use_pass'] = get_password("1234567");
        $this->db->set('use_created', 'NOW()', false);
        if (empty($data['use_status'])) {
            $this->db->set('use_status', 0);
        }
        $result = $this->db->insert(TABLE_PREFIX . 'users', $data);
        return $result;
    }

    /**
     * Edit a group
     * @return true/false
     */
    function update() {
        $data = $this->input->post();
        $this->db->where('use_id', $this->uri->segment(4));
        $this->db->set('use_modified', 'NOW()', false);
        // if checkbox is not checked
        if (empty($data['use_status'])) {
            $this->db->set('use_status', 0);
        }
        return $this->db->update(TABLE_PREFIX . 'users', $data);
    }

    function resetPassById($id = null) {
        $this->db->where('use_id', $id);
        $this->db->set('use_modified', 'NOW()', false);
        $this->db->set('use_pass', '1234567', false);
        return $this->db->update(TABLE_PREFIX . 'users');
    }

    function getAccountById($id) {
        $this->db->where('use_id', $id);
        return $this->db->get(TABLE_PREFIX . 'users');
    }

    function getGroupByAccountId($id) {

        $this->db->where('gro_id', $id);
        $this->db->from(TABLE_PREFIX . 'groups');
//        $this->db->join(TABLE_PREFIX . 'user_group', 'gro_id=usegro_groupid');
        return $this->db->get();
    }

    function getUserById($id) {
        $this->db->where('use_id', $id);
        return $this->db->get(TABLE_PREFIX . 'users');
    }

    function deleteUserById($id = null) {
//        $this->db->where('use_id', $id);
//        return $this->db->delete(TABLE_PREFIX . 'users');
        
        $this->db->where('use_id', $id);
        $this->db->set('use_modified', 'NOW()', false);
        $this->db->set('use_status', '4', false); // go to trusk
        return $this->db->update(TABLE_PREFIX . 'users');
    }

    function changePassword() {

        $user = $this->session->userdata('user');
        $this->db->where('use_id', $user['use_id']);

//        $this->db->where('use_pass', get_password($this->input->post('password_old')));

        $data = $this->db->get(TABLE_PREFIX . 'users');
        if ($data->num_rows() > 0) {
            $this->db->where('use_id', $user['use_id']);
//            $this->db->where('use_pass', get_password($this->input->post('password_old')));
            $this->db->set('use_pass', get_password($this->input->post('use_pass')));
            $this->db->set('use_modified', "NOW()", false);
            return $this->db->update(TABLE_PREFIX . 'users');
        }
        return false;
    }

}
