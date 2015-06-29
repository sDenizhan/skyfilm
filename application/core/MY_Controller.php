<?php
/**
 * Class SiteController
 */
class SiteController extends CI_Controller {

    /** Tema Değişkenleri **/
    private $site_theme;
    private $site_layout;
    private $header;
    private $footer;

    /** SEO Değişkenleri **/
    private $seo_title;
    private $seo_desc;
    private $seo_keys;

    /** User Agent Değişkenleri **/
    private $is_mobil;

    /** Cache Değişkenleri */
    private $page_cache;
    private $page_cache_time;

    /** Aile Filitresi **/
    private $family_filtre = 'acik';

    public function __construct()
    {
        parent::__construct();

        //mobile ayarı
        if ( $this->agent->is_mobile() )
        {
            $this->setIsMobil(true);
            $this->setSiteTheme(ayar_getir('site_mobile_tema'));
        }
        else
        {
            $this->setIsMobil(false);
            $this->setSiteTheme(ayar_getir('sitetheme'));
        }

        //db cache
        if ( ayar_getir('db_cache') == 'on')
        {
            $this->db->cache_on();
        }

        //page cache
        $this->setPageCache(ayar_getir('cache_status'));
        $this->setPageCacheTime(ayar_getir('cache_time'));

        //aile filitresi
        if (!$this->session->userdata('ailefilitresi'))
        {
            $this->setFamilyFiltre(ayar_getir('ailefilitresi'));
        }
        else
        {
            $this->setFamilyFiltre($this->session->userdata('ailefilitresi'));
        }

        //header ve footer
        $this->setSiteLayout('main');
        $this->setHeader('header');
        $this->setFooter('footer');
    }

    /**
     * @return mixed
     */
    public function getFamilyFiltre()
    {
        return $this->family_filtre;
    }

    /**
     * @param mixed $family_filtre
     */
    public function setFamilyFiltre($family_filtre)
    {
        $this->family_filtre = $family_filtre;
    }



    /**
     * @return mixed
     */
    public function getSiteLayout()
    {
        return $this->site_layout;
    }

    /**
     * @param mixed $site_layout
     */
    public function setSiteLayout($site_layout)
    {
        $this->site_layout = $site_layout;
    }

    /**
     * @return mixed
     */
    public function getSiteTheme()
    {
        return $this->site_theme;
    }

    /**
     * @param mixed $site_theme
     */
    public function setSiteTheme($site_theme)
    {
        $this->site_theme = $site_theme;
    }

    /**
     * @return mixed
     */
    public function getIsMobil()
    {
        return $this->is_mobil;
    }

    /**
     * @param mixed $is_mobil
     */
    public function setIsMobil($is_mobil)
    {
        $this->is_mobil = $is_mobil;
    }

    /**
     * @return mixed
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * @param mixed $seo_title
     */
    public function setSeoTitle($seo_title)
    {
        $this->seo_title = $seo_title;
    }

    /**
     * @return mixed
     */
    public function getSeoDesc()
    {
        return $this->seo_desc;
    }

    /**
     * @param mixed $seo_desc
     */
    public function setSeoDesc($seo_desc)
    {
        $this->seo_desc = $seo_desc;
    }

    /**
     * @return mixed
     */
    public function getSeoKeys()
    {
        return $this->seo_keys;
    }

