<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('level') || ($this->session->userdata('level') > 2)) {
            show_404();
        }
        $this->load->model('DbJabatan', 'jabatan');
    }

    public function index()
    {
        $data['title']      = "Daftar Jabatan";
        $data['breadcrumb'] = "Kelola Data Jabatan";
        $data['js']         = "jabatan";
        $data['pages']      = "admin/pages/jabatan";
        $this->load->view('admin/app-template', $data);
    }

    public function read()
    {
        $dt     = $this->jabatan->dTablesList();
        $no     = $_POST['start'] + 1;
        $data   = array();
        foreach ($dt as $value) {
            $edit       = "<a href='javascript:void(0)' data-id='" . $value->id_jabatan . "' class='btn btn-icon btn-secondary edit-jabatan'><i class='fas fa-edit'></i></a>";
            $delete     = "<a href='javascript:void(0)' data-id='" . $value->id_jabatan . "' class='btn btn-icon btn-danger hapus-jabatan'><i class='fas fa-trash'></i></a>";

            $tbody      = array();
            $tbody[]    = '<center>' . $no++ . '.</center>';
            $tbody[]    = $value->jabatan;
            $tbody[]    = '<b>Rp. ' . number_format($value->gaji, 2, ",", ".") . '</b>';
            $tbody[]    = '<center>' . $edit . '</center>';
            $data[]     = $tbody;
        }

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $this->jabatan->count_all(),
            "recordsFiltered"   => $this->jabatan->count_filtered(),
            "data"              => $data
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('jabatan',    'jabatan',    'trim|required');
        $this->form_validation->set_rules('gaji',       'gaji',    'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'         => true,
                'jabatan_error' => form_error('jabatan'),
                'gaji_error'    => form_error('gaji'),
            );
            echo json_encode($array);
        } else {
            $status     = false;
            $error      = false;
            $id         = $this->input->post('id_jabatan');
            $jabatan    = $this->input->post('jabatan');
            $gaji       = str_replace('.', '', $this->input->post('gaji'));
            $admin      = $this->session->userdata('id_admin');
            $datetime   = date('Y-m-d H:i:s');

            if ($id != NULL) {
                $data = array(
                    'jabatan'     => $jabatan,
                    'gaji'        => $gaji,
                    'edited_by'   => $admin,
                    'edited_at'   => $datetime
                );
                $this->jabatan->update($data);
                $status = true;
            } else {
                $data = array(
                    'jabatan'     => $jabatan,
                    'gaji'        => $gaji,
                    'created_by'  => $admin,
                    'created_at'  => $datetime
                );
                $this->jabatan->create($data);
                $status = true;
            }
            echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
        }
    }

    public function getById()
    {
        $id     = $this->input->post('id');
        $data   = $this->jabatan->getById($id);
        $dt     = array('success' => false, 'data' => '');
        if ($data) {
            $dt = array('success' => true, 'data' => $data);
        }
        echo json_encode($dt);
    }

    public function hapus()
    {
        $this->jabatan->delete();
        echo json_encode(array("status" => TRUE));
    }
}
