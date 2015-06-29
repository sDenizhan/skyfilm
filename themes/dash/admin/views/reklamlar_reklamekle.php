<?php echo form_open(site_url("admin/reklamlar/reklamkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
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
                            <?php echo form_input('frmReklamAdi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Türü</label>
                        <div class="col-sm-10">
                            <?php
                            $_reklamTuru = array('html' => 'HTML', 'text' => 'Metin', 'banner' => 'Resim');
                            echo form_dropdown('frmReklamTuru', $_reklamTuru, 'html','class="form-control"');
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
                            echo form_dropdown('frmReklamKonumu', $_reklamKonumu, 'aktif','class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Durumu</label>
                        <div class="col-sm-10">
                            <?php
                            $_reklamDurumu = array('aktif' => 'Aktif', 'pasif' => 'Pasif');
                            echo form_dropdown('frmReklamDurumu', $_reklamDurumu, 'aktif','class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane cont" id="html">
                    <div class="form-group">
                        <label class="col-sm-2">HTML KODLARI GİRİNİZ</label>
                        <div class="col-sm-10">
                            <textarea rows="15" cols="100%" name="frmHTMLKodlar" id="frmHTMLKodlar" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="resimtext">
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Resmi Adresi</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamImageAdresi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Metni</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamMetni','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Adresi</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamAdresi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Reklam Title Açıklaması</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmReklamAciklamasi','','class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="zamanayar">
                    <div class="form-group">
                        <label class="col-sm-2">Zaman İşlevi</label>
                        <div class="col-sm-6">
                            <label class="checkbox-inline"> <input class="icheck" type="checkbox" checked="" name="frmZaman" value="Aktif"> Aktif </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Başlangıç Zamanı</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmZamanBaslangic','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Bitiş Zamanı</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmZamanBitis','','class="form-control"'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="submit" class="btn btn-primary">Reklamı Ekle</button>
    </div>
</div>

<?php echo form_close(); ?>