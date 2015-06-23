<?php 

class Modeladmin extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	//QUERY PRODUK
	public function getKategoriProduk(){
		$query = $this->db->query("SELECT * FROM kategori_produk ORDER BY nama_kategori ASC");
		return $query;
	}
	
	public function getAllProduk($offset, $limit){
		$query = $this->db->query("
			SELECT p.id as id_produk, p.nama_produk, p.url_title, p.deskripsi, p.file_name, p.id_kategori_produk, p.created_at,
			kp.id, kp.nama_kategori
			FROM produk as p, kategori_produk as kp
			WHERE p.id_kategori_produk = kp.id
			ORDER BY created_at DESC 
			LIMIT $offset, $limit
		");
		return $query;
	}
	
	public function getAllProduk_count(){
		$query = $this->db->query("
			SELECT * FROM produk
		");
		return $query->num_rows();
	}
	
	public function inputProduk($nama_produk, $url_title, $deskripsi, $foto, $kategori){
		$query = $this->db->query("INSERT INTO produk VALUES('', '$nama_produk', '$url_title', '$deskripsi', '$foto', '$kategori', NOW())");
	}
	
	public function getEditProduk($id){
		$query = $this->db->query("
					SELECT p.id as id_produk, p.nama_produk, p.url_title, p.deskripsi, p.file_name, p.id_kategori_produk, p.created_at,
					kp.id, kp.nama_kategori
					FROM produk as p, kategori_produk as kp
					WHERE p.id_kategori_produk = kp.id
					AND p.id = '$id'
					LIMIT 1
					");
		return $query;
	}
	
	public function updateProdukTanpaFoto($id, $nama_produk, $url_title, $deskripsi, $kategori){
		$query = $this->db->query("UPDATE produk 
									SET nama_produk = '$nama_produk', 
									url_title ='$url_title', 
									deskripsi = '$deskripsi', 
									id_kategori_produk = '$kategori', 
									created_at = NOW()
									WHERE id = '$id'
								");
	}
	
	public function updateProdukFoto($id, $nama_produk, $url_title, $deskripsi, $foto, $kategori){
		$query = $this->db->query("UPDATE produk 
									SET nama_produk = '$nama_produk', 
									url_title ='$url_title', 
									deskripsi = '$deskripsi', 
									id_kategori_produk = '$kategori', 
									file_name = '$foto', 
									created_at = NOW()
									WHERE id = '$id'
								");
	}
	
	public function hapus_produk($id){
		$this->db->query("DELETE FROM produk WHERE id = '$id' ");
	}
	//END QUERY PRODUK
	
	//QUERY KATEGORI PRODUK
	public function getAllKategoriProduk(){
		$query = $this->db->query("SELECT * FROM kategori_produk ORDER BY created_at DESC");
		return $query;
	}
	
	public function inputKategoriProduk($kategori_produk){
		$this->db->query("INSERT INTO kategori_produk VALUES('', '$kategori_produk', NOW())");
	}
	public function getEditKategoriProduk($id){
		$query = $this->db->query("SELECT * FROM kategori_produk WHERE id = '$id'");
		return $query;
	}
	
	public function updateKategoriProduk($id, $nama_kategori){
		$query = $this->db->query("UPDATE kategori_produk 
									SET nama_kategori = '$nama_kategori',
									created_at = NOW()
									WHERE id = '$id'
									
								");
	}
	
	public function getProdukByIdKategori($id){
		$query = $this->db->query("SELECT * FROM produk WHERE id_kategori_produk = '$id'");
		return $query;
	}
	public function hapusKategori($id){
		$query = $this->db->query("DELETE FROM kategori_produk WHERE id = '$id'");
	}
	//END QUERY KATEGORI PRODUK
	
	//QUERY BANNER
	public function getAllBanner(){
		$query = $this->db->query("SELECT * FROM banner ORDER BY created_at DESC");
		return $query;
	}
	
	public function inputBanner($foto){
		$this->db->query("INSERT INTO banner VALUES('', '$foto', '0', NOW() )");
	}
	
	public function hapusbanner($id){
		$this->db->query("DELETE FROM banner WHERE id = '$id'");
	}
	
	public function getBannerById($id){
		$query = $this->db->query("SELECT * FROM banner WHERE id = '$id'");
		return $query;
	}
	
	public function	updateStatusBanner($id, $status){
		$query = $this->db->query("UPDATE banner 
									SET status = '$status',
									created_at = NOW()
									WHERE id = '$id'
								");
	}
	//END QUERY BANNER

	//QUERY PROFIL	
	public function getProfilByCategory($kategori){
		$query = $this->db->query("SELECT * FROM profil WHERE kategori_profil = '$kategori' ");
		return $query;
	}

	public function getAllProfilCategori(){
		$query = $this->db->query("SELECT * FROM profil ORDER BY id ASC");
		return $query;
	}
	
	public function updateProfil($id, $kategori, $deskripsi){
		$query = $this->db->query("
								UPDATE profil SET deskripsi = '$deskripsi'
								WHERE id = '$id'
								AND kategori_profil = '$kategori'
								");
	}
	//END QUERY PROFIL
	
	//QUERY CONTACT US
	public function getAllContactUs($offset, $limit){
		$query = $this->db->query("SELECT * FROM contact_us ORDER BY created_at DESC LIMIT $offset, $limit");
		return $query;
	}
	public function getAllContactUs_count(){
		$query = $this->db->query("SELECT * FROM contact_us");
		return $query;
	}
	
	public function hapus_contact($id){
		$this->db->query("DELETE FROM contact_us WHERE id = '$id' ");
	}
	
	public function hapus_contact_all($id){
		$this->db->query("DELETE FROM contact_us");
	}
	//END QUERY CONTACT US
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}