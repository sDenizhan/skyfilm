<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('reklam_goster')) {
	
	function reklam_goster($konum = NULL) {
		
		if (empty($konum) || $konum == '' || $konum == NULL)
		{
			return '';
		}
		
		$CI =& get_instance();
		
		$CI->db->select('*')->from('reklamlar')->where('reklam_konumu', $konum)->where('durum', 'aktif')->order_by('id', 'RANDOM')->limit("1");
		$query = $CI->db->get();
		
		if ($query->num_rows() > 0) {
			
			$reklam = '';
			
			//reklamlar
			if ($query->row()->reklam_turu == 'html')
			{
				$reklam = $query->row()->reklam_kodu;
			}
			else if ($query->row()->reklam_turu == 'text')
			{
				$reklam = '<a href="'. base_url('reklam/git/'. $query->row()->id .'/?r='. urlencode($query->row()->reklam_url)) .'" title="'. $query->row()->reklam_metni .'" target="_blank">'. $query->row()->reklam_metni .'</a>';
			}
			else
			{
				$reklam = '<a href="'. base_url('reklam/git/'. $query->row()->id .'/?r='. urlencode($query->row()->reklam_url)) .'" title="'. $query->row()->reklam_metni .'" target="_blank"><img src="'. $query->row()->reklam_resmi .'" border="0" alt="'. $query->row()->reklam_metni .'"></a>';
			}
			
			
			//reklam ve zaman kontrolü
			$now = date('Y-m-d H:i:s');
			
			if ($query->row()->zaman_aktif == 'aktif')
			{
				if ($query->row()->baslangic_tarihi <= $now && $query->row()->bitis_tarihi >= $now)
				{
					$CI->db->update('reklamlar', array('hit' => $query->row()->hit +1), array('id' => $query->row()->id));
					return $reklam;
				}
				else
				{
					return '';
				}
				
			}
			else
			{
				$CI->db->update('reklamlar', array('hit' => $query->row()->hit +1), array('id' => $query->row()->id));
				return $reklam;
			}
			
		}
		else
		{
			return '';
		}

	}
	
}