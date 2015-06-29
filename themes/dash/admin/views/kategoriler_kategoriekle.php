<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Kategori Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/kategoriler/kategorikaydet'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmKategoriAdi" class="col-sm-2 control-label">Kategori Adı</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmKategoriAdi" name="frmKategoriAdi" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmUstKategori" class="col-sm-2 control-label">Üst Kategori</label>
                        <div class="col-sm-10">
                            <select id="frmUstKategori" name="frmUstKategori" class="form-control">
                                <option value="0">Ana Kategori</option>
                                <?php
                                if (isset($_ustkat)) {
                                    foreach ($_ustkat->result() as $_row) {
                                        // üst kategoriler
                                        echo "<option value=". $_row->id ."|".$_row->kategori_adi .">".$_row->kategori_adi ."</option>";

                                        foreach ($_altkat->result() as $_r) {
                                            if ($_r->ust_kategori_id == $_row->id ) {
                                                echo "<option value=". $_r->id ."|".$_r->kategori_adi ."> ". $_row->kategori_adi ." -> ".$_r->kategori_adi ."</option>";
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seotitle" class="col-sm-2 control-label">Seo Başlık</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="seotitle" name="seotitle" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seokeys" class="col-sm-2 control-label">Seo Anahtar Kelimeler</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="seokeys" name="seokeys" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="seodesc" class="col-sm-2 control-label">SEO Açıklaması</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="seodesc" name="seodesc" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Kategoriyi Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>