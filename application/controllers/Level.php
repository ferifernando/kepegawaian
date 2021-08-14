<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('level') || ($this->session->userdata('level') > 2)) {
            show_404();
        }
        $this->load->model('DbLevel', 'level');
    }

    public function index()
    {
        $data['title']      = "Daftar Level";
        $data['breadcrumb'] = "Kelola Data Level";
        $data['js']         = "level";
        $data['pages']      = "admin/pages/level";
        $this->load->view('admin/app-template', $data);
    }

    public function read()
    {
        $dt = $this->level->dTablesList();
        $no = $_POST['start'] + 1;
        $data = array();
        foreach ($dt as $value) {
            $edit = "<a href='javascript:void(0)' data-id='" . $value->id_level . "' class='btn btn-icon btn-secondary edit-level'><i class='fas fa-edit'></i></a>";
            $delete = "<a href='javascript:void(0)' data-id='" . $value->id_level . "' class='btn btn-icon btn-danger hapus-level'><i class='fas fa-trash'></i></a>";
            $tbody = array();
            $tbody[] = '<center>' . $no++ . '.</center>';
            $tbody[] = $value->level;
            $tbody[] = '<center>' . $edit . '</center>';
            $data[] = $tbody;
        }

        $output = array(
            "draw"                => $_POST['draw'],
            "recordsTotal"         => $this->level->count_all(),
            "recordsFiltered"     => $this->level->count_filtered(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('level',    'level',    'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'   => true,
                'level_error' => form_error('level'),
            );
            echo json_encode($array);
        } else {
            $status = false;
            $error = false;
            $id = $this->input->post('id_level');
            $level = $this->input->post('level');
            $admin = $this->session->userdata('id_admin');
            $datetime = date('Y-m-d H:i:s');

            if ($id != NULL) {
                $data = array(
                    'level'       => $level,
                    'edited_by'   => $admin,
                    'edited_at'   => $datetime
                );
                $this->level->update($data);
                $status = true;
            } else {
                $data = array(
                    'level'       => $level,
                    'created_by'  => $admin,
                    'created_at'  => $datetime
                );
                $this->level->create($data);
                $status = true;
            }
            echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
        }
    }

    public function getById()
    {
        $id = $this->input->post('id');
        $data = $this->level->getById($id);
        $dt = array('success' => false, 'data' => '');
        if ($data) {
            $dt = array('success' => true, 'data' => $data);
        }
        echo json_encode($dt);
    }

    public function hapus()
    {
        $this->level->delete();
        echo json_encode(array("status" => TRUE));
    }
}
