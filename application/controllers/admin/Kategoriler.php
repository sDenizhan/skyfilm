<?php
if (!defined('BASEPATH')) exit('No direct allow');

class Kategoriler extends AdminController {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
	
		$kategoriler = $this->db->get("kategoriler");
		
		if ($kategoriler->num_rows() > 0) {
			
			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/kategoriler/index/");
			$config["total_rows"] = $kategoriler->num_rows();
			$config["per_page"] = 15;
			$config["uri_segment"] = 4;

			include VIEWPATH.'dash/'. $this->getTheme() .'/views/config/pagination.php';
		
			$this->db->order_by('kategori_adi', 'ASC');
			$_cats = $this->db->get('kategoriler', $config['per_page'], $_page);

			$this->pagination->initialize($config);

			$_data['_pages'] = $this->pagination->create_links();
			$_data['_cats'] = $_cats;
			
			$this->render('kategoriler_index', $_data);
			
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/kategoriler/kategoriekle").'"> Kategori Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);	
		}
	}
	
	public function kategoriekle(){
		$_ustkat = $this->db->query("SELECT * FROM kategoriler WHERE parent_id = 0");
		$_altkat = $this->db->query("SELECT * FROM kategoriler WHERE parent_id != 0");
			
		if ($_ustkat != FALSE || $_altkat != FALSE) {
			$_data["_ustkat"] = $_ustkat;
			$_data["_altkat"] = $_altkat;
			$this->render('kategoriler_kategoriekle', $_data);
		} else {
			$this->render('kategoriler_kategoriekle');
		}

	}
	
	public function kategorikaydet(){
		$this->form_validation->set_rules('frmKategoriAdi','Kategori Adı','trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s alanını boş bırakamazsınız');
		
		if ($this->form_validation->run() !== FALSE) {
			
			$_kategoriAdi = $this->input->post('frmKategoriAdi', TRUE);
			$_kategoriValue = $this->input->post('frmUstKategori', TRUE);
            $_seoTitle = $this->input->post('seotitle', TRUE);
			$_seoKeys = $this->input->post('seokeys', TRUE);
            $_seoDesc = $this->input->post('seodesc', TRUE);

            if ($_kategoriValue == 0)
            {
                $_UstKategoriID = 0;
                $_UstKategoriAdi = $_kategoriAdi;
            }
            else
            {
                $_parcala = explode("|", $_kategoriValue);
                $_UstKategoriID = $_parcala[0];
                $_UstKategoriAdi = $_parcala[1];
            }

			$_kaydet = $this->db->insert('kategoriler',
                    array(
                        "kategori_adi" => $_kategoriAdi,
                        "parent_id" => $_UstKategoriID,
                        "parent_adi" => $_UstKategoriAdi,
                        'seo_title' => $_seoTitle,
                        'seo_keys' => $_seoKeys,
                        'seo_desc' => $_seoDesc,
                        'uri' => seoURL($_kategoriAdi)
                    ));

			if ($_kaydet) {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kategori Eklendi.. <b><a href="'.base_url("admin/kategoriler").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);	
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kategori Eklenemedi. <b><a href="'.base_url("admin/kategoriler/kategoriekle").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);	
			}
			
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'.base_url("admin/kategoriler").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);	
		}
		
	}
	
	
	public function kategorisil(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			redirect("admin/panel");
		else:
			$kategori = $this->db->get_where('kategoriler', array('id' => $_KategoriID));
			
			if ($kategori->num_rows() > 0): 
				
			
				$_delete = $this->db->delete('kategoriler', array("id" => $_KategoriID));
				
				if ($_delete > 0) :
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <a href="' .base_url("admin/kategoriler"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <a href="' .base_url("admin/kategoriler"). '"> Geri Dön </a>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/kategoriler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	}
	
	public function kategoriduzelt(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			redirect("admin/panel");
		else:
			$_kategori = $this->db->get_where('kategoriler', array('id' => $_KategoriID));
			if ($_kategori != FALSE):
				$_ustkat = $this->db->query("SELECT * FROM kategoriler WHERE parent_id = 0");
				$_altkat = $this->db->query("SELECT * FROM kategoriler WHERE parent_id != 0");
				$_data["_ustkat"] = $_ustkat;
				$_data["_altkat"] = $_altkat;
				$_data['_kategori'] = $_kategori;
				$this->render('kategoriler_duzelt', $_data);
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("admin/kategoriler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
		
	}
	
	
	public function kategoriduzeltkaydet(){
		$_KategoriID = $this->uri->segment(4);
		
		if (!is_numeric($_KategoriID) || empty($_KategoriID) ):
			redirect("admin/panel");
		else:
			$_kategori = $this->db->get_where('kategoriler', array('id' => $_KategoriID));
			if ($_kategori != FALSE):
		
				$this->form_validation->set_rules('frmKategoriAdi','Kategori Adı','trim|required|xss_clean');
				$this->form_validation->set_message('required', '%s alanını boş bırakamazsınız');
			
				if ($this->form_validation->run() !== FALSE) {
						
					$_kategoriAdi = $this->input->post('frmKategoriAdi', TRUE);
					$_kategoriValue = $this->input->post('frmUstKategori', TRUE);
					$_seoTitle = $this->input->post('seotitle', TRUE);
					$_seoKeys = $this->input->post('seokeys', TRUE);
		            $_seoDesc = $this->input->post('seodesc', TRUE);
						
					$_parcala = explode("|", $_kategoriValue);
					$_UstKategoriID = $_parcala[0];
					$_UstKategoriAdi = $_parcala[1];
						
					$_kaydet = $this->db->update('kategoriler',
                        array(
                            "kategori_adi" => $_kategoriAdi,
                            "parent_id" => $_UstKategoriID,
                            "parent_adi" => $_UstKategoriAdi,
                            'seo_title' => $_seoTitle,
                            'seo_keys' => $_seoKeys,
                            'seo_desc' => $_seoDesc
                        ), array('id' => $_KategoriID));
			
					if ($_kaydet) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kategori Düzeltildi..! <b><a href="'.base_url("admin/kategoriler").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kategori Düzeltilemedi..! <b><a href="'.base_url("admin/kategoriler").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					}
						
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/kategoriler").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				}
		
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <a href="' .base_url("AdminKategoriler"). '"> Geri Dön </a>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	
}

?>