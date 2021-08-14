<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('level')) {
            show_404();
        }
        $this->load->model('DbPegawai', 'pegawai');
        $this->load->model('DbJabatan', 'jabatan');
    }

    public function index()
    {
        $data['title']      = "Daftar Pegawai";
        $data['breadcrumb'] = "Kelola Data Pegawai";
        $data['js']         = "pegawai";
        $data['css']        = "pegawai";
        $data['jabatan']    = $this->jabatan->read();;
        $data['pages']      = "admin/pages/pegawai";
        $this->load->view('admin/app-template', $data);
    }

    public function read()
    {
        $dt = $this->pegawai->dTablesList();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($dt as $value) {
            $edit = "<a href='javascript:void(0)' data-id='" . $value->id_pegawai . "' class='btn btn-icon btn-flat btn-secondary mr-1 edit-pegawai'><i class='fas fa-edit'></i></a>";
            $delete = "<a href='javascript:void(0)' data-id='" . $value->id_pegawai . "' class='btn btn-icon btn-flat btn-danger hapus-pegawai'><i class='fas fa-trash'></i></a>";
            $gender = $value->jenis_kelamin == 0 ? '<i class="fas fa-mars fa-sm text-info mx-1"></i> Laki-Laki' : '<i class="fas fa-venus fa-sm text-danger mx-1"></i> Perempuan';

            $tbody = array();
            $tbody[] = '<center>' . $no++ . '.</center>';
            if ($value->foto) {
                $tbody[] = '<center><a href="' . base_url('assets/images/pegawai/' . $value->foto) . '" target="_blank">
                <img src="' . base_url('assets/images/pegawai/' . $value->foto) . '" class="img-responsive" style="height:100px"/></a></center>';
            } else {
                $tbody[] = '<center><img src="' . base_url('assets/images/no-image.png') . '" class="img-responsive" style="height:100px"/></center>';
            }
            $tbody[] = $value->nama . '<br>Nomor HP: <b>' . $value->nomor_hp . '</b><br>Jenis Kelamin: ' . $gender;
            $tbody[] = 'Jabatan: <b>' . $value->jabatan . '</b><br>Gaji: <b>Rp. ' . number_format($value->gaji, 2, ",", ".") . '</b><br>Mulai Kerja: <b>' . date_indo($value->mulai_kerja) . '</b>';
            $tbody[] = '<span class="limitbaris">' . $value->alamat . '</span>';
            $tbody[] = '<center>' . $edit . ' ' . $delete . '</center>';
            $data[] = $tbody;
        }

        $output = array(
            "draw"                => $_POST['draw'],
            "recordsTotal"         => $this->pegawai->count_all(),
            "recordsFiltered"     => $this->pegawai->count_filtered(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('jabatan',        'jabatan',          'trim|required');
        $this->form_validation->set_rules('nama',           'nama',             'trim|required');
        $this->form_validation->set_rules('alamat',         'alamat',           'trim|required');
        $this->form_validation->set_rules('jenis_kelamin',  'jenis kelamin',    'trim|required');
        $this->form_validation->set_rules('nomor_hp',       'nomor HP',         'trim|required');
        $this->form_validation->set_rules('mulai_kerja',    'mulai kerja',      'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'   => true,
                'jabatan_error' => form_error('jabatan'),
                'nama_error' => form_error('nama'),
                'alamat_error' => form_error('alamat'),
                'jenis_kelamin_error' => form_error('jenis_kelamin'),
                'nomor_hp_error' => form_error('nomor_hp'),
                'mulai_kerja_error' => form_error('mulai_kerja'),
            );
            echo json_encode($array);
        } else {
            $status = false;
            $error = false;
            $id = $this->input->post('id_pegawai');
            $jabatan = $this->input->post('jabatan');
            $nama = $this->input->post('nama');
            $alamat = $this->input->post('alamat');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $nomor_hp = $this->input->post('nomor_hp');
            $mulai_kerja = $this->input->post('mulai_kerja');
            $admin = $this->session->userdata('id_admin');
            $datetime = date('Y-m-d H:i:s');

            if ($id != NULL) {
                $data = array(
                    'jabatan'       => $jabatan,
                    'nama'          => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'nomor_hp'      => $nomor_hp,
                    'mulai_kerja'   => $mulai_kerja,
                    'alamat'        => $alamat,
                    'edited_by'     => $admin,
                    'edited_at'     => $datetime,
                );

                if (!empty($_FILES['foto']['name'])) {
                    $upload = $this->_do_upload();

                    //delete file
                    $pegawai = $this->pegawai->getById($id);
                    if ($pegawai->foto != null && is_file('assets/images/pegawai/' . $pegawai->foto)) {
                        unlink('assets/images/pegawai/' . $pegawai->foto);
                    }
                    $data['foto'] = $upload;
                }

                $this->pegawai->update($data);
                $status = true;
            } else {
                $data = array(
                    'jabatan'       => $jabatan,
                    'nama'          => $nama,
                    'jenis_kelamin' => $jenis_kelamin,
                    'nomor_hp'      => $nomor_hp,
                    'mulai_kerja'   => $mulai_kerja,
                    'alamat'        => $alamat,
                    'created_by'    => $admin,
                    'created_at'    => $datetime,
                );

                if (!empty($_FILES['foto']['name'])) {
                    $upload = $this->_do_upload();
                    $data['foto'] = $upload;
                }

                $this->pegawai->create($data);
                $status = true;
            }
            echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
        }
    }

    private function _do_upload()
    {
        $string  = preg_replace("/[^a-zA-Z0-9 &%|{.}=,?!*()-_+$@;<>']/", '', set_value('nama'));
        $trim    = trim($string);
        $pre_url = strtolower(str_replace(" ", "-", $trim));
        $pre_url = str_replace(",", "", $pre_url);
        $pre_url = str_replace(".", "", $pre_url);
        $pre_url = str_replace("?", "", $pre_url);
        $pre_url = str_replace("!", "", $pre_url);
        $filename = $pre_url;

        $config['upload_path']          = 'assets/images/pegawai/';
        $config['allowed_types']        = 'jpeg|jpg|png';
        $config['max_size']             = 2048; // set max size allowed in kilobyte
        $config['max_width']            = 2048; // set max width image allowed
        $config['max_height']           = 2048; // set max height allowed
        $config['file_name']             = $filename . mt_rand(1000, 9999);

        $this->load->library('upload');
        $this->upload->initialize($config);
        if ($this->upload->do_upload('foto')) {
            $gbr = $this->upload->data();

            // compress image
            $source = 'assets/images/pegawai/' . $gbr['file_name'];
            list($width, $height) = getimagesize($source);
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'assets/images/pegawai/' . $gbr['file_name'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['quality'] = '80%';
            $config['width'] = $width - 1;
            $config['height'] = $height - 1;
            $config['new_image'] = 'assets/images/pegawai/' . $gbr['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

            $foto = $gbr['file_name'];
            return $foto;
        } else {
            $array = array(
                'error'   => true,
                'failed_upload' => true,
            );
            echo json_encode($array);
            exit();
        }
    }

    public function getByid()
    {
        $id = $this->input->post('id');
        $data = $this->pegawai->getById($id);
        $dt = array('success' => false, 'data' => '');
        if ($data) {
            $dt = array('success' => true, 'data' => $data);
        }
        echo json_encode($dt);
    }

    public function hapus()
    {
        $id = $this->input->post('id_pegawai');
        $pegawai = $this->pegawai->getById($id);
        if ($pegawai->foto) {
            if ($pegawai->foto != null && is_file('assets/images/pegawai/' . $pegawai->foto)) {
                unlink('assets/images/pegawai/' . $pegawai->foto);
            }
        }
        $this->pegawai->delete();
        echo json_encode(array("status" => TRUE));
    }
}
