<?php
if (!defined('BASEPATH')) exit('No direct allow');

class Bloglar extends AdminController {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		
		$blog = $this->db->get("blogyazilari");
		
		if ($blog->num_rows() > 0) {

			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
				
			$config["base_url"] = base_url("admin/bloglar/index/");
			$config["total_rows"] = $blog->num_rows();
			$config["per_page"] = 10;
			$config["uri_segment"] = 4;
			
			include APPPATH.'/config/admin-pagination.php';			
			$this->pagination->initialize($config);
			
			$_data['_pages'] = $this->pagination->create_links();
			$_data['_blogs'] = $this->db->get('blogyazilari', $config['per_page'], $_page);
			
			$this->render('bloglar_index', $_data);
				
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/bloglar/yaziekle").'"> Blog Yazısı Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
	}

	public function yaziduzelt(){
		$_yaziID = $this->uri->segment(4);
		
		if (!is_numeric($_yaziID) || empty($_yaziID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Düzeltilecek Blog ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/bloglar").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_yazi = $this->db->get_where('blogyazilari', array('id' => $_yaziID));
			if ($_yazi->num_rows() > 0):
				
				$kat = $this->db->get_where('blogkategorileri', array('ust_kategori_id' => '0'));
				$altkat = $this->db->get_where('blogkategorileri', array('ust_kategori_id !=' => '0'));
				
				if ($kat->num_rows() > 0) {
					$_data['_cats'] = $kat;
					$_data['_altkat'] = ($altkat->num_rows() > 0 ) ? $altkat : FALSE;
				} else {
					$_data['_cats'] = FALSE;
					$_data['_altkat'] = FALSE;
				}
				
				$_data['_blog'] = $_yazi->row();
				
				$etiket = $this->db->get_where('etiketler', array('eklenti_id' => $_yaziID, 'tur' => 'blog'));
				
				if ($etiket->num_rows() > 0) {
					
					$_etiketlist = array();
					
					foreach ($etiket->result() as $_row) {
						array_push($_etiketlist, $_row->etiket);
					}
					
					
					$_data['_etiketler'] = implode(',', $_etiketlist);
				} else {
					$_data['_etiketler'] = FALSE;
				}
				
				
				$this->render('bloglar_yaziduzelt', $_data);
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/bloglar/"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}

	
	public function yaziduzeltkaydet(){
		$_yaziID = $this->uri->segment(4);
	
		if (!is_numeric($_yaziID) || empty($_yaziID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Düzeltilecek Blog ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/bloglar").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			$_yazi = $this->db->get_where('blogyazilari', array('id' => $_yaziID));
			if ($_yazi->num_rows() > 0):
		
				$this->form_validation->set_rules('frmYaziBaslik','Yazı Başlığı','trim|required|xss_clean');
				$this->form_validation->set_rules('frmYaziOzet','Yazı Özeti','trim|required|xss_clean');
				$this->form_validation->set_rules('frmYaziIcerik','Yazı İçeriği','trim|required|xss_clean');
				//$this->form_validation->set_rules('frmKategoriler','Yazı Kategorisi','trim|required|xss_clean');
				$this->form_validation->set_rules('frmEtiket','Yazı Etiketi','trim|required|xss_clean');
				
				if ($this->form_validation->run() !== FALSE) {
						
					$baslik = $this->input->post('frmYaziBaslik');
					$ozet = $this->input->post('frmYaziOzet');
					$icerik = ckeditor_html_clear($this->input->post('frmYaziIcerik'));
					$durum = $this->input->post('frmDurum');
					$resimKullan = $this->input->post('frmResimKullan');
					$kategoriler = json_encode($this->input->post('kategori'));
					$etiketler = $this->input->post('frmEtiket');
						
					//resim kullan aktifse
					if ($resimKullan == 'Evet') {
						//upload ayarları
						$config['allowed_types'] = 'gif|jpeg|jpg|png';
						$config['upload_path'] = BLOG_UPLOAD_PATH;
						//upload sınıfı
						$this->load->library('upload', $config);
				
						//resim yüklenirse
						if ($this->upload->do_upload('frmYaziResim')) {
								
							$upData = $this->upload->data();
							//resim adresi
							$image = base_url(BLOG_UPLOAD_PATH.'/'.$upData['file_name']);
							//resim yüklenmezse hata versin
						} else {
							$_data['e'] = (object) array('durum' => 'hata', 'type' => 'uploadform', 'mesaj' => '<b><a href="'.base_url("admin/bloglar").'"> Geri Dön </a></b>');
							$this->render('errorpage', $_data);
						}
					}
						
					//resim kontrolü ...
					$image = (!empty($image)) ? $image : $_yazi->row()->image;
						
					$update = $this->db->update('blogyazilari', array(
							'baslik' => $baslik,
							'ozet' => $ozet,
							'icerik' => $icerik,
							'durum' => $durum,
							'kategori_id' => $kategoriler,
							'image' => $image,
							'tarih' => tarih(),
							'yazar' => uyebilgisi('kullaniciadi'),
							'hit' => 0,
							'seo_keys' => $etiketler,
							'seo_desc' => $ozet,
							'seo_title' => $baslik
					), array('id' => $_yaziID));
						
					if ($update) {
				
						//etiketler siliniyor
						$this->db->delete('etiketler', array('eklenti_id' => $_yaziID, 'tur' => 'blog'));
						
						//etiketler parçalanıyor..
						$etiketler = explode(',', $etiketler);
						
						//yeni etiketler ekleniyor...
						foreach ($etiketler as $etiket) {
							$this->db->insert('etiketler', array('eklenti_id' => $_yaziID, 'etiket' => $etiket, 'tur' => 'blog'));
						}
				
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Güncellendi. <b><a href="'. base_url('admin/bloglar') .'">Geri Dön</a></b>');
						$this->render('errorpage', $_data);
				
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Güncellenemedi. <b><a href="'. base_url('admin/bloglar') .'">Geri Dön</a></b>');
						$this->render('errorpage', $_data);
					}
				
				
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. base_url('admin/bloglar') .'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				}
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/bloglar"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	
	public function yaziekle(){
		$kat = $this->db->get_where('blogkategorileri', array('ust_kategori_id' => '0'));
		$altkat = $this->db->get_where('blogkategorileri', array('ust_kategori_id !=' => '0'));
		
		if ($kat->num_rows() > 0) {
			$_data['_cats'] = $kat;
			$_data['_altkat'] = ($altkat->num_rows() > 0 ) ? $altkat : FALSE;
		} else {
			$_data['_cats'] = FALSE;
			$_data['_altkat'] = FALSE;
		}
		
		$this->render('bloglar_yaziekle', $_data);
	}
	
	public function yazikaydet(){
		$this->form_validation->set_rules('frmYaziBaslik','Yazı Başlığı','trim|required|xss_clean');
		$this->form_validation->set_rules('frmYaziOzet','Yazı Özeti','trim|required|xss_clean');
		$this->form_validation->set_rules('frmYaziIcerik','Yazı İçeriği','trim|required|xss_clean');
		//$this->form_validation->set_rules('frmKategoriler','Yazı Kategorisi','trim|required|xss_clean');
		$this->form_validation->set_rules('frmEtiket','Yazı Etiketi','trim|required|xss_clean');
		
		if ($this->form_validation->run() !== FALSE) {
			
			$baslik = $this->input->post('frmYaziBaslik');
			$ozet = $this->input->post('frmYaziOzet');
			$icerik = ckeditor_html_clear($this->input->post('frmYaziIcerik'));
			$durum = $this->input->post('frmDurum');
			$resimKullan = $this->input->post('frmResimKullan');
			$kategoriler = json_encode($this->input->post('kategori'));
			$etiketler = $this->input->post('frmEtiket');
			
			//resim kullan aktifse
			if ($resimKullan == 'Evet') {
				//upload ayarları
				$config['allowed_types'] = 'gif|jpeg|jpg|png';
				$config['upload_path'] = BLOG_UPLOAD_PATH;
				//upload sınıfı
				$this->load->library('upload', $config);
				
				//resim yüklenirse
				if ($this->upload->do_upload('frmYaziResim')) {
					
					$upData = $this->upload->data();
					//resim adresi
					$image = base_url(BLOG_UPLOAD_PATH.'/'.$upData['file_name']);
				//resim yüklenmezse hata versin	
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'uploadform', 'mesaj' => '');
					$this->render('errorpage', $_data);
				}
			}
			
			//resim kontrolü ...
			$image = (!empty($image)) ? $image : NULL;
			
			$insert = $this->db->insert('blogyazilari', array(
					'baslik' => $baslik,
					'ozet' => $ozet,
					'icerik' => $icerik,
					'durum' => $durum,
					'kategori_id' => $kategoriler,
					'image' => $image,
					'tarih' => time(),
					'yazar' => uyebilgisi('kullaniciadi'),
					'hit' => 0,
					'seo_keys' => $etiketler,
					'seo_desc' => $ozet,
					'seo_title' => $baslik
					));
			
			if ($insert) {
				
				//post ID alınıyor..
				$postID = $this->db->insert_id();
				
				//etiketler ekleniyor...
				$expEtiket = explode(',', $etiketler);
				foreach ($expEtiket as $etiket) {
					$this->db->insert('etiketler', array('eklenti_id' => $postID, 'etiket' => $etiket, 'tur' => 'blog'));
				}
				
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Eklendi. <b><a href="'. base_url('admin/bloglar/yaziekle') .'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
				
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Eklenemedi. <b><a href="'. base_url('admin/bloglar/yaziekle') .'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			}
				
				
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. base_url('admin/bloglar/yaziekle') .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		}

	}
	
	public function yazisil(){
		$_yaziID = $this->uri->segment(4);
	
		if (!is_numeric($_yaziID) || empty($_yaziID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Blog ID\'sine Erişilemedi..! <b><a href="'. base_url('admin/bloglar') .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			if ($this->db->get_where('blogyazilari', array('id' =>$_yaziID))->num_rows() > 0):
		
				$_delete = $this->db->delete('blogyazilari', array("id" => $_yaziID));
			
				if ($_delete > 0) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <a href="' .base_url("admin/bloglar"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <a href="' .base_url("admin/bloglar"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/bloglar"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}
	
	public function kategoriler(){
	
		$kats = $this->db->get("blogkategorileri");
		
		if ($kats->num_rows() > 0) {

			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
						
			$config["base_url"] = base_url("admin/bloglar/kategoriler");
			$config["total_rows"] = $kats->num_rows();
			$config["per_page"] = 20;
			$config["uri_segment"] = 4;

			include APPPATH.'/config/admin-pagination.php';
		
			$_data['_cats'] = $this->db->get("blogkategorileri", $config["per_page"], $_page);
			
			$this->pagination->initialize($config);

            $_data['_pages'] = $this->pagination->create_links();

			$this->render('bloglar_kategoriler', $_data);
			
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/bloglar/kategoriekle").'"> Kategori Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);	
		}
	}
	
	public function kategoriekle(){
		$_ustkat = $this->db->query("SELECT * FROM blogkategorileri WHERE ust_kategori_id = 0");
		$_altkat = $this->db->query("SELECT * FROM blogkategorileri WHERE ust_kategori_id != 0");
			
		if ($_ustkat != FALSE || $_altkat != FALSE) {
			$_data["_ustkat"] = $_ustkat;
			$_data["_altkat"] = $_altkat;
			$this->render('bloglar_kategoriekle', $_data);
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/bloglar/kategoriekle").'"> Kategori Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}

	}
	
	public function kategorikaydet(){
		$this->form_validation->set_rules('frmKategoriAdi','Kategori Adı','trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s alanını boş bırakamazsınız');
		
		if ($this->form_validation->run() !== FALSE) {
			
			$_kategoriAdi = $this->input->post('frmKategoriAdi', TRUE);
			$_kategoriValue = $this->input->post('frmUstKategori', TRUE);
            $_seotitle = $this->input->post('seotitle');
            $_seokeys = $this->input->post('seokeys');
            $_seodesc = $this->input->post('seodesc');
				
			$_kaydet = $this->db->insert('blogkategorileri', array("kategori_adi" => $_kategoriAdi, "ust_kategori_id" => $_kategoriValue, 'seo_title' => $_seotitle, 'seo_keys' => $_seokeys, 'seo_desc' => $_seodesc));

			if ($_kaydet) {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kategori Eklendi.. <b><a href="'.base_url("admin/bloglar/kategoriekle").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kategori Eklenemedi. <b><a href="'.base_url("admin/bloglar/kategoriekle").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
			$this->render('errorpage', $_data);
		}
		
	}
	
	
	public function kategorisil(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Kategori ID\'sine Erişilemedi..! <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$kategori = $this->db->get_where('blogkategorileri', array('id' => $_KategoriID));
			
			if ($kategori->num_rows() > 0): 

				$_delete = $this->db->delete('blogkategorileri', array("id" => $_KategoriID));
				
				if ($_delete > 0) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}
	
	public function kategoriduzelt(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Kategori ID\'sine Erişilemedi..! <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$_kategori = $this->db->get_where('blogkategorileri', array('id' => $_KategoriID));
			
			if ($_kategori->num_rows() > 0):
			
				$_ustkat = $this->db->query("SELECT * FROM blogkategorileri WHERE ust_kategori_id = 0");
				$_altkat = $this->db->query("SELECT * FROM blogkategorileri WHERE ust_kategori_id != 0");
				$_data["_ustkat"] = $_ustkat;
				$_data["_altkat"] = $_altkat;
				$_data['_kategori'] = $_kategori;
				$this->render('bloglar_kategoriduzelt', $_data);
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/bloglar/kategoriler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}
	
	
	public function kategoriduzeltkaydet(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Silinecek Kategori ID\'sine Erişilemedi..! <b><a href="'. base_url('admin/bloglar/kategoriler') .'">Geri Dön</a></b>');
			$this->render('errorpage', $_data);
		else:
			$_kategori = $this->db->get_where('blogkategorileri', array('id' => $_KategoriID));
			
			if ($_kategori->num_rows() > 0):
		
				$this->form_validation->set_rules('frmKategoriAdi','Kategori Adı','trim|required|xss_clean');
				$this->form_validation->set_message('required', '%s alanını boş bırakamazsınız');
			
				if ($this->form_validation->run() !== FALSE) {
						
					$_kategoriAdi = $this->input->post('frmKategoriAdi', TRUE);
					$_kategoriValue = $this->input->post('frmUstKategori', TRUE);
                    $_seotitle = $this->input->post('seotitle');
                    $_seokeys = $this->input->post('seokeys');
                    $_seodesc = $this->input->post('seodesc');
				
					$_kaydet = $this->db->update('blogkategorileri', array("kategori_adi" => $_kategoriAdi, "ust_kategori_id" => $_kategoriValue, 'seo_title' => $_seotitle, 'seo_keys' => $_seokeys, 'seo_desc' => $_seodesc), array('id' => $_KategoriID));
			
					if ($_kaydet) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kategori Düzeltildi..! <b><a href="'.base_url("admin/bloglar/kategoriler").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kategori Düzeltilemedi..! <b><a href="'.base_url("admin/bloglar/kategoriler").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					}
						
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
					$this->render('errorpage', $_data);
				}
		
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kategori Bulanamadı..! <b><a href="'.base_url("admin/bloglar/kategoriler").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	
}

?>