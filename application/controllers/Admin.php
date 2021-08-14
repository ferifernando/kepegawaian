<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('level') || $this->session->userdata('level') > 2) {
            show_404();
        }
        $this->load->model('DbAdmin', 'admin');
        $this->load->model('DbLevel', 'level');
    }

    public function index()
    {
        $data['title']      = "Daftar Admin";
        $data['breadcrumb'] = "Kelola Data Admin";
        $data['js']         = "admin";
        $data['level']      = $this->level->read();
        $data['pages']      = "admin/pages/admin";
        $this->load->view('admin/app-template', $data);
    }

    public function read()
    {
        $dt = $this->admin->dTablesList();
        $data = array();
        $no = $_POST['start'] + 1;
        foreach ($dt as $value) {
            $edit = "<a href='javascript:void(0)' data-id='" . $value->id_admin . "' class='btn btn-icon btn-secondary edit-admin'><i class='fas fa-edit'></i></a>";
            $delete = "<a href='javascript:void(0)' data-id='" . $value->id_admin . "' class='btn btn-icon btn-danger hapus-admin'><i class='fas fa-trash'></i></a>";

            $tbody = array();
            $tbody[] = '<center>' . $no++ . '.</center>';
            $tbody[] = '<b>' . strtoupper($value->nama) . '</b><br><span class="text-dark text-xs">username: </span><code>' . $value->username . '</code><br><span class="text-dark text-xs">kontak: </span><code>' . $value->hp . '</code>';
            $tbody[] = $value->level;
            if ($value->id_level > $this->session->userdata('level')) {
                $tbody[] = '<center>' . $edit . ' ' . $delete . '</center>';
            } else {
                $tbody[] = '<center>' . $edit . '</center>';
            }
            $data[] = $tbody;
        }

        $output = array(
            "draw"                => $_POST['draw'],
            "recordsTotal"        => $this->admin->count_all(),
            "recordsFiltered"     => $this->admin->count_filtered(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function simpan()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('id_level',   'level admin',      'trim|numeric|required');
        $this->form_validation->set_rules('nama',       'nama',             'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('hp',         'nomor HP',         'trim|numeric|required');

        if (!$this->input->post('id_admin')) { // tambah
            $this->form_validation->set_rules('username',   'username',             'trim|required|is_unique[tbl_admin.username]');
            $this->form_validation->set_rules('password',   'password',             'trim|required|min_length[4]|max_length[32]');
            $this->form_validation->set_rules('repassword', 'ulangi password',      'trim|required|matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'   => true,
                'id_level_error' => form_error('id_level'),
                'hp_error' => form_error('hp'),
                'email_error' => form_error('email'),
                'username_error' => form_error('username'),
                'repassword_error' => form_error('repassword'),
                'password_error' => form_error('password'),
                'nama_error' => form_error('nama'),
            );
            echo json_encode($array);
        } else {
            $status = false;
            $error = false;
            $id = $this->input->post('id_admin');
            $id_level = $this->input->post('id_level');
            $username = $this->input->post('username');
            $nama = $this->input->post('nama');
            $hp = $this->input->post('hp');
            $password = $this->input->post('password');
            $admin = $this->session->userdata('id_admin');
            $datetime = date('Y-m-d H:i:s');

            if ($id != NULL) {
                $data = array(
                    'level'       => $id_level,
                    'username'    => $username,
                    'nama'        => $nama,
                    'hp'          => $hp,
                    'edited_by'   => $admin,
                    'edited_at'   => $datetime
                );
                if ($password != null || $password != '') {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                $this->admin->update($data);
                $status = true;
            } else {
                $data = array(
                    'level'       => $id_level,
                    'username'    => $username,
                    'nama'        => $nama,
                    'hp'          => $hp,
                    'password'    => $password,
                    'created_by'  => $admin,
                    'created_at'  => $datetime
                );
                $this->admin->create($data);
                $status = true;
            }
            echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
        }
    }

    public function getById()
    {
        $id = $this->input->post('id');
        $data = $this->admin->getById($id);
        $dt = array('success' => false, 'data' => '');
        if ($data) {
            $dt = array('success' => true, 'data' => $data);
        }
        echo json_encode($dt);
    }

    public function hapus()
    {
        $id = $this->input->post('id_admin');
        $profil = $this->admin->getById($id);
        if ($profil->foto != null && is_file('./assets/images/admin/' . $profil->foto)) {
            unlink('./assets/images/admin/' . $profil->foto);
        }
        $this->admin->delete();
        echo json_encode(array("status" => TRUE));
    }

    public function profil()
    {
        $id = $this->session->userdata('id_admin');
        $data['title']  = "Profil";
        $data['breadcrumb'] = "Edit Profil";
        $data['js']     = "admin";
        $data['profil'] = $this->admin->getById($id);
        $data['pages']  = "admin/pages/profil";
        $this->load->view('admin/app-template', $data);
    }

    public function updateProfil()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('nama',       'nama', 'trim|required');
        $this->form_validation->set_rules('hp',         'nomor HP', 'trim|required|numeric');
        $this->form_validation->set_rules('password',   'konfirmasi password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'           => true,
                'nama_error'      => form_error('nama'),
                'hp_error'        => form_error('hp'),
                'password_error'  => form_error('password'),
            );
            echo json_encode($array);
        } else {
            $status = false;
            $error = false;
            $id = $this->session->userdata('id_admin');
            $hp = $this->input->post('hp');
            $nama = $this->input->post('nama');
            $password = $this->input->post('password');
            $cek = $this->admin->getById($id);

            if (password_verify($password, $cek->password)) {
                if ($_FILES['gambar']['name']) {
                    $string  = preg_replace("/[^a-zA-Z0-9 &%|{.}=,?!*()-_+$@;<>']/", '', set_value('nama'));
                    $trim    = trim($string);
                    $pre_url = strtolower(str_replace(" ", "-", $trim));
                    $pre_url = str_replace(",", "", $pre_url);
                    $pre_url = str_replace(".", "", $pre_url);
                    $pre_url = str_replace("?", "", $pre_url);
                    $pre_url = str_replace("!", "", $pre_url);
                    $filename = $pre_url;

                    $config['upload_path'] = './assets/images/admin/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $filename . mt_rand(1000, 9999);
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('gambar')) {
                        $error = true;
                    } else {
                        $profil = $this->admin->getById($id);
                        if ($profil->foto != null && is_file('./assets/images/admin/' . $profil->foto)) {
                            unlink('./assets/images/admin/' . $profil->foto);
                        }
                        $gbr = $this->upload->data();
                        $this->load->library('image_lib');
                        $gambar = $gbr['file_name'];
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = './assets/images/admin/' . $gambar;
                        $imageSize = $this->image_lib->get_image_properties($config['source_image'], TRUE);
                        $newSize = min($imageSize['height'], $imageSize['width']);
                        $config['new_image'] = './assets/images/admin/' . $gambar;
                        $config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE;
                        $config['quality'] = '60%';
                        $config['y_axis'] = ($imageSize['height'] - $newSize) / 2;
                        $config['x_axis'] = ($imageSize['width'] - $newSize) / 2;
                        $config['height'] = $newSize;
                        $config['width'] = $newSize;
                        $this->image_lib->initialize($config);
                        $this->image_lib->crop();
                        $this->image_lib->resize();

                        $data = array(
                            'foto'      => $gambar,
                            'nama'      => $nama,
                            'hp'        => $hp,
                            'edited_by' => $id,
                            'edited_at' => date('Y-m-d H:i:s'),
                        );
                        $update = $this->admin->update($data);
                        if ($update) {
                            $userdata = [
                                'foto'  => $gambar ?? $this->session->userdata('foto'),
                                'nama'  => $nama,
                                'hp'    => $hp,
                            ];
                            $this->session->set_userdata($userdata);
                        }
                    }
                } else {
                    $status = true;
                    $data = array(
                        'nama'      => $nama,
                        'hp'        => $hp,
                        'edited_by' => $id,
                        'edited_at' => date('Y-m-d H:i:s'),
                    );
                    $update = $this->admin->update($data);
                    if ($update) {
                        $userdata = [
                            'foto'  => $gambar ?? $this->session->userdata('foto'),
                            'nama'  => $nama,
                            'hp'    => $hp,
                        ];
                        $this->session->set_userdata($userdata);
                    }
                }
                echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
            } else {
                $array = array(
                    'error'   => true,
                    'wrongpass' => true,
                );
                echo json_encode($array);
            }
        }
    }

    public function gantiPassword()
    {
        $data['title'] = "Ganti Password";
        $data['breadcrumb'] = "Ganti Password";
        $data['js']    = "admin";
        $data['pages'] = "admin/pages/ganti-password";
        $this->load->view('admin/app-template', $data);
    }

    public function updatePassword()
    {
        $this->form_validation->set_error_delimiters('<span class="text-xs text-danger">', '</span>');
        $this->form_validation->set_rules('npass',      'password',             'trim|required|min_length[5]');
        $this->form_validation->set_rules('repass',     'ulangi password',      'trim|required|matches[npass]');
        $this->form_validation->set_rules('password',   'password saat ini',    'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $array = array(
                'error'         => true,
                'pass_error'    => form_error('password'),
                'npass_error'   => form_error('npass'),
                'repass_error'  => form_error('repass'),
            );
            echo json_encode($array);
        } else {
            $status = false;
            $error = false;
            $id = $this->input->post('id_admin');
            $password = $this->input->post('password');
            $new_pass = $this->input->post('npass');

            $cek = $this->admin->getById($id);
            if (password_verify($password, $cek->password)) {
                $data = array(
                    'password'  => password_hash($new_pass, PASSWORD_DEFAULT),
                    'edited_by' => $id,
                    'edited_at' => date('Y-m-d H:i:s'),
                );
                $this->admin->update($data);
                $status = true;
                echo json_encode(array("status" => $status, 'data' => $data, 'error' => $error));
            } else {
                $array = array(
                    'error'   => true,
                    'wrongpass' => true,
                );
                echo json_encode($array);
            }
        }
    }

    public function removeAvatar()
    {
        $id = $this->input->post('id_admin');
        $profil = $this->admin->getById($id);
        $folder = './assets/images/admin/';
        $file_path = $folder . $profil->foto;
        if ($profil->foto != null && is_file($file_path)) {
            unlink($file_path);
        }

        $data = array(
            'foto'      => NULL,
            'edited_by' => $id,
            'edited_at' => date('Y-m-d H:i:s'),
        );
        $update = $this->admin->update($data);
        if ($update) {
            $userdata = [
                'foto'  => NULL,
            ];
            $this->session->set_userdata($userdata);
        }
        echo json_encode(array("status" => TRUE));
    }
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
