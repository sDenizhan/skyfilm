<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filmler extends AdminController {
		
	function __construct() {
		parent::__construct();
        $this->load->helper('facebook');
	}

	public function index(){

		$filmler = $this->db->count_all('filmler');
		
		if ($filmler > 0) {
		
			$_page = $this->uri->segment(4);
		
			$pagination["base_url"] = base_url("admin/filmler/index/");
			$pagination["total_rows"] = $filmler;
			$pagination["per_page"] = 25;
			$pagination["uri_segment"] = 4;
            $pagination["use_page_numbers"] = true;

            include VIEWPATH.'dash/'. $this->getTheme() .'/views/config/pagination.php';
			$this->pagination->initialize($pagination);
		
			$this->db->order_by('id', 'DESC');
			$films = $this->db->get('filmler', $pagination['per_page'], $_page);
		
			$_data['_videos'] = $films;
			$_data['_pages'] = $this->pagination->create_links();
		
			$this->render('filmler_index', $_data);
            
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler/ekle").'"> Film Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}			
		
	}

    public function raporlar(){

        $filmler = $this->db->count_all('filmrapor');

        if ($filmler > 0) {

            $_page = $this->uri->segment(4);

            $pagination["base_url"] = base_url("admin/filmler/raporlar/");
            $pagination["total_rows"] = $filmler;
            $pagination["per_page"] = 25;
            $pagination["uri_segment"] = 4;

            include VIEWPATH.'dash/'. $this->getTheme() .'/views/config/pagination.php';
            $this->pagination->initialize($pagination);

            $this->db->order_by('id', 'DESC');
            $films = $this->db->get('filmrapor', $pagination['per_page'], $_page);

            $_data['_videos'] = $films;
            $_data['_pages'] = $this->pagination->create_links();

            $this->render('filmler_rapor', $_data);


        } else {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler").'"> Filmler </a></b>');
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
				$this->db->like('film_adi', $aranan)->or_like('film_orj_adi', $aranan);
			}
				
			if (!empty($id))
			{
				$this->db->where('id', $id);
			}
				
			$filmler = $this->db->get('filmler');
				
			if ($filmler->num_rows() > 0 )
			{
				$_page = $this->uri->segment(4);
				
				if (empty($_page))
				{
					$_page = 0;
				}
					
				$pagination["base_url"] = base_url('admin/filmler/filitrele/?aranan='. $aranan .'&id='. $id .'&siralama='. $siralama);
				$pagination["total_rows"] = $filmler->num_rows();
				$pagination["per_page"] = 25;
				$pagination["uri_segment"] = 4;
				$pagination["page_query_string"] = TRUE;

                include VIEWPATH.'dash/'. $this->getTheme() .'/views/config/pagination.php';
				$this->pagination->initialize($pagination);
		
				if (!empty($aranan))
				{
					$this->db->like('film_adi', $aranan)->or_like('film_orj_adi', $aranan);
				}
				if (!empty($id))
				{
					$this->db->where('id = ', $id);
				}
				$this->db->order_by('id', $siralama);
				
				$films = $this->db->get('filmler', $pagination['per_page'], $_page);
								
				$_data['_videos'] = $films;
				$_data['_pages'] = $this->pagination->create_links();
					
				$this->render('filmler_index', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Aradığınız Kriterlere Uygun Film Bulunamadı..! <b><a href="'.base_url("admin/filmler").'"> Filmler </a></b>');
				$this->render('errorpage', $_data);
			}
		
		}
		else
		{
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'GET Bilgisi Alınamadı..! <b><a href="'.base_url("admin/filmler").'"> Filmler </a></b>');
			$this->render('errorpage', $_data);
		}
	}
	
	//film ekleme....
	public function ekle(){
		$_katSayisi = $this->db->get('kategoriler');
		
		if ($_katSayisi->num_rows() <= 0) {
			$this->session->set_flashdata('KategoriEklemelisin', 'Film Eklemek İçin Kategori Eklemelisiniz...!');
			redirect('admin/kategoriler/kategoriekle');
		} else {

			$_data["_ustkat"] = $this->db->get_where('kategoriler', array("parent_id" => "0"));
			$_data["_altkat"] = $this->db->get_where('kategoriler', array("parent_id !=" => "0"));
			
			$this->render('filmler_filmekle', $_data);	
		}
	}
	
	//film kaydetme
	public function kaydet(){
		
		$this->form_validation->set_rules('filmadi', 'Film Adı', 'trim|required');
		$this->form_validation->set_rules('frmOrjinalAdi', 'Film Orjinal Adı', 'trim|required');
		$this->form_validation->set_rules('frmYapimYili', 'Yapım Yılı', 'trim|required');
		$this->form_validation->set_rules('frmYonetmen','Yönetmen','trim|required');
		$this->form_validation->set_rules('frmOyuncular', 'Oyuncular', 'trim|required');
		$this->form_validation->set_rules('frmGosterimTarihi', 'Film Gösterim Tarihi', 'trim|required');
		$this->form_validation->set_rules('frmTurkiyeGosterimTarihi', 'Film Türkiye Gösterim Tarihi', 'trim|required');
		$this->form_validation->set_rules('frmFilmSuresi', 'Film Süresi', 'trim|required');
		//$this->form_validation->set_rules('frmKategori', 'Film Kategorisi', 'trim|required');
		$this->form_validation->set_rules('frmFilmKonusu', 'Film Konusu', 'trim|required');
		$this->form_validation->set_rules('frmSitePuan', 'Film Puanı', 'trim|required');
		$this->form_validation->set_rules('frmUlke', 'Film Ülkesi', 'trim|required');
		$this->form_validation->set_rules('frmFilmResmi', 'Film Resmi', 'trim|required');
		$this->form_validation->set_rules('frmEtiketler', 'Etiket', 'trim|required');
		$this->form_validation->set_rules('frmLinkler', 'Film Linkleri', 'trim|required');
		$this->form_validation->set_rules('frmSeoTitle', 'Seo Title', 'trim|required');
		$this->form_validation->set_rules('frmSeoKeywords', 'Seo Keywords', 'trim|required');
		$this->form_validation->set_rules('frmSeoDescription', 'Seo Description', 'trim|required');
		//$this->form_validation->set_rules('frmFilmFragman', 'Film Fragmanı', 'trim|required');
		
		$this->form_validation->set_message('required', '<b>%s</b> Alanını Boş Bırakamazsınız');
		
		if ( $this->form_validation->run() == FALSE ) :
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
            $this->render('errorpage', $_data);
		else:
		
				$_filmAdi = $this->input->post('filmadi',TRUE);
				$_filmOrjinalAdi = $this->input->post('frmOrjinalAdi',TRUE);
				$_yapimYili = $this->input->post('frmYapimYili',TRUE);
				$_yonetmen = $this->input->post('frmYonetmen',TRUE);
				$_oyuncular = $this->input->post('frmOyuncular',TRUE);
				$_gosterimTarihi = $this->input->post('frmGosterimTarihi', TRUE);
				$_turkiyeGosterim = $this->input->post('frmTurkiyeGosterimTarihi', TRUE);
				$_filmSuresi = $this->input->post('frmFilmSuresi', TRUE);
				$_filmKonusu = $this->input->post('frmFilmKonusu',TRUE);
				$_filmResmi = $this->input->post('frmFilmResmi');
				$_kategori = implode(',', $this->input->post('kategori'));
				$_player = $this->input->post('frmPlayer', TRUE);
				$_puan = $this->input->post('frmSitePuan',TRUE);
				$_ulke = $this->input->post('frmUlke',TRUE);
				$_filmDili = $this->input->post('frmFilmDili',TRUE);
				$_filmDurumu = $this->input->post('frmFilmDurumu',TRUE);
				$_filmFragman = $this->input->post('frmFilmFragman');
				$_seoTitle = $this->input->post('frmSeoTitle', TRUE);
				$_seoKeywords = $this->input->post('frmSeoKeywords', TRUE);
				$_seoDescription = $this->input->post('frmSeoDescription', TRUE);
				$_urisegment = seoURL($_filmAdi);
				$filitre = $this->input->post('frmFilitre');
				
				if ($this->db->get_where('filmler', array('film_adi' => $_filmAdi))->num_rows() > 0 ) :
                    $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Daha Önceden Eklenmiş...! <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                    $this->render('errorpage', $_data);
				else:	
				
					$_insert = $this->db->insert('filmler', array(
						'film_adi' => $_filmAdi,
						'film_orj_adi' => $_filmOrjinalAdi,
						'konu' => $_filmKonusu,
						'sure' => $_filmSuresi,
						'yil' => $_yapimYili,
						'kategori_id' => $_kategori,
						'yonetmen' => $_yonetmen,
						'oyuncular' => $_oyuncular,
						'gosterim_tarihi' => $_gosterimTarihi,
						'turkiye_tarihi' => $_turkiyeGosterim,
						'ulke' => $_ulke,
						'resim' => $_filmResmi,
						'player' => $_player,
						'puan' =>  $_puan,
						'filitre' => $filitre,
						'uri' => $_urisegment,
						'ekleyen' => uyebilgisi('adsoyad'),
						'ekleme_tarihi' => time(),
						'hit' => 0,
						'dil' => $_filmDili,
						'durum' => $_filmDurumu,
						'fragman' => $_filmFragman,
						'seo_title' => $_seoTitle,
						'seo_keys' => $_seoKeywords,
						'seo_desc' => $_seoDescription
					));
					
					if ($_insert) {
                        $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Film Eklendi...! <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                        $this->render('errorpage', $_data);
						
						$_filmID = $this->db->insert_id();

                        $_etiketler = $this->input->post('frmEtiketler', TRUE);
                        $_linkler = $this->input->post('frmLinkler');

                        foreach (explode(',', $_etiketler) as $_etiket) {
                            $_etiketInsert = $this->db->insert('etiketler', array('eklenti_id' => $_filmID, 'etiket' => $_etiket, 'tur' => 'film'));
                        }

                        foreach (explode(',', $_linkler) as $_link) {
                            $_linkInsert = $this->db->insert('indirmelinkleri', array('film_id' => $_filmID, 'link' => $_link));
                        }

                        //facebook'ta paylaşma zamanı :)
                        $fbconfig = array(
                            'message' => $_filmAdi .' Film İzle, Tek Part İzle '. $_filmOrjinalAdi .' Film İzle, Tek Part İzle',
                            'link' => base_url($_urisegment),
                            'name' => $_filmAdi .' Film İzle, Tek Part İzle '. $_filmOrjinalAdi .' Film İzle, Tek Part İzle',
                            'picture' => $_filmResmi,
                            'description' => $_seoDescription,
                            'caption' => $_filmAdi. 'film izle'
                        );

                        $status = facebook_send_item($fbconfig);

                        if ( true != $status)
                        {
                            log_message('error', 'Facebook Error:'. $status);
                        }
					
					} else {
                        $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Eklenemedi...! <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                        $this->render('errorpage', $_data);
					}

			endif;
		endif;
		
		
	}
	
	//film duzeltme
	public function duzelt(){
		$_kayitSayisi = $this->db->get('kategoriler');
		$_filmID = $this->uri->segment(4);
		
		if (!is_numeric($_filmID) || empty($_filmID)) {
			redirect(base_url());
		} else {
			
			$_filmVarmi = $this->db->get_where('filmler', array('id' => $_filmID));
			
			if ($_filmVarmi->num_rows() > 0) {
				$_etiketler = $this->db->get_where('etiketler', array("eklenti_id" => $_filmID));
				$_linkler = $this->db->get_where('indirmelinkleri', array("film_id" => $_filmID));
				
				$_et = array();
				if ($_etiketler != FALSE ) {
					foreach ($_etiketler->result() as $_row) {
						array_push($_et, $_row->etiket);
					}
					$_data["_etiketler"] = implode(",", array_values($_et));
				}
				
				$_link = array();
				if ($_linkler != FALSE ) { 
					foreach ($_linkler->result() as $_row) {
						array_push($_link, $_row->link);
					}
					
					$_data["_linkler"] = implode(",", array_values($_link));
				}
				
				$_data["_ustkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id" => "0"));
				$_data["_altkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id !=" => "0"));

				$_data["_film"] = $_filmVarmi->row();
				
				$this->render('filmler_filmduzelt', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
			
		}
	}
	
	//duzeltilen filmi kaydeder...
	public function guncelle(){
		$_filmID = $this->uri->segment(4);
		
		if (!is_numeric($_filmID) || empty($_filmID)) {
			redirect(base_url());
		} else {
				
			$_filmVarmi = $this->db->get_where('filmler', array('id' => $_filmID));
				
			if ($_filmVarmi != FALSE) {

				$this->form_validation->set_rules('filmadi', 'Film Adı', 'trim|required');
				$this->form_validation->set_rules('frmOrjinalAdi', 'Film Orjinal Adı', 'trim|required');
				$this->form_validation->set_rules('frmYapimYili', 'Yapım Yılı', 'trim|required');
				$this->form_validation->set_rules('frmYonetmen','Yönetmen','trim|required');
				$this->form_validation->set_rules('frmOyuncular', 'Oyuncular', 'trim|required');
				$this->form_validation->set_rules('frmGosterimTarihi', 'Film Gösterim Tarihi', 'trim|required');
				$this->form_validation->set_rules('frmTurkiyeGosterimTarihi', 'Film Türkiye Gösterim Tarihi', 'trim|required');
				$this->form_validation->set_rules('frmFilmSuresi', 'Film Süresi', 'trim|required');
				//$this->form_validation->set_rules('frmFragman', 'Film Fragman', 'trim|required');
				$this->form_validation->set_rules('frmFilmKonusu', 'Film Konusu', 'trim|required');
				$this->form_validation->set_rules('frmSitePuan', 'Film Puanı', 'trim|required');
				$this->form_validation->set_rules('frmUlke', 'Film Ülkesi', 'trim|required');
				$this->form_validation->set_rules('frmEtiketler', 'Etiket', 'trim|required');
				$this->form_validation->set_rules('frmLinkler', 'Film Linkleri', 'trim|required');
				$this->form_validation->set_rules('frmSeoTitle', 'Seo Title', 'trim|required');
				$this->form_validation->set_rules('frmFilmResmi', 'Film Resmi', 'trim|required');
				$this->form_validation->set_rules('frmSeoKeywords', 'Seo Keywords', 'trim|required');
				$this->form_validation->set_rules('frmSeoDescription', 'Seo Description', 'trim|required');
				
				$this->form_validation->set_message('required', '<b>%s</b> Alanını Boş Bırakamazsınız');
				
				if ( $this->form_validation->run() == FALSE ) :
                    $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                    $this->render('errorpage', $_data);
				else:
				
					$_filmAdi = $this->input->post('filmadi',TRUE);
					$_filmOrjinalAdi = $this->input->post('frmOrjinalAdi',TRUE);
					$_yapimYili = $this->input->post('frmYapimYili',TRUE);
					$_yonetmen = $this->input->post('frmYonetmen',TRUE);
					$_oyuncular = $this->input->post('frmOyuncular',TRUE);
					$_gosterimTarihi = $this->input->post('frmGosterimTarihi', TRUE);
					$_turkiyeGosterim = $this->input->post('frmTurkiyeGosterimTarihi', TRUE);
					$_filmSuresi = $this->input->post('frmFilmSuresi', TRUE);
					$_filmKonusu = $this->input->post('frmFilmKonusu',TRUE);
					$_filmResmi = $this->input->post('frmFilmResmi');
					$_kategori = implode(',', $this->input->post('kategori',TRUE));
					//$_player = $this->input->post('frmPlayer', TRUE);
					$_puan = $this->input->post('frmSitePuan',TRUE);
					$_ulke = $this->input->post('frmUlke',TRUE);
					$_filmDili = $this->input->post('frmFilmDili',TRUE);
					$_filmDurumu = $this->input->post('frmFilmDurumu',TRUE);
					$_filmFragman = $this->input->post('frmFilmFragman', TRUE);
					$_seoTitle = $this->input->post('frmSeoTitle', TRUE);
					$_seoKeywords = $this->input->post('frmSeoKeywords', TRUE);
					$_seoDescription = $this->input->post('frmSeoDescription', TRUE);
					$_urisegment = seoURL($_filmAdi);
					$_filitre = $this->input->post('frmFilitre');
								
					$_update = $this->db->update('filmler', array(
									'film_adi' => $_filmAdi,
									'film_orj_adi' => $_filmOrjinalAdi,
									'konu' => $_filmKonusu,
									'sure' => $_filmSuresi,
									'yil' => $_yapimYili,
									'kategori_id' => $_kategori,
									'yonetmen' => $_yonetmen,
									'oyuncular' => $_oyuncular,
									'gosterim_tarihi' => $_gosterimTarihi,
									'turkiye_tarihi' => $_turkiyeGosterim,
									'ulke' => $_ulke,
									'resim' => $_filmResmi,
									//'player' => $_player,
									'filitre' => $_filitre,
									'uri' => $_urisegment,
									'puan' =>  $_puan,
									'ekleyen' => uyebilgisi('id'),
									'ekleme_tarihi' => time(),
									'dil' => $_filmDili,
									'durum' => $_filmDurumu,
									'fragman' => $_filmFragman,
									'seo_title' => $_seoTitle,
									'seo_keys' => $_seoKeywords,
									'seo_desc' => $_seoDescription
					), array('id' => $_filmID));
					
					if ($_update > 0) {
                        $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Film Düzeltildi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                        $this->render('errorpage', $_data);
					} else {
                        $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Düzeltilemedi. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                        $this->render('errorpage', $_data);
					}
					
					$_etiketler = $this->input->post('frmEtiketler', TRUE);
					
					if (!empty($_etiketler)) {									
						$this->db->delete('etiketler', array('eklenti_id' => $_filmID));
										
						foreach (explode(',', $_etiketler) as $_etiket) {
							$_etiketInsert = $this->db->insert('etiketler', array('eklenti_id' => $_filmID, 'etiket' => $_etiket));
						}
					}
					
					$_linkler = $this->input->post('frmLinkler');
					
					if (!empty($_linkler)) {
						$this->db->delete('indirmelinkleri', array('film_id' => $_filmID));
						foreach (explode(',', $_linkler) as $_link) {
							$_linkInsert = $this->db->insert('indirmelinkleri', array('film_id' => $_filmID, 'link' => $_link));
						}
					}
					
				endif;

			} else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Bulunamadı.. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
			}
				
				
		}
		
		
	}
	
	
	//film siler
	public function film_sil(){
		$_filmID = $this->uri->segment(4);
		
		if (!is_numeric($_filmID) || empty($_filmID)) {
			redirect(base_url());
		} else {
			
			$film = $this->db->get_where('filmler', array('id' => $_filmID));
			
			if ($film->num_rows() > 0) { 
				$_del = $this->db->delete('filmler', array('id' => $_filmID));
				
				if ($_del) {
					
					$partdel = $this->db->delete('partlar', array('film_id' => $_filmID));
					$linkdel = $this->db->delete('indirmelinkleri', array('film_id' => $_filmID));
					
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
					
				} else {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);
				}
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
			
		}
		
	}

    //film siler
    public function rapor_sil(){
        $_raporID = $this->uri->segment(4);

        if (!is_numeric($_raporID) || empty($_raporID)) {
            redirect(base_url());
        } else {

            $film = $this->db->get_where('filmrapor', array('id' => $_raporID));

            if ($film->num_rows() > 0) {
                $_del = $this->db->delete('filmrapor', array('id' => $_raporID));

                if ($_del) {

                    $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/filmler/raporlar").'"> Geri Dön </a></b>');
                    $this->render('errorpage', $_data);

                } else {
                    $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/filmler/raporlar").'"> Geri Dön </a></b>');
                    $this->render('errorpage', $_data);
                }
            } else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler/raporlar").'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
            }


        }

    }

    public function ajax_film_kaydet()
    {
        $film_adi = $this->input->post('film_adi');

        if ( empty($film_adi) )
        {
            $data = array('status' => 'error', 'message' => 'Film Adını Boş Bırakamazsınız..!');
        }
        else
        {
            $film = $this->db->get_where('filmler', array('film_adi' => $film_adi));

            if ( $film->num_rows() > 0 )
            {
                $data = array('status' => 'error', 'message' => 'Bu Film Daha Önceden Kaydedilmiş !!');
            }
            else
            {
                $insert = $this->db->insert('filmler', array('film_adi' => $film_adi));
                if ( $insert ) {
                    $film_id = $this->db->insert_id();
                    $film_data = array(
                        'film_id' => $film_id
                    );

                    $data = array('status' => 'ok', 'message' => 'Film Başarıyla Kaydedildi..!', 'data' => $film_data);
                }
                else
                {
                    $data = array('status' => 'error', 'message' => 'Film Kaydedilemedi.. Lütfen Tekrar Deneyiniz..!');
                }

            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
	
	//film partlarini gösterir..
	public function filmpartlari(){
        
        $film_id = $this->uri->segment(4);

        if (empty($film_id) || is_null($film_id))
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
            $this->render('errorpage', $_data);
        }
        else
        {
            $partlar = $this->db->get_where('partlar', array('film_id' => $film_id));

            if ($partlar->num_rows() > 0)
            {
                $data['_partlar'] = $partlar;
            }
            else
            {
                $data['_partlar'] = FALSE;
            }

            $data['_players'] = $this->db->get('oynaticilar');
            $this->render('filmler_filmpartlari', $data);

        }

	}
	
	//film partlarını kaydeder...
	public function ajax_part_kaydet(){
		$_partAdi = $this->input->post('partadi');
		$_filmID = $this->input->post('filmID');
		$_partAdresi = $this->input->post('partadresi');
		$_player = $this->input->post('player');
		$_alternatif = $this->input->post('alternatif');
		$_partAciklama = $this->input->post('partAciklama'); 
		
		if (empty($_partAdi) || empty($_partAdresi) || empty($_alternatif)) {
			$data = array('status' => 'error', 'message' => 'Part Adı, Part Adresi yada Alternatif Alanlarından Birini Boş Bıraktınız..!');
		} else {
				
            $_linkControl = $this->db->get_where('partlar', array('baslik' => $_partAdi, 'url' => $_partAdresi, 'alternatif' => $_alternatif, 'film_id' => $_filmID));

            if ($_linkControl->num_rows() > 0) :
                $data = array('status' => 'error', 'message' => 'Bu Part Daha Önceden Eklenmiş ..!');
            else:
                $_insert = $this->db->insert('partlar', array('film_id' => $_filmID, 'baslik' => $_partAdi, 'url' => $_partAdresi, 'player' => $_player,  'alternatif' => $_alternatif, 'aciklama' => $_partAciklama));

                if ($_insert) :
                    $data = array('status' => 'ok', 'message' => 'Part Başarıyla Eklendi..!');
                else:
                    $data = array('status' => 'error', 'message' => 'Part Eklenemedi..!');
                endif;
            endif;
			
		}

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	//film partini siler
	public function partsil() {
		$_partID = $this->input->post('partID');
		
		if (empty($_partID)) {
			$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'NoPost'));
		} else {
			$_del = $this->db->delete('partlar', array('id' => $_partID));
				
			if ($_del) :
				$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'ResultOk'));
			else:
				$this->load->view($this->getTheme() .'/ajax_ok', array('_mesaj' => 'ResultNo'));
			endif;
				
		}	
		
	}
	
	//film partini düzeltir...
	public function partduzelt(){
		$_partID = $this->input->post('partID');
		
		if (empty($_partID)) {
			$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'NoPost'));
		} else {
			
			$_select = $this->db->get_where('partlar', array('id' => $_partID));
			
			if ( $_select->num_rows() == 0) {
				$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'NoResult'));
			} else {

				$_data['_part'] = $_select->row();
				$_data['_players'] = $this->db->get('oynaticilar');
				
				$this->load->view($this->getTheme() .'/filmler_ajaxpartduzelt', $_data);
			}
			
		}
	}
	
	//film partini duzeltip kaydeder..
	public function partduzeltkaydet(){
		$_partID = $this->input->post('partID');
		$_partAdi = $this->input->post('partadi');
		$_partAdresi = $this->input->post('partadresi');
		$_player = $this->input->post('player');
		$_alternatif = $this->input->post('alternatif');
		$_partAciklama = $this->input->post('partAciklama'); 
		
		if (empty($_partAdi) || empty($_partAdresi) || empty($_alternatif)) {
			$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'NoPost'));
		} else {
		
			$_linkControl = $this->db->get_where('partlar', array('id' => $_partID));
		
			if ($_linkControl->num_rows() == 0) :
				$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'NoResult'));
			else:
				$_update = $this->db->update('partlar', array('baslik' => $_partAdi, 'url' => $_partAdresi, 'player' => $_player,  'alternatif' => $_alternatif, 'aciklama' => $_partAciklama), array('id' => $_partID));
				
				if ($_update) :
					$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'ResultOk'));
				else:
					$this->load->view($this->getTheme() .'/ajax_error', array('_mesaj' => 'ResultNo'));
				endif;
			endif;
				
		}
	}
	
	//film partlarını çeker
	public function ajax_part_getir() {
		$_filmID = $this->input->post('filmID');
		
		if (empty($_filmID)) {
			$data = array('status' => 'error', 'message' => 'Film ID Bilgisine Erişilemedi..!');
		} else {
            $_film = $this->db->get_where('filmler', array('id' => $_filmID));

            if ($_film->num_rows() > 0) {
                $_data['_film'] = $_film;

                $partlar = $this->db->get_where('partlar', array('film_id' => $_filmID));

                if ($partlar->num_rows() == 0) :
                    $data = array('status' => 'error', 'message' => 'Part Bulunamadı..!');
                else:

                    $parts = array();
                    foreach( $partlar->result() as $row)
                    {
                        $parts[] = array('part_id' => $row->id, 'baslik' => $row->baslik, 'alternatif' => $row->alternatif);
                    }

                    $data = array('status' => 'ok', 'message' => 'Part Alındı..!', 'data' => $parts);

                endif;
            }
            else
            {
                $data = array('status' => 'error', 'message' => 'Film Bulunamadı..!');
            }
		}

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	
	//film kopyalar
	public function filmkopyala()
	{
		$_kayitSayisi = $this->db->get('kategoriler');
		$_filmID = $this->uri->segment(4);
		
		if (!is_numeric($_filmID) || empty($_filmID)) {
			redirect(base_url());
		} else {
			
			$_filmVarmi = $this->db->get_where('filmler', array('id' => $_filmID));
			
			if ($_filmVarmi->num_rows() > 0) {
				$_etiketler = $this->db->get_where('etiketler', array("eklenti_id" => $_filmID));
				$_linkler = $this->db->get_where('indirmelinkleri', array("film_id" => $_filmID));
				
				$_et = array();
				if ($_etiketler != FALSE ) {
					foreach ($_etiketler->result() as $_row) {
						array_push($_et, $_row->etiket);
					}
					$_data["_etiketler"] = implode(",", array_values($_et));
				}
				
				$_link = array();
				if ($_linkler != FALSE ) { 
					foreach ($_linkler->result() as $_row) {
						array_push($_link, $_row->link);
					}
					
					$_data["_linkler"] = implode(",", array_values($_link));
				}
				
				$_data["_ustkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id" => "0"));
				$_data["_altkat"] = $this->db->get_where('kategoriler', array("ust_kategori_id !=" => "0"));
				
				
				$_data["_film"] = $_filmVarmi->row();
				$_data['ImageManagerUser'] = IMAGE_MANAGER_USER_KEY;
				
				$this->render('filmler_filmkopyala', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/filmler").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			}
			
			
		}
	}

	//film kopyala kaydet
	public function filmkopyalakaydet(){

		$this->form_validation->set_rules('filmadi', 'Film Adı', 'trim|required');
		$this->form_validation->set_rules('frmOrjinalAdi', 'Film Orjinal Adı', 'trim|required');
		$this->form_validation->set_rules('frmYapimYili', 'Yapım Yılı', 'trim|required');
		$this->form_validation->set_rules('frmYonetmen','Yönetmen','trim|required');
		$this->form_validation->set_rules('frmOyuncular', 'Oyuncular', 'trim|required');
		$this->form_validation->set_rules('frmGosterimTarihi', 'Film Gösterim Tarihi', 'trim|required');
		$this->form_validation->set_rules('frmTurkiyeGosterimTarihi', 'Film Türkiye Gösterim Tarihi', 'trim|required');
		$this->form_validation->set_rules('frmFilmSuresi', 'Film Süresi', 'trim|required');
		$this->form_validation->set_rules('frmFilmKonusu', 'Film Konusu', 'trim|required');
		$this->form_validation->set_rules('frmSitePuan', 'Film Puanı', 'trim|required');
		$this->form_validation->set_rules('frmUlke', 'Film Ülkesi', 'trim|required');
		$this->form_validation->set_rules('frmEtiketler', 'Etiket', 'trim|required');
		$this->form_validation->set_rules('frmLinkler', 'Film Linkleri', 'trim|required');
		$this->form_validation->set_rules('frmSeoTitle', 'Seo Title', 'trim|required');
		$this->form_validation->set_rules('frmFilmResmi', 'Film Resmi', 'trim|required');
		$this->form_validation->set_rules('frmSeoKeywords', 'Seo Keywords', 'trim|required');
		$this->form_validation->set_rules('frmSeoDescription', 'Seo Description', 'trim|required');
		
		$this->form_validation->set_message('required', '<b>%s</b> Alanını Boş Bırakamazsınız');
		
		if ( $this->form_validation->run() == FALSE ) :
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '<b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
            $this->render('errorpage', $_data);
		else:
		
			$_filmAdi = $this->input->post('filmadi',TRUE);
			$_filmOrjinalAdi = $this->input->post('frmOrjinalAdi',TRUE);
			$_yapimYili = $this->input->post('frmYapimYili',TRUE);
			$_yonetmen = $this->input->post('frmYonetmen',TRUE);
			$_oyuncular = $this->input->post('frmOyuncular',TRUE);
			$_gosterimTarihi = $this->input->post('frmGosterimTarihi', TRUE);
			$_turkiyeGosterim = $this->input->post('frmTurkiyeGosterimTarihi', TRUE);
			$_filmSuresi = $this->input->post('frmFilmSuresi', TRUE);
			$_filmKonusu = $this->input->post('frmFilmKonusu',TRUE);
			$_filmResmi = $this->input->post('frmFilmResmi');
			$_kategori = implode(',', $this->input->post('kategori',TRUE));
			$_player = $this->input->post('frmPlayer', TRUE);
			$_puan = $this->input->post('frmSitePuan',TRUE);
			$_ulke = $this->input->post('frmUlke',TRUE);
			$_filmDili = $this->input->post('frmFilmDili',TRUE);
			$_filmDurumu = $this->input->post('frmFilmDurumu',TRUE);
			$_filmFragman = $this->input->post('frmFilmFragman', TRUE);
			$_seoTitle = $this->input->post('frmSeoTitle', TRUE);
			$_seoKeywords = $this->input->post('frmSeoKeywords', TRUE);
			$_seoDescription = $this->input->post('frmSeoDescription', TRUE);
		
						
			$insert = $this->db->insert('filmler', array(
							'film_adi' => $_filmAdi,
							'film_orj_adi' => $_filmOrjinalAdi,
							'konu' => $_filmKonusu,
							'sure' => $_filmSuresi,
							'yil' => $_yapimYili,
							'kategori_id' => $_kategori,
							'yonetmen' => $_yonetmen,
							'oyuncular' => $_oyuncular,
							'gosterim_tarihi' => $_gosterimTarihi,
							'turkiye_tarihi' => $_turkiyeGosterim,
							'ulke' => $_ulke,
							'resim' => $_filmResmi,
							'player' => $_player,
                            'uri' => seoURL($_filmAdi),
							'puan' =>  $_puan,
							'ekleyen' => uyebilgisi('adsoyad'),
							'ekleme_tarihi' => time(),
							'dil' => $_filmDili,
							'durum' => $_filmDurumu,
							'fragman' => $_filmFragman,
							'seo_title' => $_seoTitle,
							'seo_keys' => $_seoKeywords,
							'seo_desc' => $_seoDescription
			));
			
			if ($insert > 0) {
				
				$_filmID = $this->db->insert_id();
			
				$_etiketler = $this->input->post('frmEtiketler', TRUE);
				
				if (!empty($_etiketler)) {									
					foreach (explode(',', $_etiketler) as $_etiket) {
						$_etiketInsert = $this->db->insert('etiketler', array('eklenti_id' => $_filmID, 'etiket' => $_etiket));
					}
				}
				
				$_linkler = $this->input->post('frmLinkler');
				
				if (!empty($_linkler)) {
					foreach (explode(',', $_linkler) as $_link) {
						$_linkInsert = $this->db->insert('indirmelinkleri', array('film_id' => $_filmID, 'link' => $_link));
					}
				}
                $_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Film Kopyalandı. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
			} else {
                $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Film Kopyalanamadı. <b><a href="'. $this->agent->referrer() .'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
			}
			
		endif;		
	}
	
}

/* End of file filmler.php */
/* Location: ./application/controllers/admin/filmler.php */
