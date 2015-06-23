<?php

class Administrator extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->_is_logged_in();
		$this->load->model('modeladmin');
	}
	
	public function index(){
		redirect('administrator/produk');
	}
	
	//MODUL PRODUK
	public function produk(){
		
		if($this->uri->segment(3)==""){
			$offset=0;
		}else{
			$offset=$this->uri->segment(3);
		}
		$limit = 15;
		$data['produk'] = $this->modeladmin->getAllProduk($offset, $limit);
		$data['count'] = $this->modeladmin->getAllProduk_count();
	
		$config = array();
		$config['base_url'] = base_url(). 'administrator/produk/';
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;
		
		$config['first_tag_open'] = '<li>';
		$config['first_link'] = 'First';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href>';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_link'] = 'Last';
		$config['last_tag_close'] = '</li>';
		$config['total_rows'] = $data['count'];
		$this->pagination->initialize($config);
		$this->session->set_userdata('row', $this->uri->segment(3));
		
		$data['judul'] = "Produk | Administrator";
 		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/produk/produk', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function tambah_produk(){
		$data['error'] = "";
		$data['kategori'] = $this->modeladmin->getKategoriProduk();
		$data['judul'] = "Tambah Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/produk/tambah_produk', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_tambah_produk(){
	$this->form_validation->set_rules('nama_produk','Nama Produk', 'required|xss_clean|max_length[255]|trim|strip_tags');
	$this->form_validation->set_rules('deskripsi','Deskripsi', 'required|xss_clean|max_length[1000]');
	$this->form_validation->set_rules('id_kategori','Kategori', 'required|xss_clean|trim|strip_tags');
	if($this->form_validation->run() == TRUE){ 
		   
		  $config['upload_path'] = 'upload/produk/';
          $config['allowed_types'] = 'gif|jpeg|png|jpg';
          $config['max_size'] = 2000;
          $config['max_height'] = 2000;
          $config['max_width'] = 2000;
		  $config['encrypt_name'] = TRUE;
		  $this->upload->initialize($config);
			if ($this->upload->do_upload('gambar_produk')) {
				$dok = $this->upload->data();
				$this->_resize_produk($dok['file_name']);
				$this->_create_thumb_produk($dok['file_name']);
			$foto = $dok['file_name'];
			$kategori = $this->input->post('id_kategori');
			$input_nama_produk= $this->input->post('nama_produk');
			$input_deskripsi= $this->input->post('deskripsi');
			$ganti = array("'");
			$oleh = "&#039;";
			$nama_produk = str_replace($ganti, $oleh, $input_nama_produk);
			$url_title = url_title($nama_produk);
			$deskripsi = str_replace($ganti, $oleh, $input_deskripsi);
			
			$this->modeladmin->inputProduk($nama_produk, $url_title, $deskripsi, $foto, $kategori);
			
			$this->session->set_flashdata('info', "Produk berhasil ditambahkan.");
			redirect('administrator/produk');
			}else{
				$data['error'] = $this->upload->display_errors();
			}	
		} 
		$data['error'] = $this->upload->display_errors();
		$data['kategori'] = $this->modeladmin->getKategoriProduk();
		$data['judul'] = "Tambah Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/produk/tambah_produk', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function edit_produk($id){
		$data['kategori'] = $this->modeladmin->getKategoriProduk();
		$data['edit_produk'] = $this->modeladmin->getEditProduk($id)->row();
		$data['judul'] = "Tambah Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/produk/edit_produk', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_edit_produk(){
	$id = $this->input->post('id_produk');
	
	$this->form_validation->set_rules('nama_produk','Nama Produk', 'required|xss_clean|max_length[255]|trim|strip_tags');
	$this->form_validation->set_rules('deskripsi','Deskripsi', 'required|xss_clean|max_length[1000]');
	$this->form_validation->set_rules('id_kategori','Kategori', 'required|xss_clean|trim|strip_tags');
	if($this->form_validation->run() == TRUE){ 
		   
		   $config['upload_path'] = 'upload/produk/';
           $config['allowed_types'] = 'gif|jpeg|png|jpg';
           $config['max_size'] = 2000;
           $config['max_height'] = 2000;
           $config['max_width'] = 2000;
		   $config['encrypt_name'] = TRUE;
		   $this->upload->initialize($config);
		   
			if ($this->upload->do_upload('gambar_produk')) {
			//unlink gambar
			$query = $this->modeladmin->getEditProduk($id)->row();						
			if ($query->file_name != "" || $query->file_name != NULL ){
				if(file_exists('./upload/produk/' . $query->file_name) || file_exists('./upload/produk/thumb/'. $query->file_name)) {
					$do = unlink('./upload/produk/'. $query->file_name); //menghapus gambar semula di folder
					$do = unlink('./upload/produk/thumb/'. $query->file_name); //menghapus gambar semula di folder
				}
			} 
				$dok = $this->upload->data();
				$this->_resize_produk($dok['file_name']);
				$this->_create_thumb_produk($dok['file_name']);
				
			$foto = $dok['file_name'];
			
			$kategori = $this->input->post('id_kategori');
			$input_nama_produk= $this->input->post('nama_produk');
			$input_deskripsi= $this->input->post('deskripsi');
			$ganti = array("'");
			$oleh = "&#039;";
			
			$nama_produk = str_replace($ganti, $oleh, $input_nama_produk);
			$url_title = url_title($nama_produk);
			$deskripsi = str_replace($ganti, $oleh, $input_deskripsi);
			
			$this->modeladmin->updateProdukFoto($id, $nama_produk, $url_title, $deskripsi, $foto, $kategori);
			
			$this->session->set_flashdata('info', "Produk berhasil diubah, gambar diubah.");
			redirect('administrator/produk');
			}else{
				$kategori = $this->input->post('id_kategori');
				$input_nama_produk= $this->input->post('nama_produk');
				$input_deskripsi= $this->input->post('deskripsi');
				$ganti = array("'");
				$oleh = "&#039;";
				
				$nama_produk = str_replace($ganti, $oleh, $input_nama_produk);
				$url_title = url_title($nama_produk);
				$deskripsi = str_replace($ganti, $oleh, $input_deskripsi);
				
				$this->modeladmin->updateProdukTanpaFoto($id, $nama_produk, $url_title, $deskripsi, $kategori);
				
				$this->session->set_flashdata('info', "Produk berhasil diubah, gambar tidak diubah.");
				redirect('administrator/produk');
			}	
		}  
		$data['kategori'] = $this->modeladmin->getKategoriProduk();
		$data['edit_produk'] = $this->modeladmin->getEditProduk($id)->row();
		$data['judul'] = "Tambah Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/produk/edit_produk', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function hapus_produk($id){
		$query = $this->modeladmin->getEditProduk($id)->row();						
			if ($query->file_name != "" || $query->file_name != NULL ){
				if(file_exists('./upload/produk/' . $query->file_name) || file_exists('./upload/produk/thumb/'. $query->file_name)) {
					$do = unlink('./upload/produk/'. $query->file_name); //menghapus gambar semula di folder
					$do = unlink('./upload/produk/thumb/'. $query->file_name); //menghapus gambar semula di folder
				}
			} 
		$this->modeladmin->hapus_produk($id);
		$this->session->set_flashdata('info', "Produk berhasil dihapus.");
		redirect('administrator/produk');
	}
	
	//END MODUL Produk
	
	//MODUL Kategori
	public function kategori_produk(){
		$data['kategori'] = $this->modeladmin->getAllKategoriProduk();
		$data['judul'] = "Kategori Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/kategori/kategori', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_tambah_kategori(){
		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|xss_clean|max_length[255]|trim|strip_tags');
		if($this->form_validation->run() == TRUE){
			$this->modeladmin->inputKategoriProduk($this->input->post('nama_kategori'));
		$this->session->set_flashdata('info', "Kategori Produk berhasil ditambahkan.");
		redirect('administrator/kategori_produk');
		}
		$data['kategori'] = $this->modeladmin->getAllKategoriProduk();
		$data['judul'] = "Kategori Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/kategori/kategori', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function edit_kategori_produk($id){
		$data['edit_kategori'] = $this->modeladmin->getEditKategoriProduk($id)->row();
		$data['judul'] = "Edit Kategori Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/kategori/edit_kategori', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_edit_kategori_produk(){
	$id = $this->input->post('id');
		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|xss_clean|max_length[255]|trim|strip_tags');
		if($this->form_validation->run() == TRUE){
			$this->modeladmin->updateKategoriProduk($this->input->post('id'), $this->input->post('nama_kategori'));
		$this->session->set_flashdata('info', "Kategori Produk berhasil diubah.");
		redirect('administrator/kategori_produk');
		}
		$data['edit_kategori'] = $this->modeladmin->getEditKategoriProduk($id)->row();
		$data['judul'] = "Edit Kategori Produk | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/kategori/edit_kategori', $data);
		$this->load->view('template/admin/footer');
		
	}
	
	public function hapus_kategori($id){
		$hapus = $this->modeladmin->hapusKategori($id);
		
		$query = $this->modeladmin->getProdukByIdKategori($id)->row();						
			if ($query->file_name != "" || $query->file_name != NULL ){
				if(file_exists('./upload/produk/' . $query->file_name) || file_exists('./upload/produk/thumb/'. $query->file_name)) {
					$do = unlink('./upload/produk/'. $query->file_name); //menghapus gambar semula di folder
					$do = unlink('./upload/produk/thumb/'. $query->file_name); //menghapus gambar semula di folder
				}
			} 
		$this->modeladmin->hapus_produk($id);
		$this->session->set_flashdata('info', "Kategori berhasil dihapus.");
		redirect('administrator/kategori_produk');
		
	}
	//END MODUL Kategori
	
	//MODUL BANNER
	public function banner(){
		$data['error'] = "";
		$data['banner'] = $this->modeladmin->getAllBanner();
		$data['judul'] = "Banner | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/banner/banner', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_tambah_banner(){
		   $config['upload_path'] = 'upload/banner/';
           $config['allowed_types'] = 'gif|jpeg|png|jpg';
           $config['max_size'] = 2000;
           $config['max_height'] = 2000;
           $config['max_width'] = 2000;
		   $config['encrypt_name'] = TRUE;
		   $this->upload->initialize($config);
		   
			if ($this->upload->do_upload('gambar_banner')) {
				$dok = $this->upload->data();
				$this->_resize_banner($dok['file_name']);
				$this->_create_thumb_banner($dok['file_name']);
				
			$foto = $dok['file_name'];
			$this->modeladmin->inputBanner($foto);
			
			$this->session->set_flashdata('info', "Banner berhasil ditambahkan.");
			redirect('administrator/banner');
			}else{
				$data['error'] = $this->upload->display_errors();
				$data['banner'] = $this->modeladmin->getAllBanner();
				$data['judul'] = "Banner | Administrator";
				$this->load->view('template/admin/header', $data);
				$this->load->view('template/admin/nav');
				$this->load->view('admin/banner/banner', $data);
				$this->load->view('template/admin/footer');
			}
	}
	
	public function hapus_banner($id){
		$query = $this->modeladmin->getBannerById($id)->row();
		if ($query->file_name != "" || $query->file_name != NULL ){
				if(file_exists('./upload/banner/' . $query->file_name) || file_exists('./upload/banner/thumb/'. $query->file_name)) {
					$do = unlink('./upload/banner/'. $query->file_name); //menghapus gambar semula di folder
					$do = unlink('./upload/banner/thumb/'. $query->file_name); //menghapus gambar semula di folder
				}
			} 
		$this->modeladmin->hapusbanner($id);
		$this->session->set_flashdata('info', "Banner berhasil dihapus.");
		redirect('administrator/banner');
	}
	
	public function edit_status_banner($id, $status){
		if($status == FALSE){
			$this->modeladmin->updateStatusBanner($id, TRUE);
			$this->session->set_flashdata('info', "Banner berhasil ditampilkan.");
			redirect('administrator/banner');
		}else{
			$this->modeladmin->updateStatusBanner($id, FALSE);
			$this->session->set_flashdata('info', "Banner berhasil disembunyikan.");
			redirect('administrator/banner');
		}
	}
	//END MODUL BANNER
	
	//MODUL PROFIL
	public function profil($kategori){
		$data['profil'] = $this->modeladmin->getProfilByCategory($kategori)->row();
		$data['menuprofil'] = $this->modeladmin->getAllProfilCategori()->result();
		$data['judul'] = "Profil | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/profil/profil', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function submit_edit_profil(){
		$kategori = $this->input->post('kategori_profil');
		$id = $this->input->post('id');
		$input_deskripsi= $this->input->post('deskripsi');
		$ganti = array("'");
		$oleh = "&#039;";
		$deskripsi = str_replace($ganti, $oleh, $input_deskripsi);
		
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|xss_clean|max_length[1000]');
		if($this->form_validation->run() == TRUE){
			$this->modeladmin->updateProfil($id, $kategori, $deskripsi);
			$this->session->set_flashdata('info', "Profil berhasil diubah.");
			redirect('administrator/profil/'. $kategori);
		}
		$data['profil'] = $this->modeladmin->getProfilByCategory($kategori)->row();
		$data['menuprofil'] = $this->modeladmin->getAllProfilCategori()->result();
		$data['judul'] = "Profil | Administrator";
		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/profil/profil', $data);
		$this->load->view('template/admin/footer');
		
	}
	//END MODUL PROFIL
	
	//GANTI PASSWORD
	//MODUL GANTI PASSWORD
	function ganti_password(){
		if (!$this->tank_auth->is_logged_in()) {								// not logged in or not activated
			redirect('/auth/login/');

		} else {
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password'))) {	// success
					$this->_show_message($this->lang->line('auth_message_password_changed'));
				} else {														// fail
					$errors = $this->tank_auth->get_error_message();
					foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
				}
			}
			//$this->load->view('auth/change_password_form', $data);
			$data['judul'] = "Admin | Ganti Password";
			$this->load->view('template/admin/header', $data);
			$this->load->view('template/admin/nav');
			$this->load->view('admin/setting/ganti_password', $data);
			$this->load->view('template/admin/footer');
		}
	}
	//END GANTI PASSWORD
	
	//MODUL CONTACT US
	public function contact_us(){
		
		if($this->uri->segment(3)==""){
			$offset=0;
		}else{
			$offset=$this->uri->segment(3);
		}
		$limit = 30;
		$data['contact_us'] = $this->modeladmin->getAllContactUs($offset, $limit);
		$data['count'] = $this->modeladmin->getAllContactUs_count()->num_rows;
	
		$config = array();
		$config['base_url'] = base_url(). 'administrator/contact_us/';
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;
		$config['num_links'] = 5;
		
		$config['first_tag_open'] = '<li>';
		$config['first_link'] = 'First';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href>';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_link'] = 'Last';
		$config['last_tag_close'] = '</li>';
		$config['total_rows'] = $data['count'];
		$this->pagination->initialize($config);
		$this->session->set_userdata('row', $this->uri->segment(3));
		
		$data['judul'] = "Produk | Administrator";
 		$this->load->view('template/admin/header', $data);
		$this->load->view('template/admin/nav');
		$this->load->view('admin/banner/contact_us', $data);
		$this->load->view('template/admin/footer');
	}
	
	public function hapus_contact($id){
		$this->modeladmin->hapus_contact($id);
		$this->session->set_flashdata('info', "Contact berhasil dihapus.");
		redirect('administrator/contact_us');
	}
	public function hapus_contact_all(){
		$this->modeladmin->hapus_contact_all();
		$this->session->set_flashdata('info', "Contact berhasil dikosongkan.");
		redirect('administrator/contact_us');
	}
	
	//END MODUL CONTACT US
	
	//METHOD METHOD
	
	public function _resize_produk($fulpat) {
        $config['source_image'] = './upload/produk/' . $fulpat;
        $config['new_image'] = './upload/produk/' . $fulpat;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 900;
        $config['height'] = 600;
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
	
	public function _create_thumb_produk($fulpet) {
        $config['source_image'] = './upload/produk/' . $fulpet;
        $config['new_image'] = './upload/produk/thumb/' . $fulpet;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        //$config['height'] = 200;
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo "tum" . $this->image_lib->display_errors();
        }
    }
	
	public function _resize_banner($fulpat) {
        $config['source_image'] = './upload/banner/' . $fulpat;
        $config['new_image'] = './upload/banner/' . $fulpat;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 900;
        $config['height'] = 600;
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
	
	public function _create_thumb_banner($fulpet) {
        $config['source_image'] = './upload/banner/' . $fulpet;
        $config['new_image'] = './upload/banner/thumb/' . $fulpet;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 200;
        //$config['height'] = 200;
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            echo "tum" . $this->image_lib->display_errors();
        }
    }
	
	//SHOW MESSAGE TANK AUTH
	function _show_message($message){
		$this->session->set_flashdata('info', "Password admin berhasil diganti.");
		redirect('administrator/ganti_password');
	}
	 
	public function _is_logged_in(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('auth/login');
		}
	}
	
	public function abus(){
		for($i = 1; $i<540; $i++){
			$this->db->query("INSERT INTO contact_us VALUE('', 'Jon Jen$i ', 'jon_jen_ini_email$i@test.com','iciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperi', NOW())");
		}
	}	
}