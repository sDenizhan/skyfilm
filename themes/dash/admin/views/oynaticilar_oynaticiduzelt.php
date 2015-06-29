<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Oynatıcı Düzelt</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url("admin/oynaticilar/oynaticiduzeltkaydet/".$_player->row()->id."/"); ?>" role="form">
                    <div class="form-group">
                        <label for="frmPlayerAdi" class="col-sm-2 control-label">Oynatıcı Adı</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmPlayerAdi" name="frmPlayerAdi" value="<?php echo $_player->row()->oynatici_adi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmPlayerKod" class="col-sm-2 control-label">Oynatıcı Kodları:</label>
                        <div class="col-sm-10">
                            <textarea rows="15" cols="100%" class="form-control" name="frmPlayerKod" id="frmPlayerKod"><?php echo html_entity_decode($_player->row()->oynatici_kodu); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Yazdırma Seçenekleri: </label>
                        <div class="col-sm-3">
                            <label class="checkbox-inline"> <input class="icheck" type="checkbox" name="frmOnlyDB"> Sadece Veritabanına Kaydet</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Oynatıcıyı Düzelt</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>