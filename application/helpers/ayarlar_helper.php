<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * ayarlar modeli için helper...
 * 
 */


/**
 * 
 * ayar getirir...
 * 
 */
if (!function_exists('ayar_getir'))
{
	function ayar_getir($ayaradi)
	{
		if ($ayaradi == '' || empty($ayaradi))
		{
			return '';
		}
		
		//super değişken
		$ci =& get_instance();
		
		//ayarlar libraryi yükleniyor..
		$ci->load->library('ayarlar');
	
		if ($ci->ayarlar->ayar_varmi($ayaradi))
		{
			return	$ci->ayarlar->ayar_getir($ayaradi);
		}
		else
		{
			return '';
		}
	
	}
	
}

/**
 * 
 * ayar siler
 * 
 */
if (!function_exists('ayar_sil'))
{
	function ayar_sil($ayaradi)
	{
		if ($ayaradi == '' || empty($ayaradi))
		{
			return '';
		}

		//super değişken
		$ci =& get_instance();

		//ayarlar libraryi yükleniyor..
		$ci->load->library('ayarlar');

		if ($ci->ayarlar->ayar_varmi($ayaradi))
		{
			return	$ci->ayarlar->ayar_sil($ayaradi);
		}
		else
		{
			return FALSE;
		}

	}

}

/**
 * ayar ekler
 * 
 */

if (!function_exists('ayar_ekle'))
{
	function ayar_ekle($ayaradi, $deger)
	{
		if (empty($deger) || empty($ayaradi))
		{
			return '';
		}

		//super değişken
		$ci =& get_instance();

		//ayarlar libraryi yükleniyor..
        $ci->load->library('ayarlar');

		if ($ci->ayarlar->ayar_varmi($ayaradi))
		{
			return	$ci->ayarlar->ayar_ekle($ayaradi, $deger);
		}
		else
		{
			return FALSE;
		}

	}

}

/**
 * ayar gunceller...
 */
if (!function_exists('ayar_guncelle'))
{
	function ayar_guncelle($ayaradi, $deger)
	{
		if (empty($ayaradi))
		{
			return '';
		}

		//super değişken
		$ci =& get_instance();

		//ayarlar libraryi yükleniyor..
        $ci->load->library('ayarlar');

		if ($ci->ayarlar->ayar_varmi($ayaradi))
		{
			return $ci->ayarlar->ayar_guncelle($ayaradi, $deger);
		}
		else
		{
			return FALSE;
		}

	}

}