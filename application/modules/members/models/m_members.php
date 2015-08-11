<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_Members extends CI_Model {

    function findAllAccounts($num_row, $from_row) {

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
        if ($this->input->post('submit') && $this->input->post('use_gro_id') == '') {
            $this->session->set_userdata('use_gro_id', '');
        }
        if ($this->session->userdata('use_gro_id') && $this->session->userdata('use_gro_id') != '') {
            $this->db->where('use_gro_id', $this->session->userdata('use_gro_id'));
        }
        //-----------------------
        $this->db->order_by('use_ac_id', 'asc');
        $this->db->where('use_gro_id', '4'); // select only borrower
         $this->db->where('use_status !=', TRASH); 
        $this->db->limit($num_row, $from_row);
        $this->db->from(TABLE_PREFIX . 'users');
//        $this->db->join(TABLE_PREFIX . 'groups', 'use_gro_id=gro_id', 'left');
//        $this->db->group_by('use_id');
        return $this->db->get();
    }
 function findAllAccountsTrash($num_row, $from_row) {

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
        if ($this->input->post('submit') && $this->input->post('use_gro_id') == '') {
            $this->session->set_userdata('use_gro_id', '');
        }
        if ($this->session->userdata('use_gro_id') && $this->session->userdata('use_gro_id') != '') {
            $this->db->where('use_gro_id', $this->session->userdata('use_gro_id'));
        }
        //-----------------------
        $this->db->order_by('use_ac_id', 'asc');
        $this->db->where('use_gro_id', '4'); // select only borrower
         $this->db->where('use_status', TRASH); 
        $this->db->limit($num_row, $from_row);
        $this->db->from(TABLE_PREFIX . 'users');
        $this->db->join(TABLE_PREFIX . 'groups', 'use_gro_id=gro_id', 'left');
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
        // Keep pagination for filter status
        if ($this->input->post('use_name') != '') {
            $this->session->set_userdata('use_name', $this->input->post('use_name'));
        }
        if ($this->input->post('submit') && $this->input->post('use_name') == '') {
            $this->session->set_userdata('use_name', '');
        }
        if ($this->session->userdata('use_name') != '') {
            $this->db->where('use_name', $this->session->userdata('use_name'));
        }
        $this->db->where('use_gro_id', '4'); // select only borrower
        $this->db->from(TABLE_PREFIX . 'users');
//        $this->db->join(TABLE_PREFIX . 'groups', 'use_gro_id=gro_id', 'left');
//        $this->db->group_by('use_ac_id');
        $data = $this->db->get();
        return $data->num_rows();
    }
    
     function countAllAccountsTrash() {

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
        // Keep pagination for filter status
        if ($this->input->post('use_name') != '') {
            $this->session->set_userdata('use_name', $this->input->post('use_name'));
        }
        if ($this->input->post('submit') && $this->input->post('use_name') == '') {
            $this->session->set_userdata('use_name', '');
        }
        if ($this->session->userdata('use_name') != '') {
            $this->db->where('use_name', $this->session->userdata('use_name'));
        }
        $this->db->where('use_gro_id', '4'); // select only borrower
         $this->db->where('use_status', TRASH); // select only borrower
         $this->db->from(TABLE_PREFIX . 'users');
        $data = $this->db->get();
        return $data->num_rows();
    }

    /**
     * Add new group
     * @return true/false
     */
    function add() {
        $this->db->where('use_gro_id', '4'); // select only borrower
        $this->db->from(TABLE_PREFIX . 'users');
        $this->db->select_max('use_ac_id', 'ac_id');
        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            $getRes = $result->result_array();
            $result = $getRes[0]['ac_id'];
        }
        $data = $this->input->post();
        $data['use_gro_id'] = "4"; // group member
        $data['use_ac_id'] = $result + 1;
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

    function getUserById($id) {
        $this->db->where('use_id', $id);
        return $this->db->get(TABLE_PREFIX . 'users');
    }

    function deleteUserById($id = null) {
//        $this->db->where('use_id', $id);
//        return $this->db->delete(TABLE_PREFIX . 'users');
        $this->db->where('use_id', $id);
        $this->db->set('use_modified', 'NOW()', false);
        $this->db->set('use_status',TRASH, false); // go to trusk
        return $this->db->update(TABLE_PREFIX . 'users');
    }
    
     function restoreUserById($id = null) {
        $this->db->where('use_id', $id);
        $this->db->set('use_modified', 'NOW()', false);
        $this->db->set('use_status',1, false); // go to restore
        return $this->db->update(TABLE_PREFIX . 'users');
    }

}
