<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'skyweboffice';
$route['404_override'] = 'dortyuzdort';
$route['translate_uri_dashes'] = FALSE;


//arama classı
$route['ara'] = 'arama/index/$1';
$route['arama/autocomplete'] = 'arama/autocomplete/$1';
$route['film-ara/(:any)'] = 'arama/aramayap/$1';
$route['etiket/(:any)|etiket/(:any)/page'] = 'arama/etiket/$1';

//kategori yonlendirmeleri
$route['kategori/[a-zA-Z0-9-]+'] = 'kategoriler/kategorigoster/$1'; //-> oke
$route['kategori/[a-zA-Z-]+/page/(:num)|kategori/[a-zA-Z-]+/page'] = 'kategoriler/kategorigoster/$1/page/$2';

//uye classı
$route['uyelik/giris_yap'] = 'uyelik/uyegirisiyap/$1';
$route['uyelik/giris'] = 'uyelik/uyegirisi/$1';
$route['uyelik/kayit'] = 'uyelik/uyeol/$1';
$route['uyelik/kaydet'] = 'uyelik/uyekaydet/$1';
$route['uyelik/cikis'] = 'uyelik/cikisyap';
$route['uyelik/profil'] = 'uyelik/uyebilgileri/$1';
$route['uyelik/profil/guncelle'] = 'uyelik/uyebilgisiguncelle/$1';
$route['uyelik/profil/sifre_guncelle'] = 'uyelik/sifreguncelle/$1';
$route['uyelik/liste'] = 'uyelik/filmlistesi/$1';
$route['uyelik/liste/ekle'] = 'uyelik/listemeekle/$1';
$route['uyelik/liste/cikar'] = 'uyelik/listedencikar/$1';
$route['uyelik/yorumlar'] = 'uyelik/uyeyorumlar/$1';
$route['uyelik/yorumlar/sil'] = 'uyelik/yorumsil/$1';
$route['uyelik/kayip_sifre'] = 'uyelik/sifremiunuttum/$1';
$route['uyelik/kayip_sifre/gonder'] = 'uyelik/sifremigonder/$1';

//sabit sayfalar
$route['sayfalar/yasal_uyari'] = 'sabitsayfalar/yasaluyari';

//blog classı
$route['blog/oku/(:num)-(:any)'] = 'blog/oku/$1';
$route['bloglar|bloglar/page/'] = 'blog/index/$1';

//duyurular
$route['duyurular/oku/(:num)-(:any)'] = 'duyurular/oku/$1';
$route['duyurular-(:num)-(:any)'] = 'duyurular/index/$1';
$route['duyurular|duyurular/page/'] = 'duyurular/index/$1';

//sss
$route['sss|sss/page/'] = 'sss/index/$1';

//bağlantı
$route['git/(:num)-(:any)'] = 'baglanti/git/$1';

//İLETİSİM
$route['iletisim'] = 'iletisim/index';
$route['iletisimkaydet'] = 'iletisim/iletisimkaydet/$1';


//filmler yönlendirmeleri
$route['yorumkaydet'] = 'filmler/yorumekle/$1'; //-> yorum kaydetme sayfası
$route['filmler|filmler/page/(:any)'] = 'filmler/index/$1';
$route['filmizlenmiyor'] = 'filmler/filmizlenmiyor';
$route['begen'] = 'filmler/begen/$1';
$route['begenme'] = 'filmler/begenme/$1';

//sitemap
$route['(sitemap.xml|sitemap_index.xml)'] = 'sitemap/index/';
$route['(film-sitemap-(:num).xml|film-sitemap.xml)'] = 'sitemap/filmler/$1';
$route['(resimler-sitemap-(:num).xml|resimler-sitemap.xml)'] = 'sitemap/images/$1';
$route['(etiket-sitemap-(:num).xml|etiket-sitemap.xml)'] = 'sitemap/tags/$1';
$route['(kategori-sitemap-(:num).xml|kategori-sitemap.xml)'] = 'sitemap/category/$1';
$route['(duyuru-sitemap-(:num).xml|duyuru-sitemap.xml)'] = 'sitemap/duyurular/$1';
$route['(blogs-sitemap-(:num).xml|blogs-sitemap.xml)'] = 'sitemap/bloglar/$1';
$route['(siksorulansorular-sitemap-(:num).xml|siksorulansorular-sitemap.xml)'] = 'sitemap/sss/$1';
$route['(pages-sitemap-(:num).xml|pages-sitemap.xml)'] = 'sitemap/pages/$1';

//rss
$route['rss-filmler.xml|rss.xml'] = 'sitemap/film_rss/$1';

//robots.txt
$route['robots.txt'] = 'sitemap/robots/';

//film izle sayfası için route kuralı... en altta bulunmalı !!
$route['film/([a-zA-Z0-9-]+|film/[a-zA-Z0-9-]+/alternatif-(:num)|film/[a-zA-Z0-9-]+/alternatif-(:num)/part-(:num))'] = 'filmler/filmizle/$1';
