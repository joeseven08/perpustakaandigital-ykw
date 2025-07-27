<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Buku_model'); // Muat model Buku_model
        $this->load->helper('url'); // Muat URL helper
        $this->load->library('form_validation'); // Muat library form validation
        $this->load->library('session'); // Pastikan library session dimuat

        // Cek apakah pengguna sudah login, jika tidak, arahkan ke halaman login
        // Logika ini dipindahkan ke dalam __construct()
        if (!$this->session->userdata('logged_in')) {
            redirect('auth'); // Arahkan ke controller Auth (halaman login)
        }
    }

    // Menampilkan daftar buku (READ All)
    public function index() {
        $search_query = $this->input->get('search'); // Ambil kata kunci pencarian dari URL

        if (!empty($search_query)) {
            // Jika ada kata kunci pencarian, panggil metode pencarian di model
            $data['buku'] = $this->Buku_model->search_buku($search_query);
        } else {
            // Jika tidak ada kata kunci pencarian, ambil semua buku
            $data['buku'] = $this->Buku_model->get_all_buku();
        }

        $this->load->view('buku/list_buku', $data);
    }

    // Menampilkan form tambah buku atau memproses penambahan (CREATE)
    public function add() {
        // Aturan validasi form
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required');
        $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|numeric');
        $this->form_validation->set_rules('isbn', 'ISBN', 'required|is_unique[buku.isbn]'); // is_unique untuk memastikan ISBN unik

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau form belum disubmit, tampilkan form
            $this->load->view('buku/form_buku'); // View untuk form tambah/edit
        } else {
            // Jika validasi berhasil, proses penambahan data
            $data = array(
                'judul' => $this->input->post('judul'),
                'penulis' => $this->input->post('penulis'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'isbn' => $this->input->post('isbn')
            );
            $this->Buku_model->add_buku($data);
            redirect('buku'); // Redirect kembali ke daftar buku
        }
    }

    // Menampilkan form edit buku atau memproses pengeditan (UPDATE)
    public function edit($id) {
        // Aturan validasi form
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required');
        $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|numeric');
        // Untuk ISBN, kita perlu memeriksa keunikan kecuali jika ISBN itu sendiri tidak berubah
        $original_isbn = $this->Buku_model->get_buku_by_id($id)->isbn;
        if ($this->input->post('isbn') != $original_isbn) {
            $this->form_validation->set_rules('isbn', 'ISBN', 'required|is_unique[buku.isbn]');
        } else {
            $this->form_validation->set_rules('isbn', 'ISBN', 'required');
        }


        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau form belum disubmit, tampilkan form dengan data buku
            $data['buku'] = $this->Buku_model->get_buku_by_id($id);
            if (empty($data['buku'])) {
                show_404(); // Tampilkan halaman 404 jika buku tidak ditemukan
            }
            $this->load->view('buku/form_buku', $data); // View untuk form tambah/edit
        } else {
            // Jika validasi berhasil, proses update data
            $data = array(
                'judul' => $this->input->post('judul'),
                'penulis' => $this->input->post('penulis'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'isbn' => $this->input->post('isbn')
            );
            $this->Buku_model->update_buku($id, $data);
            redirect('buku'); // Redirect kembali ke daftar buku
        }
    }

    // Menghapus buku (DELETE)
    public function delete($id) {
        $this->Buku_model->delete_buku($id);
        redirect('buku'); // Redirect kembali ke daftar buku
    }
}
