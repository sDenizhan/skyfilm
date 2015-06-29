<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3><?php echo $_mesajlar->konu; ?></h3>
                <i>Bu mesaj <strong><?php echo date('d/m/Y H:i:s', $_mesajlar->tarih); ?></strong> tarihinde <strong><?php echo $_mesajlar->ad.' '.$_mesajlar->soyad; ?> </strong> tarafından gönderildi.</i>
            </div>
            <div class="content">
                <?php echo $_mesajlar->mesaj; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Mail ile Cevapla</h3>
            </div>
            <div class="content">
                <?php echo form_open(base_url("admin/mesajlar/cevapgonder/". $_mesajlar->id ."/".seoURL($_mesajlar->konu).""), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                <div class="form-group">
                    <label class="col-sm-2">Gönderen Ad ve Soyadı</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="frmGonderenAdi" name="frmGonderenAdi" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Alıcı Ad ve Soyadı</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="frmAliciAdSoyad" name="frmAliciAdSoyad" value="<?php echo $_mesajlar->ad.' '.$_mesajlar->soyad; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Alıcı Email Adresi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="frmAliciEmail" name="frmAliciEmail" value="<?php echo $_mesajlar->email; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Mesaj Konusu:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="frmKonu" name="frmKonu" value="<?php echo 'RE:'.$_mesajlar->konu; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Mesajınız:</label>
                    <div class="col-sm-10">
                        <textarea rows="15" cols="100%" name="frmMesaj" id="frmMesaj" class="form-control"><?php echo "\n\n\n----------------------- Orjinal Metin ------------------\n".$_mesajlar->mesaj; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>