<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Curl {

	public $curl;
	
	public $referrer = 'http://www.google.com';
	
	public $timeout = 500;
	
	public $varsayilan_ayarlar = array(
		CURLOPT_FOLLOWLOCATION => TRUE,
		CURLOPT_RETURNTRANSFER => TRUE,
	);

    function __construct()
    {
		//curl_init'i atayalım..
		$this->curl_ac();
		
		//varsayılan curl ayarlarını yükleyelim..
		$this->varsayilanAyarlar();

    }
	
	public function curl_ac(){
		$this->curl = curl_init();
	}
	
	public function varsayilanAyarlar(){
		curl_setopt_array($this->curl, $this->varsayilan_ayarlar);
	}
	
	public function ayar_ekle($ayar, $deger='')
	{
		//ayar string ise ve ayar ve deger boş değilse...
		if (!empty($ayar) || !empty($deger))
		{
			curl_setopt($this->curl, $ayar, $deger);
		}
		else
		{
			$this->exception(4);
		}
			
	}
	
	public function coklu_ayar_ekle($ayar = array())
	{
		//ayar string ise ve ayar ve deger boş değilse...
		if (is_array($ayar) && count($ayar) > 0)
		{
			curl_setopt_array($this->curl, $ayar);
		}
		else
		{
			$this->exception(2);
		}
		
	}
	
	public function curl_kapat()
	{
		curl_close($this->curl);
	}
	
	public function curl_calistir()
	{
		$c = curl_exec($this->curl);
		
		if ($c)
		{
			return $c;
		}
		else
		{
			$this->exception(curl_error($this->curl), TRUE);			
		}
		
	}
	
	public function dosyaindir($dosya, $yol, $yeniad = '', $uzanti = '')
	{
		//dosya adresi ve indirilecek konum kontrolü..
		if (empty($dosya) || empty($yol))
		{
			die('Dosya Adresini veya Kaydedilecek Konumu Belirtmediniz...!');
		}
				
		//curlu gönderelim
		$this->ayar_ekle(CURLOPT_RETURNTRANSFER, 1);
		$gelen = $this->getir($dosya);
		
		$dosyaadi = '';
		
		//dosya uzantısı kontrol ediliyor....		
		if (empty($uzanti))
		{
			$e = explode('.', $dosya);
			$uzanti = end($e);
			if (empty($uzanti))
			{
				$uzanti = 'txt';
			}
		}
		
		//dosya adı kontrol ediliyor..
		if (!empty($yeniad))
		{
			$dosyaadi = $yeniad.'.'.$uzanti;
		}
		else
		{
			$e = explode('/', $dosya);
			$dosyaadi = end($e);	
		}
		
		$yol = ltrim($yol, '/');
		
		//dosya varsa yeniden adlandırsın...
		if (file_exists($yol.'/'.$dosyaadi))
		{
			//rastgele isim oluşturuyoruz...
			$dosyaadi = substr(md5(sha1(rand(0,99) * 12121212 + 8493894823984234)), 0, 6).'.'.$uzanti;
		}
		
		$fo = fopen($yol.'/'.$dosyaadi, 'w+');
		fwrite($fo, $gelen);
		fclose($fo);
		
		if ($fo)
		{
			return $dosyaadi;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	public function getir($adres = '', $post = array(), $header = array()){
	
		if ($adres == '' || empty($adres) || $adres == NULL)
		{
			$this->exception(1);
		}
		
		$this->ayar_ekle(CURLOPT_URL, $adres);
		$this->ayar_ekle(CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		
		//post ayarları
		if (is_array($post) && count($post) > 0)
		{
			$this->ayar_ekle(CURLOPT_POST, 1);
			$this->ayar_ekle(CURLOPT_POSTFIELDS, $post);
		}

        //header ayarları
        if (is_array($header) && count($header) > 0)
        {
            $this->ayar_ekle(CURLOPT_HEADER, $header);
        }
		
		return $this->curl_calistir();
				
	}
	
	
	public function set_referrer($referrer)
	{
		if (!empty($referrer))
		{
			$this->referrer = $referrer;
			$this->ayar_ekle(CURLOPT_REFERER, $referrer);	
		}

	}
	
	public function get_referrer()
	{
		return $this->referrer;
	}
	
	
	public function set_timeout($second, $type = FALSE)
	{
		$this->timeout = $second;
		
		if ($type == FALSE)
		{
			$this->ayar_ekle(CURLOPT_CONNECTTIMEOUT, $second);
		}
		else
		{
			$this->ayar_ekle(CURLOPT_CONNECTTIMEOUT_MS, $second);	
		}
		
		
	}
	
	public function exception($error, $s = FALSE){
	
		$message = array();
		$message[1] = 'Getirilecek Adresi Girmediniz';
		$message[2] = 'ayar_ekle metodu için boş array giremezsiniz..!';
		$message[3] = 'ayar_ekle metodu için sadece STRING veya ARRAY türünden değişken girebilirsiniz..';
		$message[4] = 'ayar_ekle metodu için boş değer giremezsiniz..!';
		
		try{
			if ($s == FALSE )
			{
				throw new Exception($message[$error]);
			}
			else
			{
				throw new Exception($error);
			}
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}
}