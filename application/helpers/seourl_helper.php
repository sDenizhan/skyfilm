<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getFilmURL'))
{
	function getFilmURL($filmadi)
	{
		return site_url(seoURL($filmadi));
	}
	
}

if ( ! function_exists('seoURL'))
{
	function seoURL($url){
		$url = trim($url);
		$find = array('<b>', '</b>');
		$url = str_replace ($find, '', $url);
		$url = preg_replace('/<(\/{0,1})img(.*?)(\/{0,1})\>/', 'image', $url);
		$find = array(' ', '&amp;quot;', '&amp;amp;', '&amp;', '\r\n', '\n', '/', '\\', '+', '<', '>');
		$url = str_replace ($find, '-', $url);
		$find = array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ë', 'Ê');
		$url = str_replace ($find, 'e', $url);
		$find = array('í', 'ý', 'ì', 'î', 'ï', 'I', 'Ý', 'Í', 'Ì', 'Î', 'Ï','İ','ı');
		$url = str_replace ($find, 'i', $url);
		$find = array('ó', 'ö', 'Ö', 'ò', 'ô', 'Ó', 'Ò', 'Ô');
		$url = str_replace ($find, 'o', $url);
		$find = array('á', 'ä', 'â', 'à', 'â', 'Ä', 'Â', 'Á', 'À', 'Â');
		$url = str_replace ($find, 'a', $url);
		$find = array('ú', 'ü', 'Ü', 'ù', 'û', 'Ú', 'Ù', 'Û');
		$url = str_replace ($find, 'u', $url);
		$find = array('ç', 'Ç');
		$url = str_replace ($find, 'c', $url);
		$find = array('þ', 'Þ','ş','Ş');
		$url = str_replace ($find, 's', $url);
		$find = array('ð', 'Ð','ğ','Ğ');
		$url = str_replace ($find, 'g', $url);
		$find = array('/[^A-Za-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
		$repl = array('', '-', '');
		$url = preg_replace ($find, $repl, $url);
		$url = str_replace ('--', '-', $url);
		$url = strtolower($url);
		return $url;
	}
}

if ( ! function_exists('small_seoURL'))
{
	function small_seoURL($string){
		$string = str_replace(" ", "-", $string);
		$string = str_replace("%20", "-", $string);
		$string = str_replace("&", "", $string);
		return strtolower(trim($string, '-'));
	}
}

if ( ! function_exists('rssCharSet'))
{
    function rssCharSet($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8', FALSE);
    }
}

//tarih itemscope için ayarlama
if (!function_exists('iso8601'))
{
    function iso8601($time=false) {
        if ($time === false) $time = time();
        $date = date('d/m/Y\TH:i:sO', strtotime($time));
        return (substr($date, 0, strlen($date)-2).':'.substr($date, -2));
    }
}