    /**
     * @param mixed $seo_keys
     */
    public function setSeoKeys($seo_keys)
    {
        $this->seo_keys = $seo_keys;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param mixed $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * @return mixed
     */
    public function getPageCache()
    {
        return $this->page_cache;
    }

    /**
     * @param mixed $page_cache
     */
    public function setPageCache($page_cache)
    {
        $this->page_cache = $page_cache;
    }

    /**
     * @return mixed
     */
    public function getPageCacheTime()
    {
        return $this->page_cache_time;
    }

    /**
     * @param mixed $page_cache_time
     */
    public function setPageCacheTime($page_cache_time)
    {
        $this->page_cache_time = $page_cache_time;
    }

    function render($file, $data = null) {

        //template ayarlayalım
        $this->template->set_theme('site/' . $this->getSiteTheme());

        //layout
        $this->template->set_layout($this->getSiteLayout());

        //header ve footer
        $this->template->set_partial('header', 'inc/' . $this->getHeader());
        $this->template->set_partial('footer', 'inc/' . $this->getFooter());

        $data['_assets_url'] = base_url('themes/site/' . $this->getSiteTheme() . '/assets/');

        //seo
        $data['_title'] = $this->getSeoTitle();
        $data['_description'] = $this->getSeoDesc();
        $data['_keywords'] = $this->getSeoKeys();

        //navigator
        //$data['_navigator'] = $this->renderBreadcrumbs();

        //cache olayına bakalım....
        if ( $this->getPageCache() == 'acik' ) {

            //driveri load edelim...
            $this->load->driver('cache');

            //cache dosyasının adı ...
            $filename = md5($this->uri->uri_string());

            //cache dosyası yoksa yeni bir cache oluştursun
            //cache varsa $output değişkenine aktarsın
            if (!$output = $this->cache->file->get($filename)) {

                //make file
                $output = $this->template->build($file, $data, true);

                //cache alalım
                $this->cache->file->save($filename, $output, $this->getPageCacheTime());
            }
        } else {
            $output = $this->template->build($file, $data, true);
        }

        //çıktıyı değiştir
        $output = Assets::header($output);
        $output = Assets::footer($output);

        //çıktıyı ekrana basalım...
        $this->output->set_output($output);
    }
}

/**
 * AdminController
 *
 * @author Süleyman DENİZHAN
 * @version 1.0
 *
 */
class AdminController extends CI_Controller {

    private $page_layout = 'main';
    private $theme;
    private $header = 'header';
    private $footer = 'footer';
    public $admin_control = true;
    public $themeConfig = null;

    function __construct() {
        parent::__construct();

        //admin teması ayarlanıyor...
        $this->setTheme('admin');

        //admin girişi yapılmış mı
        if ($this->admin_control == true) {
            if ( ! $this->auth->login_control() ) {
                $this->output->set_header('Content-Type: text/html; charset=utf-8');
                echo 'Bu Sayfayı Sadece Yöneticiler Görebilir. Şimdi Anasayfaya Yönlendiriliyorsunuz..!';
                redirect(base_url());
                exit();
            }
        }

        /* Tema Ayarları Yükleniyor... */
        $this->theme_config_load();
    }

    /**
     * @return boolean
     */
    public function isAdminControl()
    {
        return $this->admin_control;
    }

    /**
     * @param boolean $admin_control
     */
    public function setAdminControl($admin_control)
    {
        $this->admin_control = $admin_control;
    }



    /**
     * Varsa temaya ait ayarları yükler...
     */
    public function theme_config_load()
    {
        $site_theme = $this->config->item('site_tema');
        if ( file_exists(APPPATH.'../themes/site/'. $site_theme .'/views/config/config.php')):
            require_once(APPPATH.'../themes/site/'. $site_theme .'/views/config/config.php');
        endif;
    }


    /**
     * Header Dosyasını Set Eder..
     *
     * @param $header header dosyasının adı
     *
     */
    function set_header($header) {
        $this->header = $header;
    }

    /**
     * 	Header Dosyasını Get Eder...
     *
     * 	@return string header dosyası adı
     */
    function get_header() {
        return $this->header;
    }

    /**
     * 	Footer'a Set Eder ...
     *
     * 	@param $footer string Footer Dosyası Adı
     *
     */
    function set_footer($footer) {
        $this->footer = $footer;
    }

    /**
     * Footer'a Get Eder...
     */
    function get_footer() {
        return $this->footer;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return string
     */
    public function getPageLayout()
    {
        return $this->page_layout;
    }

    /**
     * @param string $page_layout
     */
    public function setPageLayout($page_layout)
    {
        $this->page_layout = $page_layout;
    }



    /**
     * View Dosyasını Set Eder...
     *
     * @param $file string View Dosyasının Adı
     * @param $data array View'e Gönderiler Değişkenler
     *
     */
    function render($file, $data = null, $back = false) {

        //template ayarlayalım
        $this->template->set_theme('dash/' . $this->getTheme());

        //layout
        $this->template->set_layout($this->getPageLayout());

        //header ve footer
        $this->template->set_partial('header', 'dash/' . $this->getTheme() . '/views/inc/' . $this->get_header());
        $this->template->set_partial('footer', 'dash/' . $this->getTheme() . '/views/inc/' . $this->get_footer());

        //gerekli data
        $data['_assets_url'] = base_url('themes/dash/' . $this->getTheme() . '/assets');

        //çıktıyı aldık...
        $output = $this->template->build($file, $data, true);

        //çıktıyı değiştir
        $output = Assets::header($output);
        $output = Assets::footer($output);

        if ($back == false):
            $this->output->set_output($output);
        else:
            return $output;
        endif;
    }

}