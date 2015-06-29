<?php
if (!defined('BASEPATH')) exit("Go Home Yanki !!");

class Duyurular extends AdminController {

	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$_news = $this->db->get_where("duyurular");
		
		if ($_news->num_rows() > 0) {

			$_page = $this->uri->segment(4);
			
			if (empty($_page))
			{
				$_page = 0;
			}
			
			$config["base_url"] = base_url("admin/duyurular/index/");
			$config["total_rows"] = $_news->num_rows();
			$config["per_page"] = 25;
			$config["uri_segment"] = 4;
						
			$this->pagination->initialize($config);
			
			$_data['_pages'] = $this->pagination->create_links();
			$_data['_news'] = $this->db->get('duyurular', $config['per_page'], $_page);
			
			$this->render('duyurular_index', $_data);
			
		
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/duyurular/duyuruekle").'"> Duyuru Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
		
	}

    public function filitrele()
    {

        if ($this->input->get())
        {
            $aranan = $this->input->get('aranan');
            $id = $this->input->get('id');
            $siralama = $this->input->get('siralama');

            if (!empty($aranan))
            {
                $this->db->like('baslik', $aranan)->or_like('icerik', $aranan);
            }

            if (!empty($id))
            {
                $this->db->where('id', $id);
            }

            $filmler = $this->db->get('duyurular');

            if ($filmler->num_rows() > 0 )
            {
                $_page = $this->uri->segment(4);

                if (empty($_page))
                {
                    $_page = 0;
                }

                $config["base_url"] = base_url('admin/duyurular/filitrele/?aranan='. $aranan .'&id='. $id .'&siralama='. $siralama);
                $config["total_rows"] = $filmler->num_rows();
                $config["per_page"] = 25;
                $config["uri_segment"] = 4;
                $config["page_query_string"] = TRUE;

                include APPPATH.'/config/admin-pagination.php';

                $this->pagination->initialize($config);

                if (!empty($aranan))
                {
                    $this->db->like('baslik', $aranan)->or_like('icerik', $aranan);
                }
                if (!empty($id))
                {
                    $this->db->where('id = ', $id);
                }
                $this->db->order_by('id', $siralama);

                $films = $this->db->get('duyurular', $config['per_page'], $_page);

                $_data['_news'] = $films;
                $_data['_pages'] = $this->pagination->create_links();

                $this->render('duyurular_index', $_data);
            } else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Aradığınız Kriterlere Uygun Duyuru Bulunamadı..! <b><a href="'.base_url("admin/duyurular").'"> Duyurular </a></b>');
                $this->render('errorpage', $_data);
            }

        }
        else
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'GET Bilgisi Alınamadı..! <b><a href="'.base_url("admin/duyurular").'"> Duyurular </a></b>');
            $this->render('errorpage', $_data);
        }
    }

	function duyuruekle(){
		$this->js['nolink'] = 'jquery.tagsinput.min.js';
		$this->styles = array('jquery.tagsinput.css');
		
		$this->render('duyurular_duyuruekle');
	}
	
	
	function duyurukaydet(){
		$this->form_validation->set_rules('frmHaberBaslik','Haber Başlığı','trim|required|xss_clean');
		$this->form_validation->set_rules('frmHaberIcerik','Haber İçeriği','trim|required|xss_clean');
		$this->form_validation->set_rules('frmEtiket','Etiket','trim|required|xss_clean');
		
		$this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
		
		if ($this->form_validation->run() == FALSE) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
			$this->render('errorpage', $_data);
		} else {
			
			$_haberBaslik = $this->input->post('frmHaberBaslik');
			$_haberIcerik = ckeditor_html_clear($this->input->post('frmHaberIcerik'));
			$_haberTuru = $this->input->post('frmTur');
			$_resimKullan = $this->input->post('frmResimKullan');
			$_haberEtiket = $this->input->post('frmEtiket');
			
			//eğer resim kullan aktif değilse ise normal kayıt
			if ($_resimKullan != 'Evet') {
			
				$_q = $this->db->insert('duyurular', array(
						"baslik" => $_haberBaslik,
						"icerik" => ckeditor_html_clear($_haberIcerik),
						"yazan" => uyebilgisi('kullaniciadi'),
						"tarih" => time(),
						"tur" => $_haberTuru,
						"resim" => base_url()."/others/assets/images/noImage.jpg"
				));
			
				if ($_q) {
					
					$haberID = $this->db->insert_id();
					
					foreach (explode(',', $_haberEtiket) as $etiket) {
						$this->db->insert('etiketler', array('eklenti_id' => $haberID, 'tur' => 'haber', 'etiket' => $etiket ));
					}
					
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Duyuru Eklendi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);

				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru Eklenemedi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				}
			//aktif ise resim yükleme ve normal kayit
			} else {
				$_uploadConfig['upload_path'] = HABER_UPLOAD_PATH;
				$_uploadConfig['allowed_types'] = 'gif|png|jpg|jpeg';
				$_uploadConfig['overwrite'] = FALSE;
				$_uploadConfig['max_size'] = '1024000';
					
				$this->load->library('upload', $_uploadConfig);
					
				if (! $this->upload->do_upload('frmHaberResim')) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'uploadform', 'mesaj' => '');
					$this->render('errorpage', $_data);
				} else {
					$_upload_data = $this->upload->data();
					
					$_q = $this->db->insert('duyurular', array(
							"baslik" => $_haberBaslik,
							"icerik" => ckeditor_html_clear($_haberIcerik),
							"yazan" => uyebilgisi('kullaniciadi'),
							"tarih" => time(),
							"tur" => $_haberTuru,
							"resim" => base_url('others/upload/haber/'. $_upload_data['orig_name'] .'')
					));
					
					if ($_q) {
						$haberID = $this->db->insert_id();
							
						foreach (explode(',', $_haberEtiket) as $etiket) {
							$this->db->insert('etiketler', array('eklenti_id' => $haberID, 'tur' => 'haber', 'etiket' => $etiket ));
						}
							
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Duyuru Eklendi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru Eklenemedi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					}

				}
			}
			
			
			
			
			
		}
	}
	
	function duyurusil(){
		$_newsID = $this->uri->segment(4);
		
		if (!is_numeric($_newsID) || empty($_newsID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			
			$haber = $this->db->get_where('duyurular', array('id' => $_newsID));
			if ( $haber->num_rows() > 0): 
				
				//eğer manşet haber ise resim silinmeli
				if ($haber->row()->tur == 'manset') {
					//dosya adresi kırpılıyor...
					//http://keyfisinema.net/others/upload/haber/image.jpg şelinden
					//others/upload/haber/image.jpg şekline dönüşüyor..
					$image = substr($haber->row()->resim, (int) strlen(base_url()));
					//resim silinyor...
					
					if (stripos($image, 'noImage.jpg') === FALSE)
					{
						@unlink('./'.$image);
					}
					
				}
				
				$_delete = $this->db->delete('duyurular', array("id" => $_newsID));
				
				if ($_delete ) : 
					//etiketler siliniyor..
					$this->db->delete('etiketler', array('eklenti_id' => $_newsID));
				
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);	
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
		endif;
	
	}
	
	function duyuruduzelt(){
		$_newsID = $this->uri->segment(4);
		
		if (!is_numeric($_newsID) || empty($_newsID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			
			$haber = $this->db->get_where('duyurular', array('id' => $_newsID));
			
			if ( $haber->num_rows() > 0):
			
				$_data["_news"] = $haber;
				
				$_etiketler = $this->db->get_where('etiketler', array('eklenti_id' => $_newsID, 'tur' => 'haber'));
				
				if ($_etiketler->num_rows() > 0) {
					
					$_etiket = array();
					
					foreach ($_etiketler->result() as $_et) {
						array_push($_etiket, $_et->etiket);
					}
					$_data['_etiketler'] = implode(',', $_etiket);
				} else {
					$_data['_etiketler'] = FALSE;
				}
						
				$this->js['nolink'] = 'jquery.tagsinput.min.js';
				$this->styles = array('jquery.tagsinput.css');
				
				$this->render('duyurular_duyuruduzelt', $_data);
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("AdminNews").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
			
		endif;			
		
	}
	
	function duyuruduzeltkaydet(){
		$_newsID = $this->uri->segment(4);
		
		if (!is_numeric($_newsID) || empty($_newsID) ):
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru ID Bilgisine Ulaşılamadı. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
			$this->render('errorpage', $_data);
		else:
			
			$haber = $this->db->get_where('duyurular', array('id' => $_newsID));
			
			if ( $haber->num_rows() > 0):
			
				$this->form_validation->set_rules('frmHaberBaslik','Haber Başlığı','trim|required|xss_clean');
				$this->form_validation->set_rules('frmHaberIcerik','Haber İçeriği','trim|required|xss_clean');
				$this->form_validation->set_rules('frmEtiket','Etiket','trim|required|xss_clean');
				
				$this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
				
				if ($this->form_validation->run() == FALSE):
					$this->load->view('admin/ajax_formvalidation_error');
				else:
					
					$_haberBaslik = $this->input->post('frmHaberBaslik');
					$_haberIcerik = ckeditor_html_clear($this->input->post('frmHaberIcerik'));
					$_haberTuru = $this->input->post('frmTur');
					$_resimKullan = $this->input->post('frmResimKullan');
					$_haberEtiket = $this->input->post('frmEtiket');
					
					//eğer resim kullan aktif değilse ise normal kayıt
					if ($_resimKullan != 'Evet') {
					
						$_q = $this->db->update('duyurular', array(
								"baslik" => $_haberBaslik,
								"icerik" => $_haberIcerik,
								"yazan" => uyebilgisi('kullaniciadi'),
								"tarih" => time(),
								"tur" => $_haberTuru,
						), array('id' => $_newsID));
					
						if ($_q) {
							
							$this->db->delete('etiketler', array('eklenti_id' => $_newsID, 'tur' => 'haber'));
							
							foreach (explode(',', $_haberEtiket) as $etiket) {
								$this->db->insert('etiketler', array('eklenti_id' => $_newsID, 'tur' => 'haber', 'etiket' => $etiket ));
							}
							
							$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Duyuru Düzeltildi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
							$this->render('errorpage', $_data);
		
						} else {
							$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru Düzeltilemedi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
							$this->render('errorpage', $_data);
						}
					//aktif ise resim yükleme ve normal kayit
					} else {
											
						$_uploadConfig['upload_path'] = HABER_UPLOAD_PATH;
						$_uploadConfig['allowed_types'] = 'gif|png|jpg|jpeg';
						$_uploadConfig['overwrite'] = FALSE;
						$_uploadConfig['max_size'] = '1024000';
							
						$this->load->library('upload', $_uploadConfig);
							
						if (! $this->upload->do_upload('frmHaberResim')) {
							$_data['e'] = (object) array('durum' => 'hata', 'type' => 'uploadform', 'mesaj' => '');
							$this->render('errorpage', $_data);
						} else {
							//haber resmi değiştiği için önceki kayıt fiziksel olarak silinmeli...
							$get = $this->db->get_where('duyurular', array('id' => $_newsID));
							
							if ($get->num_rows() > 0 ) {
								//dosya adresi kırpılıyor...
								//http://keyfisinema.net/others/upload/haber/image.jpg şelinden
								//others/upload/haber/image.jpg şekline dönüşüyor..
								$image = substr($get->row()->resim, (int) strlen(base_url()));
								//resim silinyor...
								@unlink('./'.$image);
							}

							$_upload_data = $this->upload->data();

							$_q = $this->db->update('duyurular', array(
									"baslik" => $_haberBaslik,
									"icerik" => ckeditor_html_clear($_haberIcerik),
									"yazan" =>  uyebilgisi('kullaniciadi'),
									"tarih" => time(),
									"tur" => $_haberTuru,
									"resim" => base_url('others/upload/haber/'. $_upload_data['orig_name'] .'')
							), array('id' => $_newsID));
							
							if ($_q) {
								
								$this->db->delete('etiketler', array('eklenti_id' => $_newsID, 'tur' => 'haber'));
									
								foreach (explode(',', $_haberEtiket) as $etiket) {
									$this->db->insert('etiketler', array('eklenti_id' => $_newsID, 'tur' => 'haber', 'etiket' => $etiket ));
								}
									
								$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Duyuru Eklendi. <b><a href="'.base_url("admin/duyurular").'"> Geri Dön </a></b>');
								$this->render('errorpage', $_data);
							} else {
								$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru Düzeltilemedi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
								$this->render('errorpage', $_data);
							}
		
						}
					
					}
					
				endif;
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Duyuru Bulunamadı. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
			
		endif;
	}
	

}