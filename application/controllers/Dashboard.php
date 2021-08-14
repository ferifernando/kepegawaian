<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('level')) {
            show_404();
        }
    }

    public function index()
    {
        $data["title"] = "Dashboard";
        $data['breadcrumb'] = "Selamat Datang";
        $data["pages"] = "admin/pages/dashboard";
        $this->load->view("admin/app-template", $data);
    }
}
