<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (! function_exists('skyweboffice_curl'))
{
    function skyweboffice_curl($url){

        (function_exists('curl_init')) ? '' : die('cURL Must be installed for geturl function to work. Ask your host to enable it or uncomment extension=php_curl.dll in php.ini');

        $curl = curl_init();
        $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
        $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Keep-Alive: 300";
        $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en-us,en;q=0.5";
        $header[] = "Pragma: ";

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0 Firefox/5.0');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); //CURLOPT_FOLLOWLOCATION Disabled...
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);

        $html = curl_exec($curl);

        $status = curl_getinfo($curl);
        curl_close($curl);

        if($status['http_code']!=200){
            if($status['http_code'] == 301 || $status['http_code'] == 302) {
                list($header) = explode("\r\n\r\n", $html, 2);
                $matches = array();
                preg_match("/(Location:|URI:)[^(\n)]*/", $header, $matches);
                $url = trim(str_replace($matches[1],"",$matches[0]));
                $url_parsed = parse_url($url);
                return (isset($url_parsed))? skyweboffice_curl($url):'';
            }
            $oline='';
            foreach($status as $key=>$eline){$oline.='['.$key.']'.$eline.' ';}
            $line =$oline." \r\n ".$url."\r\n-----------------\r\n";
            $handle = @fopen('./curl.error.log', 'a');
            fwrite($handle, $line);
            return FALSE;
        }
        return $html;
    }
}

/**
 * tarihleri türkçe yapar
 */
if (!function_exists('turkce_tarih'))
{
    function turkce_tarih($tarih)
    {
        $aylar_en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'December', 'November');
        $aylar_tur = array('Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık');

        $gunler_en = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $gunler_tr = array('Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar');

    	$tarih = str_replace($aylar_en, $aylar_tur, $tarih);
    	$tarih = str_replace($gunler_en, $gunler_tr, $tarih);
        
        return $tarih;

    }
}

/**
 * ne zaman
 */

if (!function_exists('nezaman'))
{
    function nezaman($t)
    {
        date_default_timezone_set('Europe/Istanbul');
        $date = date_create($t);
        $date=date_format($date, 'U');
        $fark=date('U')-$date;
        switch ($fark){
            case ($fark>31536000):
                $ay=bcmod($fark,31536000);
                $ay=floor($ay/2592000).' ay ';
                if ($ay<1) $ay='';
                return floor($fark/31536000).' yıl '.$ay.' önce';
                break;
            case ($fark>2592000):
                $hafta=bcmod($fark,2592000);
                $hafta=floor($hafta/604800).' hafta ';
                if ($hafta<1) $hafta='';
                return floor($fark/2592000).' ay '.$hafta.' önce';
                break;
            case ($fark>604800):
                $gun=bcmod($fark,604800);
                $gun=floor($gun/86400).' gün ';
                if ($gun<1) $gun='';
                return floor($fark/604800).' hafta '.$gun.' önce';
                break;
            case ($fark>86400):
                $saat=bcmod($fark,86400);
                $saat=floor($saat/3600).' saat ';
                if ($saat<1) $saat='';
                return floor($fark/86400).' gün '.$saat.' önce';
                break;
            case ($fark>3600):
                $dak=bcmod($fark,3600);
                $dak=floor($dak/60).' dk ';
                if($dak<1) $dak='';
                return floor($fark/3600).' saat '.$dak.' önce';
                break;
            case ($fark>60):
                $san=bcmod($fark,60);
                $san=$san.' sn ';
                if ($san<1) $san='';
                return floor($fark/60).' dk '.$san.' önce';
                break;
            case ($fark<60):
                return $fark.' sn önce';
                break;
        }
    }
}


/**
*  ping atar
*/

