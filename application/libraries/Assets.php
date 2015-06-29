<?php
if ( ! defined('BASEPATH')) die('Go Home Yankyy');

class Assets
{
    private static $ci;

    private static $js = array();
    private static $css = array();
    private static $metas = array();
    private static $html = array();

    /**
     * Header ve Footer İçin Tanımlayıcı Kelimeler
     * @var string
     */
    public static $header_key = '<!--HEADER-->';
    public static $footer_key = '<!--FOOTER-->';


    /**
     * CSS ve JS Kütüphaneleri
     *
     * @var array
     */
    public static $libs = array(
        'font-awesome' => array(
            'css' => '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'
        )
    );

    public static $base_path;

    function __construct()
    {
        self::$ci =& get_instance();

        if ( function_exists('base_url') )
        {
            self::$ci->load->helper('url');
        }

        self::$base_path = base_url('/assets/');
    }

    /**
     * Temadaki Footer Noktası
     * @return string
     */

    public static function set_footer()
    {
        return self::$footer_key;
    }

    /**
     * Temadaki Header Noktası
     * @return string
     */
    public static function set_header()
    {
        return self::$header_key;
    }

    /**
     * Dosya Ekleme Fonksiyonu...
     *
     * @param $file
     * @param string $type
     * @param string $position
     * @param bool $url
     * @return string
     */
    public static function add_file($file, $type = 'js', $position = 'header', $url = false)
    {

        if ( $file == '' || empty($file))
            return '';

        if ( empty($position))
            $position = 'header';

        //js dosyaları ekleniyor...
        if ( $type == 'js')
        {
            if ( $url == false )
            {
                self::$js[$position][] = '<script type="text/javascript" src="'. self::$base_path .'/js/'. $file .'.js"></script>';
            }
            else
            {
                self::$js[$position][] = '<script type="text/javascript" src="'. $file .'"></script>';
            }
        }

        //css dosyaları ekleniyor...
        if ( $type == 'css')
        {
            if ( $url == false )
            {
                self::$css[$position][] = '<link rel="stylesheet" href="'. self::$base_path .'/css/'. $file .'.css" type="text/css" />';
            }
            else
            {
                self::$css[$position][] = '<link rel="stylesheet" href="'. $file .'" type="text/css" />';
            }
        }
    }

    /**
     * Javascript Dosyaları Eklemek İçin Kısayol
     * @param string $file
     * @param string $position
     * @param boolean $url
     */
    public static function add_js( $file, $position, $url = false)
    {
        self::add_file($file, $type='js', $position, $url);
    }

    /**
     * Çoklu Javascript Dosyaları Eklemek İçin Kısayol
     * @param array $files
     * @param string $position
     * @param boolean $url
     */
    public static function add_multiple_js( $files = array(), $position, $url = false)
    {
        if ( count($files) > 0 )
        {
            foreach($files as $file)
            {
                self::add_file($file, $type='js', $position, $url);
            }
        }
    }

    /**
     * CSS Dosyası Ekler...
     *
     * @param $file
     * @param string $position
     * @param $url
     */
    public static function add_css($file, $position = 'header', $url = false)
    {
        self::add_file($file, $type='css', $position, $url);
    }

    /**
     * Multi CSS Dosyası Ekler
     *
     * @param array $files
     * @param string $position
     * @param boolean $url
     */
    public static function add_multiple_css($files = array(), $position = 'header', $url = false)
    {
        if ( count($files) > 0 )
        {
            foreach($files as $file)
            {
                self::add_file($file, $type='css', $position, $url);
            }
        }
    }

    /**
     * Headera/Footera HTML Kod Eklemek İçin
     *
     * @param $abc
     * @param string $position
     */
    public static function set_html($abc, $position = 'footer')
    {
        if ( !empty( $abc ))
        {
            self::$html[$position] = $abc;
        }
    }

    /**
     * Header Metalarını Ayarlar
     * @param array $metas
     */
    public static function add_meta( $metas = array())
    {
        if ( count($metas) > 0 )
        {
            //1. dizin...
            foreach($metas as $tag => $values)
            {
                if ( $tag == 'meta' )
                {
                    foreach ( $values as $val)
                    {
                        $m = '<meta ';
                        foreach( $val as $k => $v)
                        {
                            $m .= $k .'="'.$v.'" ';
                        }
                        $m .= '/>';

                        self::$metas[] = $m."\n";
                    }
                }
                else
                {
                    foreach ( $values as $val) {
                        $m = '<link ';
                        foreach ($val as $k => $v) {
                            $m .= $k . '="' . $v . '" ';
                        }
                        $m .= '/>';

                        self::$metas[] = $m."\n";
                    }
                }
            }
        }
    }

