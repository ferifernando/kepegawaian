<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DbJabatan extends CI_Model
{
    public function read()
    {
        return $this->db->query('CALL selectJabatan()')->result();
    }

    public function create($data)
    {
        $this->db->insert('tbl_jabatan', $data);
        return $this->db->insert_id();
    }

    public function update($data)
    {
        $this->db->where('id_jabatan', $this->input->post('id_jabatan'))->update('tbl_jabatan', $data);
        return $this->db->affected_rows();
    }

    public function delete()
    {
        $this->db->where('id_jabatan', $this->input->post('id_jabatan'))->delete('tbl_jabatan');
    }

    public function getById($key)
    {
        $hasil = $this->db->where('id_jabatan', $key)->limit(1)->get('tbl_jabatan');
        if ($hasil->num_rows() > 0) {
            return $hasil->row();
        } else {
            return array();
        }
    }

    // Datatables Serverside
    var $column_order = array('id_jabatan', 'jabatan', 'gaji');
    var $column_search = array('id_jabatan', 'jabatan', 'gaji');
    var $order = array('id_jabatan' => 'asc');

    public function dTablesList()
    {
        $this->List();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get()->result();
    }

    private function List()
    {
        $this->db->select('id_jabatan, jabatan, gaji');
        $this->db->from('tbl_jabatan');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered()
    {
        $this->List();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('tbl_jabatan');
        return $this->db->count_all_results();
    }
}

/* End of file Mopd.php */
/* Location: ./application/models/Mopd.php */
