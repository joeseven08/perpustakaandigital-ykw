<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Pastikan database dimuat
    }

    // Fungsi untuk mendapatkan semua buku (READ)
    public function get_all_buku() {
        $query = $this->db->get('buku');
        return $query->result(); // Mengembalikan array objek
    }

    // Fungsi untuk mendapatkan buku berdasarkan ID (READ)
    public function get_buku_by_id($id) {
        $query = $this->db->get_where('buku', array('id' => $id));
        return $query->row(); // Mengembalikan satu baris sebagai objek
    }

    // Fungsi untuk menambah buku baru (CREATE)
    public function add_buku($data) {
        return $this->db->insert('buku', $data);
    }

    // Fungsi untuk mengupdate buku (UPDATE)
    public function update_buku($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('buku', $data);
    }

    // Fungsi untuk menghapus buku (DELETE)
    public function delete_buku($id) {
        $this->db->where('id', $id);
        return $this->db->delete('buku');
    }
     // Fungsi untuk mencari buku berdasarkan judul atau penulis
    public function search_buku($keyword) {
        $this->db->like('judul', $keyword); // Mencari di kolom 'judul'
        $this->db->or_like('penulis', $keyword); // Atau mencari di kolom 'penulis'
        $query = $this->db->get('buku');
        return $query->result();
    }
}