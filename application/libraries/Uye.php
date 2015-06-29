<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @author TheDoctorWho
 *
*/

class Uye {

	private $ci;

	private $uyeId = NULL;
	
	private $uyebilgisi = array();
	
	public function __construct(){
		//super değişken...
		$this->ci =& get_instance();
	}
	
	/**
	 * uye id'sini set eder....
	 * 
	 * @param string $uyeID
	 * @return boolean
	 */
	public function set_uyeid($uyeID){
		
		if (empty($uyeID) || is_null($uyeID) || !is_numeric($uyeID))
		{
			return FALSE;
		}
		
		$this->uyeId = $uyeID;
		
	}
	
	/**
	 * uye id'sini get eder...
	 */
	public function get_uyeid()
	{
		return $this->uyeId;
	}
	
	/**
	 * üye girişi yaptırır...
	 * 
	 * @param string $kullaniciadi
	 * @param string $sifre
	 * @return string|boolean
	 */
	public function giris_yap($kullaniciadi, $sifre)
	{
		if ($kullaniciadi == '' || $sifre == '')
		{
			//kullanici adı veya şifresi boş hatası....
			return $this->error(4);
		}
		
		//uyeyi sorgulayalım...
		$uye = $this->ci->db->get_where('uyeler', array('kullanici_adi' => $kullaniciadi, 'sifre' => do_hash($sifre)));
		
		//üye varsa ....
		if ($uye->num_rows() > 0 )
		{
			$uye = $uye->row();
			
			if ($uye->durum != 'Aktif')
			{
				//aktif olmayan üye hatası...
				return $this->error(2);
			}
			else 
			{
				//uye seviyesini kontrol ediyoruz..
				$girenKim = ($uye->uye_seviye == 'normal') ? 'kullanici' : 'yönetici';
				//oturum bilgileri ...
				$sessions = array('girenKim' => $girenKim, 'giris_zamani' => time(), 'giris_tarihi' => date('d/m/Y H:i:s'));
				//oturum bilgileri ayarlanıyor...
				$this->session_ekle($sessions);
				//kullanıcı bilgileri atanıyor...
				$this->set_uyebilgi($uye);
				//giriş zamanı güncelleniyor..
				$this->ci->db->update("uyeler", array("songiris" => date("d/m/Y H:i:s")), array('id' => $uye->id));
				//uye id set ediliyor..
				$this->set_uyeid($uye->id);
			
				return TRUE;

			}
			
		}
		else
		{
			//üye bulunamadı hatası...
			return $this->error(1);
		}
		
	}
	
	public function giris_kontrol()
	{
		$girenKim = $this->ci->session->userdata('girenKim');
		
		if ($girenKim == 'kullanici' || $girenKim == 'yönetici')
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	/**
	 * üye bilgisini set eder...
	 * 
	 * @param string $uye
	 */
	public function set_uyebilgi($uye)
	{
		$sessions = array(
								'id' => $uye->id, 
								'kullaniciadi' => $uye->kullanici_adi, 
								'sifre' => $uye->sifre, 
								'email' => $uye->email, 
								'adsoyad' => $uye->adsoyad, 
								'cinsiyet' => $uye->cinsiyet,
								'meslek' => $uye->meslek,
								'dogumtarihi' => $uye->dogumgunu,
								'sehir' => $uye->sehir,
								'songiris' => $uye->songiris,
								'uyedurumu' => $uye->durum,
								'uyeliktarihi' => $uye->uyelik_tarihi,
								'avatar' => $uye->avatar,
								'uyeseviye' => $uye->uye_seviye
		);
		
		$this->session_ekle($sessions);
	}
	
	/**
	 * üye bilgisini get eder...
	 * 
	 * @param string $bilgi
	 * @return multitype:
	 */
	public function get_uyebilgi($bilgi)
	{
		return $this->ci->session->userdata($bilgi);
	}
	
	/**
	 * session atar..
	 * @param array $session
	 */
	public function session_ekle($session = array())
	{
		if (count($session) > 0 )
		{
			foreach ($session as $key => $value)
			{
				$this->ci->session->set_userdata($key, $value);
			}
		}
		else
		{
			//boş session değeri
			$this->error(5);
		}
		
	}
	
	/**
	 * session değerini getirir..
	 * @param strging $session
	 * @return Ambigous <string, boolean, multitype:>
	 */
	public function session_getir($session)
	{
		return $this->ci->session->userdata($session);
	}
	
	/**
	 *  hataları gösterir..
	 * 
	 */
	public function error($er)
	{
		$error = array(
				1 => 'Üye Bulunamadı..!',
				2 => 'Üyeliğiniz Henüz Aktifleştirilmemiş..!',
				3 => 'Üye Seviyesi Bulunamadı..!',
				4 => 'Kullanıcı Adı ve Şifresi Boş Bırakılmış..!',
				5 => 'Oturum Bilgisi Boş Olarak Gönderildi..!'
		);
		
		return $error[$er];
	}
	
	
}