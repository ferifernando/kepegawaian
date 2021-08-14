<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('level')) {
            redirect(site_url('dashboard'));
        }
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title']      = "Halaman Login - Sistem Kepegawaian";
            $this->load->view('admin/pages/login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');
        $user       = $this->db->get_where('tbl_admin', ['username' => $username])->row_array();
        $data       = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
        );
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id_admin'    => $user['id_admin'],
                    'nama'        => $user['nama'],
                    'hp'          => $user['hp'],
                    'username'    => $user['username'],
                    'level'       => $user['level'],
                    'foto'        => $user['foto']
                ];
                $this->session->set_userdata($data);
                redirect('dashboard');
            } else {
                // password salah
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-light font-weight-bold" role="alert">username atau password salah</div>');
                $this->session->set_flashdata($data);
                redirect('login');
            }
        } else {
            // user tidak ditemukan
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-light font-weight-bold" role="alert">username atau password salah</div>');
            $this->session->set_flashdata($data);
            redirect('login');
        }
    }

    function out()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
