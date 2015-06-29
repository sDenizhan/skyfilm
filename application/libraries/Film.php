<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author TheDoctorWho
 *
 */

class Film {
	
	private $ci;
	
	private $bilgiler;
	
	private $filmID;

	public function __construct(){
		//super değişken...
		$this->ci =& get_instance();
	}

	public function set_filmid($filmid = '')
	{
		if ($filmid != '' || !is_numeric($filmid))
		{
			//film id
			$this->filmID = $filmid;
		}
		else
		{
			global $filmID;
			
			//film id
			$this->filmID = $filmID;
		}
		
	}
	
	/**
	 * uri'den film olup olmadığını sorgular...
	 * 
	 * @param string $uri
	 * @return boolean|Ambigous <object, mixed, boolean, unknown, string>
	 */
	public function is_film($uri)
	{
		//film adı boş yada string ifade değilse...
		if (empty($uri) || !is_string($uri))
		{
			return FALSE;
		}

		$get = $this->ci->db->get_where('filmler', array('uri' => $uri));
		
		if ($get->num_rows() > 0)
		{
			return $get;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	/**
	 * part sayisi
	 */
	
	public function part_sayisi($alternatif = 1)
	{
		//alternatif kontrolü...
		if ($alternatif == '' || !is_numeric($alternatif) || $alternatif == 0 || $alternatif > 4)
		{
			return '';
		}
		
		//alternatif sorgusu....
		$al = $this->ci->db->get_where('partlar', array('film_id' => $this->filmID, 'alternatif' => $alternatif));
		
		if ($al->num_rows() > 0)
		{
			return $al->num_rows();
		}
		else
		{
			return FALSE;
		}
		
	}
	
	
	/**
	 * filmin partlarını yollar...
	 * 
	 * @param number $alternatif
	 */
	
	public function part_getir($alternatif = 1, $offset = 0, $limit = 1)
	{
		//alternatif kontrolü...
		if ($alternatif == '' || !is_numeric($alternatif) || $alternatif == 0 || $alternatif > 4)
		{
			return '';
		}
		
		//alternatif sorgusu....
		$this->ci->db->select('*')->from('partlar')->where(array('film_id' => $this->filmID, 'alternatif' => $alternatif))->order_by('id', 'ASC')->limit($limit, $offset);
		$al = $this->ci->db->get();
		
		if ($al->num_rows() > 0)
		{
			return $al;
		}
		else
		{
			return FALSE;
		}
		
	}
	
	
	/**
	 * istenilen kolonun değerini döndürür...
	 * 
	 * @param string $bilgi
	 * @return boolean
	 */
	public function bilgi($bilgi)
	{
		//bilgi kolonu ayarlanıyor...
		switch ($bilgi)
		{
			case 'oyuncular':
				$kolon = 'oyuncular';
				break;
					
			case 'filmadi':
				$kolon = 'film_adi';
				break;
					
			case 'orjinaladi':
				$kolon = 'film_orj_adi';
				break;
					
			case 'konu':
				$kolon = 'konu';
				break;
					
			case 'sure':
				$kolon = 'sure';
				break;
					
			case 'fragman':
				$kolon = 'fragman';
				break;

            case 'ulke':
                $kolon = 'ulke';
                break;
                
            case 'filitre':
               	$kolon = 'filitre';
               	break;

			case 'yapimyili':
				$kolon = 'yil';
				break;
					
			case 'kategori':
				$kolon = 'kategori_id';
				break;
		
			case 'url':
				$kolon = 'uri';
				break;
		
			case 'yonetmen':
				$kolon = 'yonetmen';
				break;
		
			case 'gosterimtarihi':
				$kolon = 'gosterim_tarihi';
				break;
					
			case 'tgosterimtarihi':
				$kolon = 'turkiye_tarihi';
				break;
					
			case 'player':
				$kolon = 'player';
				break;
					
			case 'resim':
				$kolon = 'resim';
				break;
					
			case 'dil':
				$kolon = 'dil';
				break;
		
			case 'durum':
				$kolon = 'durum';
				break;
					
			case 'puan':
				$kolon = 'puan';
				break;
		
			case 'ekleyen':
				$kolon = 'ekleyen';
				break;
					
			case 'tarih':
				$kolon = 'ekleme_tarihi';
				break;
		
			case 'hit':
				$kolon = 'hit';
				break;
					
			case 'oy':
				$kolon = 'oy';
				break;
					
			case 'title':
				$kolon = 'seo_title';
				break;
					
			case 'keywords':
				$kolon = 'seo_keys';
				break;
					
			case 'description':
				$kolon = 'seo_desc';
				break;
					
			case 'kaynak':
				$kolon = 'kaynak';
				break;
		
			default:
				$kolon = 'id';
				break;
					
		}
		
		//daha önceden sorgulama yapılmışsa ....
		if (count($this->bilgiler) > 0)
		{
			return $this->bilgiler[$kolon];
		}
		else
		{
			$get = $this->ci->db->get_where('filmler', array('id' => $this->filmID));
				
			if ($get->num_rows() > 0 )
			{
				$this->bilgiler = $get->row_array();
			}
			else
			{
				return FALSE;
			}
				
			return $this->bilgiler[$kolon];
		
		}

		
	}
	
	

}