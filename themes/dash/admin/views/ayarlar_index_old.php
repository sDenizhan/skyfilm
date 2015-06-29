<div class="row">

<div class="col-sm-12 col-md-12 col-lg-12">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#genelayarlar" data-toggle="tab">Site Genel Ayarları</a></li>
            <li><a href="#seoayarlari" data-toggle="tab">Seo Ayarları</a></li>
            <li><a href="#yorumayarlari" data-toggle="tab">Yorum Ayarları</a></li>
            <li><a href="#agayarlari" data-toggle="tab">Sosyal Ağ Ayarları</a></li>
            <li><a href="#facebook" data-toggle="tab">Facebook AutoPost Ayarları</a></li>
            <li><a href="#onbellek" data-toggle="tab">Önbellek Ayarları</a></li>
            <li><a href="#yasaluyari" data-toggle="tab">Yasal Uyarı Metni</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active cont" id="genelayarlar">
                <h3 class="hthin">Genel Ayarlar</h3>
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/settings/genelayarlarkaydet'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmSiteAdi" class="col-sm-2">Site Adı:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSiteAdi', ayar_getir('siteadi'),'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmPlayerKod" class="col-sm-2">Site Teması:</label>
                        <div class="col-sm-10">
                            <?php
                            $theme = ayar_getir('sitetheme');

                            echo '<select name="frmTemalar" id="frmTemalar" class="form-control">';
                            foreach ($_temalar as $_key => $_value) {
                                if ($_value != 'admin')
                                {
                                    if ($_value == $theme) {
                                        echo '<option value="'. $_value .'" selected="selected">'. $_value .'</option>';
                                    } else {
                                        echo '<option value="'. $_value .'">'. $_value .'</option>';
                                    }
                                }
                            }
                            echo '</select>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Anasayfa Görünümü: </label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('normal' => 'Normal', 'afis_gorunum' => 'Afiş Görünüm');
                            echo form_dropdown('frmIndexTuru', $options, ayar_getir('index_turu'),'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Header'e Ekle: </label>
                        <div class="col-sm-10">
                            <?php echo form_textarea('frmHeaderHTML', ayar_getir('header_html'),'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Footer'a Ekle: </label>
                        <div class="col-sm-10">
                            <?php echo form_textarea('frmFooterHTML', ayar_getir('footer_html'),'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Anasayfada Gösterilecek Film Sayısı: </label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmAnasayfaFilmAdedi', ayar_getir('anasayfa_kayit_sayisi'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Filmler Sayfasında Gösterilecek Film Sayısı:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmFilmKayitSayisi', ayar_getir('filmler_kayit_sayisi'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Aile Filitresi</label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('acik' => 'Açık', 'kapali' => 'Kapalı');
                            echo form_dropdown('frmAileFilitresi', $options, ayar_getir('ailefilitresi'),'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Aktivasyon Maili Gönderilsin mi ?</label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                            echo form_dropdown('frmAktivasyonMaili', $options, ayar_getir('aktivasyonMaili'),'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2">Anasayfa Görünümü: </label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('normal' => 'Normal', 'afis_gorunum' => 'Afiş Görünüm');
                            echo form_dropdown('frmIndexTuru', $options, ayar_getir('index_turu'),'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- seo ayarları -->
            <div class="tab-pane cont" id="seoayarlari">
                <h2>Seo Ayarları</h2>
                <?php echo form_open(site_url("admin/ayarlar/seoayarkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2">Site Titlesi</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmSiteTitle',ayar_getir('sitetitle'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Site Anahtar Kelimeleri</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea('frmSiteKeywords', ayar_getir('sitekeywords'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Site Açıklaması (Description)</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea('frmSiteDescription', ayar_getir('sitedescription'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <!-- yorum ayarları -->
            <div class="tab-pane" id="yorumayarlari">

            </div>

            <!-- ağ ayarları -->
            <div class="tab-pane" id="agayarlari">
                <?php echo form_open(site_url("admin/ayarlar/sosyalagkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2">Facebook Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmFacebookAdresi',ayar_getir('facebook_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Twitter Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmTwitterAdresi',ayar_getir('twitter_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Youtube Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmYoutubeAdresi',ayar_getir('youtube_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Digg Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmDiggAdresi',ayar_getir('digg_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">RSS Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmRSSAdresi',ayar_getir('rss_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Site Haritası Adresi:</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmSitemapAdresi',ayar_getir('sitemap_address'),'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <!-- facebook ayarları -->
            <div class="tab-pane cont" id="facebook">

            </div>


            <!-- on bellek ayarları -->
            <div class="tab-pane" id="onbellek">
                <?php echo form_open(site_url("admin/ayarlar/cachekaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2">Önbellekleme Durumu:</label>
                    <div class="col-sm-10">
                        <?php
                        $options = array('ON' => 'Açık', 'OFF' => 'Kapalı');
                        echo form_dropdown('frmCacheStatus',$options,ayar_getir('cache_status'),'class="form-control"');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Önbellek Süresi (Dakika):</label>
                    <div class="col-sm-10">
                        <?php echo form_input('frmCacheTime',ayar_getir('cache_time'), 'class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <!-- yasal uyari ayarları -->
            <div class="tab-pane" id="yasaluyari">
                <?php echo form_open(site_url("admin/ayarlar/yasaluyarikaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2">Yasal Uyarı Metni:</label>
                    <div class="col-sm-10">
                        <?php echo form_textarea('frmYasalUyari',ayar_getir('yasal_uyari'), 'class="form-control" id="ckeditor"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>