    /**
     * Font, CSS ve JS Kütüphaneleri Ekler
     *
     * @param string $library
     * @param string $konum
     * @return string
     */
    public static function library($library = '', $konum = 'footer')
    {
        if ( empty($library) )
        {
            return '';
        }

        //kütüphane varsa
        if ( array_key_exists($library, self::$libs) )
        {
            foreach(self::$libs[$library] as $type => $url)
            {
                if ( $type == 'css' )
                {
                    self::add_css( $url, $konum, true);
                }
                else
                {
                    self::add_js( $url, $konum, true);
                }
            }
        }
        else
        {
            return '';
        }
    }

    /**
     * KCFinder
     */
    public static function set_kcfinder()
    {
        self::start_js();

        echo "function SkyFileManager(field, target) {
                window.KCFinder = {
                    callBack: function(url) {
                        var img = document.getElementById('skyfile_img');
                        if ( img )
                        {
                            img.src = url;
                            img.style.display = 'block';
                        }
                        document.getElementById(target).value = url;
                        window.KCFinder = null;
                    }
                };
                window.open('/assets/skyfile/browse.php?type=files&dir=files/public', 'kcfinder_textbox',
                    'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
                    'resizable=1, scrollbars=0, width=800, height=600'
                );
            }
            ";

        self::end_js('header');
    }
    /**
     * JavaScript Kodunu Tamponda Tutalım..
     */
    public static function start_js()
    {
        ob_start();
    }

    /**
     * Javascript Kodunu Tampondan Alıp Kaldıralım
     * @param string $position
     */
    public static function end_js( $position = 'footer ')
    {

        $content = ob_get_contents();
        ob_end_clean();

        //script clean
        $content = trim($content, '<script>');
        $content = trim($content, '</script>');
        //$content = strip_tags($content);

        self::$js[$position][] = '<script>'. $content .'</script>';
    }

    /**
     * HTML taglarını return eder..
     *
     * @param string $position
     * @param string $part
     * @return string
     */
    public static function _render( $position = 'header', $part = 'all' )
    {
        //pozisyon kontrolu...
        $position = empty($position) ? 'header' : $position;

        //javascriptler
        $js_html = "<!-- Skyweoffice JS ( $position ) -->\n";
        if ( array_key_exists($position, self::$js))
        {
            foreach(self::$js[$position] as $js)
            {
                $js_html .= "$js\n";
            }
        }


        //css files..
        $css_html = "<!-- Skyweoffice CSS ( $position ) -->\n";
        if ( array_key_exists($position, self::$css))
        {
            foreach(self::$css[$position] as $css)
            {
                $css_html .= "$css\n";
            }
        }

        //metas
        if ( $position == 'header')
        {
            $meta_html = "<!-- Skyweboffice Meta ( $position) -->\n";
            foreach(self::$metas as $key => $meta)
            {
                $meta_html .= "$meta\n";
            }
        }
        else
        {
            $meta_html = '';
        }

        //html kodlarımız
        $_html = "<!-- Skyweboffice HTML ( $position ) -->\n";
        if ( array_key_exists($position, self::$html))
        {
            foreach(self::$html[$position] as $html)
            {
                $_html .= "$html\n";
            }
        }


        //neresi isteniyorsa orayı yollayalım...
        switch ( $part )
        {
            case 'js':
                return $js_html;
                break;

            case 'css':
                return $css_html;
                break;

            case 'meta':
                return $meta_html;
                break;

            default:
                return $meta_html."\n".$css_html."\n".$js_html."\n".$_html."\n";
        }
    }

    /**
     * Header İçin Çıktı Fonksiyonu...
     *
     * @param $cikti
     * @param string $part
     * @return mixed
     */
    public static function header($cikti, $part = 'all')
    {
        //header html taglarını alalım....
        $html = self::_render('header', $part);

        //değiştirme kodunu yazalım..
        $rule = '/'. self::$header_key .'/i';

        //değiştirelim...
        $cikti = preg_replace($rule, $html, $cikti);

        //yeni çıktıyı return edelim...
        return $cikti;
    }

    /**
     * Footer İçin HTML Çıktıları
     *
     * @param $cikti
     * @param string $part
     * @return mixed
     */
    public static function footer($cikti, $part = 'all')
    {
        //footer html taglarını alalım....
        $html = self::_render('footer', $part);

        //değiştirme kodunu yazalım..
        $rule = '/'. self::$footer_key .'/i';

        //değiştirelim...
        $cikti = preg_replace($rule, $html, $cikti);

        //yeni çıktıyı return edelim...
        return $cikti;
    }
}