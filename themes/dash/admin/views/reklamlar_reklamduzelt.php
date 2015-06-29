<?php echo form_open(site_url("admin/reklamlar/reklamduzeltkaydet/". $_reklam->id ."/". seoURL($_reklam->reklam_adi) .""), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="tab-container">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#reklam" data-toggle="tab">Reklam Özellikleri</a></li>
                <li><a href="#html" data-toggle="tab">HTML</a></li>
                <li><a href="#resimtext" data-toggle="tab">Resim & Text</a></li>
                <li><a href="#zamanayar" data-toggle="tab">Zaman Ayarları</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active cont" id="reklam">
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Adı</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamAdi', $_reklam->reklam_adi ,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Türü</label>
                        <div class="col-sm-10">
                            <?php
                            $_reklamTuru = array('html' => 'HTML', 'text' => 'Metin', 'banner' => 'Resim');
                            echo form_dropdown('frmReklamTuru', $_reklamTuru, $_reklam->reklam_turu,'class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Konumu</label>
                        <div class="col-sm-10">
                            <?php
                            $_reklamKonumu = array(
                                'siteust' => 'Site Üst Banner',
                                'sitealt' => 'Site Alt Banner',
                                'fragmanalt' => 'Fragman Altı',
                                'filmon' => 'Film Önü',
                                'sidebar' => 'Sidebar',
                                'afisalti' => 'Afiş Altı',
                                'filmizle1' => 'Film İzle 1',
                                'filmizle2' => 'Film İzle 2',
                                'filmalt' => 'Film Altı',
                                'filmustu' => 'Film Üstü',
                                'filmanasayfa' => 'Anasayfa',
                            );
                            echo form_dropdown('frmReklamKonumu', $_reklamKonumu, $_reklam->reklam_konumu,'class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Durumu</label>
                        <div class="col-sm-10">
                            <?php
                            $_reklamDurumu = array('aktif' => 'Aktif', 'pasif' => 'Pasif');
                            echo form_dropdown('frmReklamDurumu', $_reklamDurumu, $_reklam->durum, 'class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane cont" id="html">
                    <div class="form-group">
                        <label class="col-sm-2">HTML KODLARI GİRİNİZ</label>
                        <div class="col-sm-10">
                            <textarea rows="15" cols="100%" name="frmHTMLKodlar" id="frmHTMLKodlar" class="form-control"><?php echo $_reklam->reklam_kodu; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="resimtext">
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Resmi Adresi</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamImageAdresi', $_reklam->reklam_resmi,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Metni</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamMetni', $_reklam->reklam_metni,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Adresi</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamAdresi', $_reklam->reklam_url,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Title Açıklaması</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamAciklamasi', $_reklam->reklam_title,'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="zamanayar">
                    <div class="form-group">
                        <label class="col-sm-2">Zaman İşlevi</label>
                        <div class="col-sm-6">
                            <label class="checkbox-inline"> <input class="icheck" type="checkbox" name="frmZaman" value="Aktif" <?php if ($_reklam->zaman_aktif == 'Aktif') echo 'checked="checked"'; ?>> Aktif </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Başlangıç Zamanı</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmZamanBaslangic', $_reklam->baslangic_tarihi,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Bitiş Zamanı</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmZamanBitis', $_reklam->bitis_tarihi,'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>