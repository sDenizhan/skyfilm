<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Üye Bilgilerini Düzenle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url("admin/uyeler/uyeduzeltkaydet/". $_uye->id ."/".seoURL($_uye->kullanici_adi).""); ?>" role="form">
                    <div class="form-group">
                        <label for="frmFilmFragman" class="col-sm-2 control-label">Üye Seviyesi:</label>
                        <div class="col-sm-10">
                            <select id="frmUyeSeviye" name="frmUyeSeviye" class="form-control">
                                <option value="Admin" <?php if ($_uye->uye_seviye == "admin") echo 'selected="selected"'; ?>>Admin</option>
                                <option value="Normal" <?php if ($_uye->uye_seviye == "normal") echo 'selected="selected"'; ?>>Normal</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmKullaniciAdi" class="col-sm-2 control-label">Kullanıcı Adı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmKullaniciAdi" name="frmKullaniciAdi" value="<?php echo $_uye->kullanici_adi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmEmailAdresi" class="col-sm-2 control-label">Email Adresi:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmEmailAdresi" id="frmEmailAdresi" value="<?php echo $_uye->email; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYapimYili" class="col-sm-2 control-label">Ad Soyad:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmAdSoyad',$_uye->adsoyad,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmCinsiyet" class="col-sm-2 control-label">Cinsiyet:</label>
                        <div class="col-sm-10">
                            <select id="frmCinsiyet" name="frmCinsiyet" class="form-control">
                                <option value="Bay" <?php if ($_uye->cinsiyet == "Bay") echo 'selected="selected"'; ?>>Bay</option>
                                <option value="Bayan" <?php if ($_uye->cinsiyet == "Bayan") echo 'selected="selectd"'; ?>>Bayan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmUlke" class="col-sm-2 control-label">Meslek:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmMeslek',$_uye->meslek,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYonetmen" class="col-sm-2 control-label">Doğum Tarihi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmDogumTarihi',$_uye->dogumgunu,'class="form-control datetime"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmOyuncular" class="col-sm-2 control-label">Şehir:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSehir',$_uye->sehir,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kategori" class="col-sm-2 control-label">Üyelik Durumu:</label>
                        <div class="col-sm-10">
                            <select id="frmUyelikDurumu" name="frmUyelikDurumu" class="form-control">
                                <option value="Aktif" <?php if ($_uye->durum == "Aktif") echo 'selected="selected"'; ?>>Aktif</option>
                                <option value="Pasif" <?php if ($_uye->durum == "Pasif") echo 'selected="selected"'; ?>>Pasif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Üye Bilgilerini Düzelt</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Üye Şifresini Düzenle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url("admin/uyeler/uyesifreduzeltkaydet/". $_uye->id ."/".seoURL($_uye->kullanici_adi).""); ?>" role="form">
                    <div class="form-group">
                        <label for="frmSifre" class="col-sm-2 control-label">Üye Şifresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSifre', '','class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmSifreTekrar" class="col-sm-2 control-label">Üye Şifresi Tekrar:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSifreTekrar', '','class="form-control"'); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Üye Şifrelerini Düzelt</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>