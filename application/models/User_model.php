<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mendapatkan pengguna berdasarkan username
    public function get_user_by_username($username) {
        $query = $this->db->get_where('users', array('username' => $username));
        return $query->row(); // Mengembalikan satu baris sebagai objek
    }

    // Fungsi untuk mendaftarkan pengguna baru
    public function register_user($data) {
        // Pastikan password sudah di-hash sebelum disimpan ke database
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('users', $data);
    }
}
