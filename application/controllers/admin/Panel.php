<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends AdminController {
	
	function __construct() {
		parent::__construct();		
	}
	
	public function index() {
		$this->db->select('*')->from('mesajlar');
		$toplamMesaj = $this->db->get();
		$toplamMesaj = $toplamMesaj->result() ? $toplamMesaj->num_rows() : '0';
		
		$this->db->select('*')->from('mesajlar')->where('yeni =','Evet');
		$yeniMesaj = $this->db->get();
		$yeniMesaj = $yeniMesaj->result() ? $yeniMesaj->num_rows() : '0';
		
		$this->db->select('*')->from('yorumlar');
		$toplamYorum = $this->db->get();
		$toplamYorum = $toplamYorum->result() ? $toplamYorum->num_rows() : '0';
		
		$this->db->select('*')->from('yorumlar')->where('onay', 'Onayli');
		$onayliYorum = $this->db->get();
		$onayliYorum = $onayliYorum->result() ? $onayliYorum->num_rows() : '0';
		
		$this->db->select('*')->from('filmler');
		$filmSayisi = $this->db->get();
		$filmSayisi = $filmSayisi->result() ? $filmSayisi->num_rows() : '0';
		
		$this->db->select('*')->from('baglantilar');
		$baglantiSayisi = $this->db->get();
		$baglantiSayisi = $baglantiSayisi->result() ? $baglantiSayisi->num_rows() : '0';
		
		$this->db->select('*')->from('uyeler')->where('uye_seviye =', 'Normal');
		$toplamUye = $this->db->get();
		$toplamUye = $toplamUye->result() ? $toplamUye->num_rows() : '0';
		
		$this->db->select('*')->from('uyeler')->where(array('uye_seviye' => 'Normal', 'durum' => 'Aktif'));
		$aktifUye = $this->db->get();
		$aktifUye = $aktifUye->result() ? $aktifUye->num_rows() : '0';
		
		$data['data'] = (object) array(
										'toplamMesaj' => $toplamMesaj, 
										'yeniMesaj' => $yeniMesaj, 
										'toplamYorum' => $toplamYorum, 
										'onayliYorum' => $onayliYorum,
										'filmSayisi' => $filmSayisi,
										'baglantiSayisi' => $baglantiSayisi,
										'toplamUye' => $toplamUye,
										'aktifUye' => $aktifUye
										);
		
		
		//turkçealtyazi son altyazılar
		$xmladres = 'http://www.turkcealtyazi.org/rss.xml';
		$turkcealtyaziXml = file_get_contents($xmladres);

		$xml = new SimpleXMLElement($turkcealtyaziXml);
		
		$bilgi = new stdClass();
		$i = 0;
		foreach ($xml->channel->item as $item)
		{
			//film adresi
			$link = $item->link;	
			//film resmi
			@preg_match('/http\:\/{2}w{0,3}\.turkcealtyazi\.org\/film\/images\/(.*?)\.(jpg|png)/i', $item->description, $resim);
			$afis = $resim[0];
			//film adi
			$filmadi = $item->title;
			
			$bilgi->filmler[$i] = (object) array('adres' => (string) $link, 'afis' => $afis, 'filmadi' => (string) $filmadi);
			
			$i++;
		}

		$data['_rss'] = (object) $bilgi->filmler;
		
		$this->render('panel', $data);
	}
	
	public function Cikis(){
		$this->session->sess_destroy();
		redirect('admin/login');
	}

	
}

?>