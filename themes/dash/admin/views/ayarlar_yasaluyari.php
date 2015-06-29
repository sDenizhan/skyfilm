<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Önbellekleme Ayarları</h3>
            </div>
            <div class="content">

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