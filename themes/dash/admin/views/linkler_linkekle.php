<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Link Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/linkler/linkeklekaydet'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmBaglantiAdi" class="col-sm-2 control-label">Bağlantı Adı:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAdi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmUstKategori" class="col-sm-2 control-label">Bağlantı Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAdresi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seotitle" class="col-sm-2 control-label">Bağlantı Açıklaması:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAciklamasi','','class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seokeys" class="col-sm-2 control-label">Bağlantı Türü:</label>
                        <div class="col-sm-10">
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="dofollow" checked="checked" /> DoFollow</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="nofollow" /> NoFollow</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="altarnate" /> Altarnate</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="appendix" /> Appendix</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="bookmark" /> Bookmark</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="chapter" /> Chapter</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="contents" /> Contents</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="copyright" /> Copyright</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="glossary" /> Glossary</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="help" /> Help</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="index" /> Index</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="next" /> Next</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="prev" /> Prev</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="section" /> Section</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="start" /> Start</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="stylesheet" /> Stylesheet</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="subsection" /> Subsection</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="shortcut icon" /> Shortcut Icon</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Link Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Bağlantı Türü Açıklamaları</h3>
            </div>
            <div class="content">
                <p>
                    <strong>Alternate:</strong> Bağlantının, güncel sayfanın alternatif bir sürümü olduğunu belirtir.
                    <br>
                    <strong>Appendix:</strong>  Bağlantının, güncel sayfanın bir eki olduğunu belirtir.
                    <br>
                    <strong>Bookmark:</strong>  Bağlantının, güncel sayfa ile alakalı bir yer imi olduğunu belirtir.
                    <br>
                    <strong>Chapter:</strong>  Bağlantının, sayfa dizisi içinde herhangi bir bölümü işaret ettiğini belirtir.
                    <br>
                    <strong>Contents:</strong>  Bağlantının, sayfa dizisinin İçindekiler listesinin bulunduğu kaynağı işaret ettiğini belirtir.
                    <br>
                    <strong>Copyright:</strong>  Bağlantının, güncel sayfanın telif hakkı bilgilerini içeren kaynağa işaret ettiğini belirtir.
                    <br>
                    <strong>Glossary:</strong>  Bağlantının, güncel sayfada kullanılan terimlerin açıklandığı terimler sözlüğüne işaret ettiğini belirtir.
                    <br>
                    <strong>Help:</strong>  Bağlantının, güncel sayfa ile ilgili yardım sayfasına işaret ettiğini belirtir.
                    <br>
                    <strong>Index:</strong>  Bağlantının, sayfalar dizisinin dizinine/fihristine işaret ettiğini belirtir.
                    <br>
                    <strong>Next:</strong>  Bağlantının, güncel sayfadan sonraki sayfa olduğunu belirtir.
                    <br>
                    <strong>Prev:</strong>  Bağlantının, güncel sayfadan önceki sayfa olduğunu belirtir.
                    <br>
                    <strong>Section:</strong>  Bağlantının, güncel sayfanın ana bölümüne işaret ettiğini belirtir.
                    <br>
                    <strong>Start:</strong>  Bağlantının, sayfa dizisindeki ilk sayfayı işaret ettiğini belirtir.
                    <br>
                    <strong>Stylesheet:</strong>  Bağlantının, güncel sayfanın stil şablonlarını içerdiğini belirtir.
                    <br>
                    <strong>Subsection:</strong>  Bağlantının, güncel sayfanın alt bölümüne işaret ettiğini belirtir.
                    <br>
                    <strong>Shortcut Icon:</strong>  Bağlantının, güncel sayfanın tarayıcı penceresinde ve/veya sık kullanılanlar listesinde gösterilecek ikonu olduğunu belirtir.
                    <br>
                    <strong>Nofollow:</strong>  Bağlantının, güncel sayfa ile bir ilgisinin olmadığını veya izlenmemesi gereken bir bağlantı olduğunu belirtir.
                    <br>
                    <strong>Dofollow:</strong>  Bağlantının, güncel sayfa ile bir ilgili olduğunu veya izlenmesi gereken bir bağlantı olduğunu belirtir.
                </p>
            </div>
        </div>
    </div>
</div>