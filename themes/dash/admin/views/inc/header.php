<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $_assets_url; ?>/images/icon.png">

    <title>Flat Dream</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $_assets_url; ?>/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $_assets_url; ?>/js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $_assets_url; ?>/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $_assets_url; ?>/js/html5shiv.js"></script>
    <script src="<?php echo $_assets_url; ?>/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo $_assets_url; ?>/js/jquery.nanoscroller/nanoscroller.css" />

    <?php echo Assets::set_header(); ?>


    <link href="<?php echo $_assets_url; ?>/css/style.css" rel="stylesheet" />



</head>
<body>

<div id="cl-wrapper" class="sb-collapsed">

    <div class="cl-sidebar">
        <div class="cl-toggle"><i class="fa fa-bars"></i></div>
        <div class="cl-navblock">
            <div class="menu-space">
                <div class="content">
                    <div class="sidebar-logo">
                        <div class="logo">
                            <a href="<?php base_url('admin/panel'); ?>"></a>
                        </div>
                    </div>
                    <ul class="cl-vnavigation">
                        <li>
                            <a href="<?php echo base_url('admin/panel'); ?>">
                                <i class="fa fa-home"></i><span>Yönetim Paneli</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>" target="_blank">
                                <i class="fa fa-smile-o"></i><span>Site Anasayfa</span>
                            </a>
                        </li>
                        <li><a href="#"><i class="fa fa-film nav-icon"></i><span>Filmler</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/filmler'); ?>">Filmler</a></li>
                                <li><a href="<?php echo base_url('admin/filmler/ekle'); ?>">Film Ekle</a></li>
                                <li><a href="<?php echo base_url('admin/filmbotu'); ?>">Film ßotları</a></li>
                                <li><a href="<?php echo base_url('admin/filmler/raporlar'); ?>">Film Raporları</a></li>
                                <li><a href="<?php echo base_url('admin/yorumlar'); ?>">Film Yorumları</a></li>
                                <li><a href="<?php echo base_url('admin/kategoriler'); ?>">Kategoriler</a></li>
                                <li><a href="<?php echo base_url('admin/kategoriler/kategoriekle'); ?>">Kategori Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-group nav-icon"></i><span>Kişi Yönetimi</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/kisiler'); ?>">Kişiler</a></li>
                                <li><a href="<?php echo base_url('admin/kisiler/ekle'); ?>">Kişi Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-rocket nav-icon"></i><span>Bot Yönetimi</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/botlar'); ?>">Botlar</a></li>
                                <li><a href="<?php echo base_url('admin/botlar/botekle'); ?>">Bot Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-play nav-icon"></i><span>Oynatıcılar</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/oynaticilar'); ?>">Oynatıcılar</a></li>
                                <li><a href="<?php echo base_url('admin/oynaticilar/ekle'); ?>">Oynatıcı Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-file-o nav-icon"></i><span>Blog</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/bloglar'); ?>">Yazılar</a></li>
                                <li><a href="<?php echo base_url('admin/bloglar/yaziekle'); ?>">Yazı Ekle</a></li>
                                <li><a href="<?php echo base_url('admin/bloglar/kategoriler'); ?>">Kategoriler</a></li>
                                <li><a href="<?php echo base_url('admin/bloglar/kategoriekle'); ?>">Kategori Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-user nav-icon"></i><span>Üyeler</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/uyeler'); ?>">Üyeler</a></li>
                                <li><a href="<?php echo base_url('admin/uyeler/mailgonder'); ?>">Üyelere Mail Gönder</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-bullhorn nav-icon"></i><span>Duyurular</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/duyurular'); ?>">Duyurular</a></li>
                                <li><a href="<?php echo base_url('admin/duyurular/duyuruekle'); ?>">Duyuru Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-envelope nav-icon"></i><span>Mesajlar</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/mesajlar'); ?>">Mesajlar</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-money nav-icon"></i><span>Reklamlar</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/reklamlar'); ?>">Reklamlar</a></li>
                                <li><a href="<?php echo base_url('admin/reklamlar/reklamekle'); ?>">Reklam Ekle</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-link nav-icon"></i><span>Bağlantılar</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/linkler'); ?>">Bağlantılar</a></li>
                                <li><a href="<?php echo base_url('admin/linkler/linkekle'); ?>">Bağlantı Ekle</a></li>
                            </ul>
                        </li>

                        <li><a href="#"><i class="fa fa-info nav-icon"></i><span>Sık Sorulan Sorular</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/sss'); ?>">Sorular</a></li>
                                <li><a href="<?php echo base_url('admin/sss/soruekle'); ?>">Soru Ekle</a></li>
                            </ul>
                        </li>

                        <li><a href="#"><i class="fa fa-wrench nav-icon"></i><span>Ayarlar</span></a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo base_url('admin/settings'); ?>">Genel Ayarları</a></li>
                                <li><a href="<?php echo base_url('admin/settings/seo_ayarlari'); ?>">Seo Ayarları</a></li>
                                <li><a href="<?php echo base_url('admin/settings/yorum_ayarlari'); ?>">Yorum Ayarları</a></li>
                                <li><a href="<?php echo base_url('admin/settings/sosyalag_ayarlari'); ?>">Sosyal Ağ Ayarları</a></li>
                                <li><a href="<?php echo base_url('admin/settings/cache_ayarlari'); ?>">Önbellekleme Ayarları</a></li>
                                <li><a href="<?php echo base_url('admin/settings/yasaluyari_ayarlari'); ?>">Yasal Uyarı Metni</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="text-right collapse-button" style="padding:7px 9px;">
                <input type="text" class="form-control search" placeholder="Search..." />
                <button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-right"></i></button>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="pcont">
        <!-- TOP NAVBAR -->
        <div id="head-nav" class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right user-nav">
                        <li class="dropdown profile_menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img alt="Avatar" src="<?php echo base_url('others/avatars/'.uyebilgisi('avatar')); ?>" width="30" height="30" /><span><?php echo uyebilgisi('adsoyad'); ?></span> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('uye_bilgileri'); ?>">Profilim</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url('cikis_yap'); ?>">Çıkış Yap</a></li>
                            </ul>
                        </li>
                    </ul>


                </div><!--/.nav-collapse animate-collapse -->
            </div>
        </div>


        <div class="cl-mcont">
            <div class="cl-mcont">