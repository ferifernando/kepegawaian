<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DbPegawai extends CI_Model
{
	public function read()
	{
		return $this->db->order_by('nama', 'asc')->get('tbl_pegawai')->result();
	}

	public function create($data)
	{
		$this->db->insert('tbl_pegawai', $data);
		return $this->db->insert_id();
	}

	public function update($data)
	{
		$this->db->where('id_pegawai', $this->input->post('id_pegawai'))->update('tbl_pegawai', $data);
		return $this->db->affected_rows();
	}

	public function delete()
	{
		$this->db->where('id_pegawai', $this->input->post('id_pegawai'))->delete('tbl_pegawai');
	}

	public function getById($key)
	{
		$hasil = $this->db->where('id_pegawai', $key)->limit(1)->get('tbl_pegawai');
		if ($hasil->num_rows() > 0) {
			return $hasil->row();
		} else {
			return array();
		}
	}

	// Datatables Serverside
	var $column_order = array('id_pegawai', 'nama');
	var $column_search = array('nama', 'alamat', 'b.jabatan', 'nomor_hp', 'gaji');
	var $order = array('id_pegawai' => 'asc');

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
		$this->db->select('id_pegawai, nama, nomor_hp, jenis_kelamin, alamat, foto, gaji, b.jabatan, mulai_kerja');
		$this->db->from('tbl_pegawai a');
		$this->db->join('tbl_jabatan b', 'b.id_jabatan = a.jabatan');

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
		$this->db->from('tbl_pegawai');
		return $this->db->count_all_results();
	}
}

/* End of file DbPegawai.php */
/* Location: ./application/models/DbPegawai.php */
