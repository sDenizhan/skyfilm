<?php
if (!defined('BASEPATH')) die('Go Home Yankyy');

class Tckimlik {
	
	public $CI;
	
	public $tckimlik;
	public $ad = '';
	public $soyad = '';
	public $dogumgunu = '';

	function __construct($config=array())
	{
		//super değişken
		$this->CI =& get_instance();
		
		//load değişkenler
		if (count($config) > 0)
		{
			$this->initialize($config);
		}
	}
		
	public function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	public function duzelt($gelen){
		$karakterler = array("ç","ğ","ı","i","ö","ş","ü");
		$degistir = array("Ç","Ğ","I","İ","Ö","Ş","Ü");
		return str_replace($karakterler, $degistir, $gelen);
	}
	
	
	public function dogrula()
	{
		settype($this->tckimlik, "double");
		
		try
		{
			$veriler = array(
					'Ad' => strtoupper($this->ad),
					'Soyad' => strtoupper($this->soyad),
					'DogumYili' => $this->dogumgunu,
					'TCKimlikNo' => $this->tckimlik
			);
			
			$baglanti = new SoapClient('https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL');
			
			$sonuc = $baglanti->TCKimlikNoDogrula($veriler);
		
			if ($sonuc->TCKimlikNoDogrulaResult)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		
		}
		catch (Exception $e)
		{
			return $e->faultstring;
		}
		
	}
	
}