if (!function_exists('pingle'))
{

    function pingle($siteadi = '', $siteurl = '', $rss = '')
    {

        if (empty($siteadi) || empty($siteurl))
        {
            return FALSE;
        }

        if (empty($rss))
        {
            $url = 'http://pingomatic.com/ping/?title='. urldecode($siteadi) .'&blogurl='. urldecode($siteurl) .'&rssurl=&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_weblogalot=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on&chk_audioweblogs=on&chk_rubhub=on&chk_a2b=on&chk_blogshares=on';
        }
        else
        {
            $url = 'http://pingomatic.com/ping/?title='. urldecode($siteadi) .'&blogurl='. urldecode($siteurl) .'&rssurl='. urldecode($rss) .'&chk_weblogscom=on&chk_blogs=on&chk_feedburner=on&chk_newsgator=on&chk_myyahoo=on&chk_pubsubcom=on&chk_blogdigger=on&chk_weblogalot=on&chk_newsisfree=on&chk_topicexchange=on&chk_google=on&chk_tailrank=on&chk_skygrid=on&chk_collecta=on&chk_superfeedr=on&chk_audioweblogs=on&chk_rubhub=on&chk_a2b=on&chk_blogshares=on';
        }

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($c, CURLOPT_REFERER, 'http://pingomatic.com/');
        curl_setopt($c, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($c, CURLOPT_COOKIEFILE, 'pingomatic.txt');
        curl_setopt($c, CURLOPT_COOKIE, 1);
        $g = curl_exec($c);

        @preg_match_all('#<h2>(.*?)<\/h2>#i', $g, $cikti);

        @preg_match_all('#<td\s+class=\"result\">(.*?)<\/td>#i', $g, $out);

        if ($cikti[1][0] == 'Slow down cowboy!')
        {
            return '1';
        }
        else
        {

            $sent = array();

            foreach($out[1] as $c)
            {
                if ($c == 'Ping sent.')
                {
                    array_push($c, $sent);
                }
            }

        }

        if (count($sent) > 0)
        {
            return TRUE;
        }
        else
        {
            return '0';
        }

    }
	
}



/**
 * Breadcrumbları gösterir...
 * 
 */
if (!function_exists('navigator'))
{

	function navigator($nav = array(), $class = 'breadcrumb', $sign = '>')
	{
		
		if (!is_array($nav) || count($nav) == 0)
		{
			return '';
		}
		
		$out = '<ul class="'. $class .'">';
		
		$last = end($nav);
		
		foreach ($nav as $k => $v)
		{
			if ($last != $v)
			{
				$out .= '<li><a href="'. $v .'">'. $k .'</a> <span class="divider">'. $sign .'</span></li>';
			}
			else
			{
				$out .= '<li class="active">'. $k .'</li>';
			}	
		}
		
		$out .= '</ul>';
		
		return $out;
	}
}

/**
 * film bilgisi için helper
 */

if (!function_exists('filmbilgisi'))
{
	function filmbilgisi($bilgi)
	{
		//super değişken
		$ci =& get_instance();
				
		return $ci->film->bilgi($bilgi);		
	}
}

/**
 * uyebilgisi için helper
 */

if (!function_exists('uyebilgisi'))
{
	function uyebilgisi($bilgi)
	{
		//super değişken
		$ci =& get_instance();
		$ci->load->library('uye');
		return $ci->uye->get_uyebilgi($bilgi);
	}
}

/**
 * uye giris kontrolü için helper
 */

if (!function_exists('uye_giris_kontrol'))
{
	function uye_giris_kontrol()
	{
		//super değişken
		$ci =& get_instance();
		$ci->load->library('uye');
		return $ci->uye->giris_kontrol();
	}
}

/**
 * get_headers fonksiyonu
 */

if (!function_exists('swo_head'))
{
	function swo_head()
	{
        $CI =& get_instance();

        //kütüphaneler yükleniyor...
        $CI->load->helper('ayarlar');
        $CI->load->library('header');

        //panelden eklenen html kodları
        $headerHtml = ayar_getir('header_html');

        //sabit js dosyaları
        $script = array();

        //header oluşturuluyor...
        $header = '';
        //js'ler header'a ekleniyor...
        if (count($script) > 0):
            foreach ($script as $sc)
            {
                $header .= "<script src=\"$sc\"></script>\n";
            }
        endif;

        //clastan gelen headerlar ekleniyor..
        $render_head = $CI->header->render_head();

        //tüm veriler aktarılıyor...
        $header .= $headerHtml ."\n". $render_head;

		return $header;
	}
}

if (!function_exists('swo_foot'))
{
    function swo_foot()
    {

        $script = array(base_url('/others/assets/js/jPages.min.js'));

        $footer = '';

        if (count($script) > 0):
            foreach ($script as $sc)
            {
                $footer .= "<script src=\"$sc\"></script>\n";
            }
        endif;

        $footer .= '<script id="skyjs" src="'. base_url('/others/assets/js/skyweboffice.js?s='. base_url()).'"></script>';

        return $footer;
    }
}

/**
 *
 *  widget klasörünün içindekileri okur
 *
 *
 */
if ( ! function_exists('widget_read')) {
	
	function widget_read($file, $path = NULL){
		//super değişken
		$CI =& get_instance();
		
		//tema adı
		$theme = $CI->getSiteTheme();
		
		// path düzenlemesi.
		if (empty($path) || $path == NULL) {
			$file =  'site/'.$theme .'/views/widget/'.$file;
		} else {
			$file = $path.'/'.$file;
		}
		
		//dosya varsa
		if (!file_exists($file)) {
			
			$output = $CI->load->view($file, TRUE);
			
			return $output;
			
		} else {
			return 'Widget Yüklenemedi..!';
		}
		
	}
	
}


/**
 *  form_upload değerlerinin olup olmadığını sorgular ....
 * 
 */
if (!function_exists('validateUploadForm')) {
	function validateUploadForm($form) {
		if($_FILES[$form]['size'] == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/**
 * 
 * dolu olan dosyayı siler
 * 
 */
if (!function_exists('rrmdir')) {
	function rrmdir($dir) {
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
	       }
	     }
	     reset($objects);
	     rmdir($dir);
	   }
	 }
}

/**
 * 
 * ckeditor html taglarını temizler
 * 
 */

if (!function_exists('ckeditor_html_clear'))
{
	function ckeditor_html_clear($n) {
		$n = str_replace('&lt;/body&gt;', '', $n);
		$n = str_replace('</body>', '', $n);
		$n = str_replace('&lt;/html&gt;', '', $n);
		$n = str_replace('</html>', '', $n);
		$n = str_replace('&lt;html&gt;', '', $n);
		$n = str_replace('<html>', '', $n);
		$n = str_replace('&lt;head&gt;', '', $n);
		$n = str_replace('<head>', '', $n);
		$n = str_replace('&lt;title&gt;', '', $n);
		$n = str_replace('<title>', '', $n);
		$n = str_replace('&lt;/title>', '', $n);
		$n = str_replace('</title>', '', $n);
		$n = str_replace('&lt;/head&gt;', '', $n);
		$n = str_replace('</head>', '', $n);
		$n = str_replace('&lt;body&gt;', '', $n);
		$n = str_replace('<body>', '', $n);

		return trim($n);

	}
}


/**
 * 
 * tinymce ../ düzeltmesi
 * 
 */

if (!function_exists('tinymce_uri_duzelt')) {
	function tinymce_uri_duzelt($var){
		$a = preg_replace('~(\.\.\/)+~i', base_url(), $var);
		return $a;
	}
	
}