<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Genel Ayarlar</h3>
            </div>
            <div class="content">
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
        </div>
    </div>
</div>