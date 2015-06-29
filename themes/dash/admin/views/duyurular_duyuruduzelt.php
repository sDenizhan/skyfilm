<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Duyuru Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url("admin/duyurular/duyuruduzeltkaydet/".$_news->row()->id."/".$_news->row()->baslik.""); ?>" role="form">
                    <div class="form-group">
                        <label for="frmHaberBaslik" class="col-sm-2 control-label">Duyuru Başlık:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmHaberBaslik', $_news->row()->baslik,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmHaberIcerik" class="col-sm-2 control-label">Duyuru İçerik:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" cols="100%" name="frmHaberIcerik" class="form-control" id="ckeditor"><?php echo $_news->row()->icerik; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmTur" class="col-sm-2 control-label">Haber Türü:</label>
                        <div class="col-sm-10">
                            <?php $tur = array('normal' => 'Normal', 'manset' => 'Manşet'); ?>
                            <?php echo form_dropdown('frmTur', $tur, $_news->row()->tur, 'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmResimKullan" class="col-sm-2 control-label">Resim Kullan:</label>
                        <div class="col-sm-10">
                            <?php $resim = array('hayir' => 'Hayır', 'evet' => 'Evet'); ?>
                            <?php echo form_dropdown('frmResimKullan', $resim, 'hayir', 'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmHaberResim" class="col-sm-2 control-label">Duyuru Resmi:</label>
                        <div class="col-sm-10">
                            <?php echo form_upload('frmHaberResim', $_news->row()->resim,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmEtiket" class="col-sm-2 control-label">Haber Etiketi:</label>
                        <div class="col-sm-10">
                            <?php
                            if ($_etiketler != FALSE) {
                                echo form_input('frmEtiket', $_etiketler,'class="form-control"');
                            } else {
                                echo form_input('frmEtiket', '','class="form-control"');
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Duyuru Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>