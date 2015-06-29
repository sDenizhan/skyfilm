<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Soru Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url("admin/sss/sorukaydet"); ?>" role="form">
                    <div class="form-group">
                        <label for="frmSoru" class="col-sm-2 control-label">Soru:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSoru', '','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmSoruAciklamasi" class="col-sm-2 control-label">Soru Açıklaması:</label>
                        <div class="col-sm-10">
                            <?php echo form_textarea('frmSoruAciklamasi', '','class="form-control ckeditor"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmSoruEtiketleri" class="col-sm-2 control-label">Soru Etiketleri:</label>
                        <div class="col-sm-10">
                            <?php echo form_textarea('frmSoruEtiketleri', '','class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Soru Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

