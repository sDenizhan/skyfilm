<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Yazı Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/bloglar/yaziduzeltkaydet/'. $_blog->id .'/'. seoURL($_blog->baslik)); ?>" role="form">
                    <div class="form-group">
                        <label for="frmYaziBaslik" class="col-sm-2 control-label">Yazı Başlık:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmYaziBaslik', $_blog->baslik,'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYaziOzet" class="col-sm-2 control-label">Yazı Özeti:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" cols="100%" name="frmYaziOzet" class="form-control ckeditor" id="ckeditor"><?php echo $_blog->ozet; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYaziIcerik" class="col-sm-2 control-label">Yazı İçerik:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" cols="100%" name="frmYaziIcerik" class="form-control ckeditor" id="ckeditor"><?php echo $_blog->icerik; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmDurum" class="col-sm-2 control-label">Yazı Durumu:</label>
                        <div class="col-sm-10">
                            <?php $tur = array('Aktif' => 'Aktif', 'Pasif' => 'Pasif'); ?>
                            <?php echo form_dropdown('frmDurum', $tur, $_blog->durum, 'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmResimKullan" class="col-sm-2 control-label">Resim Kullan:</label>
                        <div class="col-sm-10">
                            <?php $tur = array('hayir' => 'Hayır', 'evet' => 'Evet'); ?>
                            <?php echo form_dropdown('frmResimKullan', $tur, 'hayir', 'class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYaziResim" class="col-sm-2 control-label">Yazı Resmi:</label>
                        <div class="col-sm-10">
                            <?php echo form_upload('frmYaziResim', '','class="form-control"'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmEtiket" class="col-sm-2 control-label">Kategori Seçini:</label>
                        <div class="col-sm-10">
                            <?php
                            if ($_cats != FALSE) {
                                $_blogCats = json_decode($_blog->kategori_id);
                                echo '<select id="kategori[]" name="kategori[]" multiple="multiple" class="form-control" size="15">';
                                foreach ($_cats->result() as $_row) {

                                    $sec = (in_array($_row->id, $_blogCats)) ? 'selected="selected"' : '';

                                    echo '<option value="'. $_row->id .'"  '.$sec.'>'. $_row->kategori_adi .'</option>';

                                    // alt kategoriler
                                    foreach ($_altkat->result() as $_r) {
                                        $s = (in_array($_r->id, $_blogCats)) ? 'selected="selected"' : '';

                                        if ($_r->ust_kategori_id == $_row->id ) {
                                            echo '<option value="'. $_r->id .'"  '.$sec.'>'. $_row->kategori_adi .' -> '. $_r->kategori_adi .'</option>';
                                        }
                                    }

                                }
                                echo "</select>";
                            }
                            else
                            {
                                echo 'Kategori Eklemelisiniz.';
                            }

                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmEtiket" class="col-sm-2 control-label">Yazı Etiketi:</label>
                        <div class="col-sm-10">
                            <?php echo form_textarea('frmEtiket', $_etiketler,'rows="10" class="form-control tagsInput"'); ?>
                            <?php echo form_hidden('frmEtiketCash', $_etiketler); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Yazı Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>