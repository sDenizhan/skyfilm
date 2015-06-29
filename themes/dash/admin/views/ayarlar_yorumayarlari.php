<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Yorum Ayarları</h3>
            </div>
            <div class="content">
            <?php echo form_open(site_url("admin/settings/yorumayarkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
            <div class="form-group">
                <label class="col-sm-2">Filmlere Yorum Yapılsın mı?</label>
                <div class="col-sm-10">
                    <?php
                    $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                    echo form_dropdown('frmFilmYorum', $options, ayar_getir('yorumAcik'),'class="form-control"');
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Üye Olmayanlar Yorum Yapsın mı?</label>
                <div class="col-sm-10">
                    <?php
                    $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                    echo form_dropdown('frmPublicComment', $options, ayar_getir('publicComment'),'class="form-control"');
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Yorum İçin Onay Gerekli Mi?</label>
                <div class="col-sm-10">
                    <?php
                    $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                    echo form_dropdown('frmYorumOnay', $options, ayar_getir('yorumOnay'),'class="form-control"');
                    ?>
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