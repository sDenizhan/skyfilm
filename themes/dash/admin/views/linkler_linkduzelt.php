<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Link Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/linkler/linkduzeltkaydet/'.$link->id.'/'. seoURL($link->ad) .''); ?>" role="form">
                    <div class="form-group">
                        <label for="frmBaglantiAdi" class="col-sm-2 control-label">Bağlantı Adı:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAdi', $link->ad,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmUstKategori" class="col-sm-2 control-label">Bağlantı Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAdresi', $link->url,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seotitle" class="col-sm-2 control-label">Bağlantı Açıklaması:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmBaglantiAciklamasi', $link->aciklama,'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seokeys" class="col-sm-2 control-label">Bağlantı Türü:</label>
                        <div class="col-sm-10">
                            <?php $rel = explode(' ', $link->rel); ?>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="dofollow" <?php if (in_array('dofollow', $rel)) { echo 'checked="checked"'; } ?> /> DoFollow</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="nofollow" <?php if (in_array('nofollow', $rel)) { echo 'checked="checked"'; } ?> /> NoFollow</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="altarnate" <?php if (in_array('altarnate', $rel)) { echo 'checked="checked"'; } ?> /> Altarnate</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="appendix" <?php if (in_array('appendix', $rel)) { echo 'checked="checked"'; } ?> /> Appendix</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="bookmark" <?php if (in_array('bookmark', $rel)) { echo 'checked="checked"'; } ?> /> Bookmark</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="chapter" <?php if (in_array('chapter', $rel)) { echo 'checked="checked"'; } ?> /> Chapter</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="contents" <?php if (in_array('contents', $rel)) { echo 'checked="checked"'; } ?> /> Contents</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="copyright" <?php if (in_array('copyright', $rel)) { echo 'checked="checked"'; } ?> /> Copyright</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="glossary" <?php if (in_array('glossary', $rel)) { echo 'checked="checked"'; } ?> /> Glossary</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="help" <?php if (in_array('help', $rel)) { echo 'checked="checked"'; } ?> /> Help</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="index" <?php if (in_array('index', $rel)) { echo 'checked="checked"'; } ?> /> Index</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="next" <?php if (in_array('next', $rel)) { echo 'checked="checked"'; } ?> /> Next</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="prev" <?php if (in_array('prev', $rel)) { echo 'checked="checked"'; } ?> /> Prev</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="section" <?php if (in_array('section', $rel)) { echo 'checked="checked"'; } ?> /> Section</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="start" <?php if (in_array('start', $rel)) { echo 'checked="checked"'; } ?>/> Start</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="stylesheet" <?php if (in_array('stylesheet', $rel)) { echo 'checked="checked"'; } ?> /> Stylesheet</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="subsection" <?php if (in_array('subsection', $rel)) { echo 'checked="checked"'; } ?> /> Subsection</label>
                            <label class="checkbox-inline"><input class="icheck" type="checkbox" name="frmBaglantiTuru[]" id="frmBaglantiTuru[]" value="shortcut icon" <?php if (in_array('shortcut icon', $rel)) { echo 'checked="checked"'; } ?> /> Shortcut Icon</label>
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