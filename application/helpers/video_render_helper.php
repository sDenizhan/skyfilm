<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * facebook url düzeltici
 * 
 */
if (! function_exists('facebook_replace')) {
	function facebook_replace($_url) {
		$_url = str_replace("\u00253A", ":", $_url);
		$_url = str_replace("\u00252F", "/", $_url);
		$_url = str_replace("\u00253F", "?", $_url);
		$_url = str_replace("\u00253D", "=", $_url);
		$_url = str_replace("\u002526", "&", $_url);
		return $_url;
	}	
}

/**
 * 
 * facebook url çözücü
 * 
 */
if (! function_exists('facebook_video_url')) {
	
	function facebook_video_url($_videoURL){
		
		$CI =& get_instance();
		
		$facebook['1'] = array('yalnizprens_17@hotmail.com', '13467985#asd');
		
		$fb = array_rand($facebook);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://login.facebook.com/login.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,'email='.urlencode($fb['0']).'&pass='.urlencode($fb['1']).'&login=Login');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_COOKIEJAR,dirname(__FILE__)."/cookie.txt");
		curl_setopt($ch, CURLOPT_COOKIEFILE,dirname(__FILE__)."/cookie.txt");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
		curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; tr; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)");
		curl_exec($ch);
		curl_setopt($ch, CURLOPT_URL, $_videoURL);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.facebook.com");
		curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; tr; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11 (.NET CLR 3.5.30729)");
		$_gelen = curl_exec($ch);
		curl_close($ch);


		preg_match("@\[\"highqual_src\"\,\"(.*?)\"\]@i", $_gelen, $_url);
		preg_match("@\[\"thumb_url\"\,\"(.*?)\"\]@i", $_gelen, $_thumb);

		
		$_fbVideoURL = $_url['1'];
		$_fbVideoResim = $_thumb['1'];
		
		$fb = (object) array('_videoURL' => facebook_replace($_fbVideoURL), '_thumbURL' => facebook_replace($_fbVideoResim));

        $CI->load->helper('video_render');

        echo video_render('jw', $fb->_videoURL, $fb->_thumbURL);

	}
	
}


/**
 * 
 * video renderleyici
 * 
 */

if (! function_exists('video_render')) {

	function video_render($_player, $_videoURL, $_thumbURL = NULL) {

		$CI =& get_instance();
		$CI->load->helper('file');

		$_read = read_file("./others/players/".$_player.".php");

		$_read = str_replace('{player_path}', $CI->config->base_url("players"), $_read);		
		$_read = str_replace('{video_path}', $_videoURL, $_read);
		$_read = str_replace('{thumb_path}', $_thumbURL, $_read);
		
		$_rand = substr( md5(rand(0, 9999999)), 0, 5);
		$_read = str_replace('{video_div}', $_rand, $_read);

		$CI->load->helper('ayarlar');

		$_read = preg_replace('#^width=\"(.*?)\"$#i', 'width="'.ayar_getir('video_width').'"', $_read);
		$_read = preg_replace('#^height=\"(.*?)\"$#i', 'height="'.ayar_getir('video_height').'"', $_read);

		$_read = preg_replace('#\{width\}#i', 'width="'.ayar_getir('video_width').'"', $_read);
		$_read = preg_replace('#\{height\}#i', 'height="'.ayar_getir('video_height').'"', $_read);

		
		return html_entity_decode($_read);
	}

}