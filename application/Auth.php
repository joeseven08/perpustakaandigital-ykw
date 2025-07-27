<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model'); // Muat model User_model
        $this->load->library('form_validation'); // Muat library form validation
        $this->load->library('session'); // Muat library session
        $this->load->helper('url'); // Muat URL helper
    }

    // Metode default untuk controller Auth (menampilkan form login)
    public function index() {
        // Jika pengguna sudah login, arahkan ke halaman utama buku
        if ($this->session->userdata('logged_in')) {
            redirect('buku'); // Arahkan ke controller Buku
        }
        // Muat view login
        $this->load->view('auth/login');
    }

    // Metode untuk memproses permintaan login
    public function login() {
        // Jika pengguna sudah login, arahkan ke halaman utama buku
        if ($this->session->userdata('logged_in')) {
            redirect('buku');
        }

        // Aturan validasi form login
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form login dengan error
            $this->load->view('auth/login');
        } else {
            // Ambil input username dan password dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Dapatkan data pengguna dari model berdasarkan username
            $user = $this->User_model->get_user_by_username($username);

            // Verifikasi password
            if ($user && password_verify($password, $user->password)) {
                // Login berhasil
                // Siapkan data pengguna untuk disimpan di session
                $user_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'logged_in' => TRUE
                );
                // Set data session
                $this->session->set_userdata($user_data);

                // Arahkan ke halaman daftar buku setelah login berhasil
                redirect('buku');
            } else {
                // Login gagal
                // Set flashdata error untuk ditampilkan di view login
                $this->session->set_flashdata('error', 'Username atau password salah.');
                // Kembali ke halaman login
                redirect('auth');
            }
        }
    }

    // Metode untuk memproses permintaan logout
    public function logout() {
        // Hapus data session yang terkait dengan login
        $this->session->unset_userdata(array('user_id', 'username', 'logged_in'));
        // Hancurkan seluruh session
        $this->session->sess_destroy();
        // Arahkan kembali ke halaman login
        redirect('auth');
    }

    // Metode untuk menampilkan form registrasi dan memproses registrasi pengguna baru
    public function register() {
        // Jika pengguna sudah login, arahkan ke halaman utama buku
        if ($this->session->userdata('logged_in')) {
            redirect('buku');
        }

        // Aturan validasi form registrasi
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');


        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau form belum disubmit, tampilkan form registrasi
            $this->load->view('auth/register');
        } else {
            // Jika validasi berhasil, proses registrasi pengguna baru
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'), // Password akan di-hash di model
                'email' => $this->input->post('email')
            );

            if ($this->User_model->register_user($data)) {
                // Registrasi berhasil
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth'); // Arahkan ke halaman login
            } else {
                // Registrasi gagal
                // Tambahkan logging untuk melihat error database
                log_message('error', 'Registrasi pengguna gagal. Query error: ' . $this->db->error()['message']);
                $this->session->set_flashdata('error', 'Registrasi gagal. Username atau Email mungkin sudah terdaftar, atau ada masalah database. Silakan coba lagi.');
                redirect('auth/register'); // Kembali ke halaman registrasi
            }
        }
    }
}
