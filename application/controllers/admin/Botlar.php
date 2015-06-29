<?php
if (!defined('BASEPATH')) exit("Go Home Yanki !!");

class Botlar extends AdminController {

	function __construct() {
		parent::__construct();
    }
	
	function index(){
		$_kayitSayisi = $this->db->count_all("botlar");
		
		if ($_kayitSayisi > 0) {

            $_page = $this->uri->segment(4);

            $config["base_url"] = base_url("admin/botlar/index/");
            $config["total_rows"] = $_kayitSayisi;
            $config["per_page"] = 25;
            $config["uri_segment"] = 4;

            include APPPATH.'/config/admin-pagination.php';

            $this->pagination->initialize($config);

            $this->db->order_by('id', 'DESC');
            $botlar = $this->db->get('botlar', $config['per_page'], $_page);

            $_data['_botlar'] = $botlar;
            $_data['_pages'] = $this->pagination->create_links();

            $this->render('botlar_index', $_data);
            
		} else {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/botlar/botekle").'"> Bot Eklemek İçin Tıklayınız </a></b>');
			$this->render('errorpage', $_data);
		}
		
	}

	function botekle(){
        $this->load->helper('directory');

        $data['_botlar'] = directory_map('./others/bots', TRUE);

        if (count($data['_botlar']) <= 0)
        {
            $_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Sistemde Bot Bulunamadı. İlk Önce Bot Eklemeniz Gerekiyor..! ');
            $this->render('errorpage', $_data);
        }
        else
        {
            $this->render('botlar_botekle', $data);
        }

	}
	
	
	function botkaydet(){
		$this->form_validation->set_rules('frmBotAdi','Bot Adı','trim|required');
        $this->form_validation->set_rules('frmBotAciklamasi','Bot Açıklaması','trim|required');
		$this->form_validation->set_rules('frmBotDurumu','Bot Durumu','trim|required');
		$this->form_validation->set_rules('frmBotFile','Bot Dosyası','trim|required');
		
		$this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
		
		if ($this->form_validation->run() == FALSE) {
			$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
			$this->render('errorpage', $_data);
		} else {
			
			$_botadi = $this->input->post('frmBotAdi');
			$_botkullanimyeri = $this->input->post('frmKullanimYeri');
			$_botaciklamasi = $this->input->post('frmBotAciklamasi');
			$_botdurumu = $this->input->post('frmBotDurumu');
			$_botfile = $this->input->post('frmBotFile');
			
			$_q = $this->db->insert('botlar',
                array(
                        "bot_adi" => $_botadi,
                        "kullanim_yeri" => $_botkullanimyeri,
                        "aciklama" => $_botaciklamasi,
                        "durum" => $_botdurumu,
                        "dosya_adi" => $_botfile
                )
            );

			if ($_q) {
				$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Bot Eklendi..! [ <a href="'. base_url('admin/botlar/').'">Bot Ekle</a> ]');
                $this->render('errorpage', $_data);
			} else {
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Bot Eklenemedi..! [ <a href="'. base_url('admin/botlar/').'">Bot Ekle</a> ] ');
                $this->render('errorpage', $_data);
			}	
			
		}
	}
	
	function botsil(){
		$botID = $this->uri->segment(4);
		
		if (!is_numeric($botID) || empty($botID) ):
			redirect('admin/panel');
		else:
			if ($this->db->get_where('botlar', array('id' => $botID))->num_rows() > 0):
                
				$_delete = $this->db->delete('botlar', array('id' => $botID));
				
				if ($_delete > 0) : 
					$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Kayıt Silindi. <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
					$this->render('errorpage', $_data);	
				else:
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Silinemedi. <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
                    $this->render('errorPage', $_data);
                endif;
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
                $this->render('errorpage', $_data);
            endif;
		endif;
	
	}
	
	function botduzelt(){
		$botID = $this->uri->segment(4);
		
		if (!is_numeric($botID) || empty($botID) ):
			redirect("admin/panel");
		else:
			if ($this->db->get_where('botlar', array('id' => $botID))->num_rows() > 0): 
			
				$this->load->helper('directory');
				
				$_data['_botlar'] = directory_map('./others/bots', TRUE);
			
				$_data["_bot"] = $this->db->get_where('botlar', array('id' => $botID))->row();
				
				$this->render('botlar_duzelt', $_data);
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı. <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
			
		endif;			
		
	}
	
	function botduzeltkaydet(){
		$_botID = $this->uri->segment(4);
		
		if (!is_numeric($_botID) || empty($_botID) ):
			redirect("admin/panel");
		else:
			if ($this->db->get_where('botlar', array('id' => $_botID))->num_rows() > 0):
			
				$this->form_validation->set_rules('frmBotAdi','Bot Adı','trim|required|xss_clean');
		        $this->form_validation->set_rules('frmBotAciklamasi','Bot Açıklaması','trim|required|xss_clean');
				$this->form_validation->set_rules('frmBotDurumu','Bot Durumu','trim|required|xss_clean');
				$this->form_validation->set_rules('frmBotFile','Bot Dosyası','trim|required|xss_clean');
				
				$this->form_validation->set_message('required', '%s alanını girmek zorundasınız.');
				
				if ($this->form_validation->run() == FALSE) {
					$_data['e'] = (object) array('durum' => 'hata', 'type' => 'formvalidation', 'mesaj' => '');
					$this->render('errorpage', $_data);
				} else {
					
					$_botadi = $this->input->post('frmBotAdi');
					$_botkullanimyeri = $this->input->post('frmKullanimYeri');
					$_botaciklamasi = $this->input->post('frmBotAciklamasi');
					$_botdurumu = $this->input->post('frmBotDurumu');
					$_botfile = $this->input->post('frmBotFile');
					
					$_q = $this->db->update('botlar', array(
												"bot_adi" => $_botadi,
												"kullanim_yeri" => $_botkullanimyeri,
												"aciklama" => $_botaciklamasi,
												"durum" => $_botdurumu,
												"dosya_adi" => $_botfile
					), array('id' => $_botID));
		
					if ($_q) {
						$_data['e'] = (object) array('durum' => 'ok', 'type' => 'normal', 'mesaj' => 'Bot Düzeltildi. <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					} else {
						$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Bot Eklenemedi.  <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
						$this->render('errorpage', $_data);
					}	
					
				}
			
			else:
				$_data['e'] = (object) array('durum' => 'hata', 'type' => 'normal', 'mesaj' => 'Kayıt Bulunamadı.  <b><a href="'.base_url("admin/botlar").'"> Geri Dön </a></b>');
				$this->render('errorpage', $_data);
			endif;
			
		endif;
	}
	

}