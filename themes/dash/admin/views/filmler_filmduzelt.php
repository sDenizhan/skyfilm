<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Film Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/filmler/filmduzeltkaydet/'. $_film->id .'/'.seoURL($_film->film_adi) .''); ?>" role="form">
                    <div class="form-group">
                        <label for="filmadi" class="col-sm-2 control-label">Film Adı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="filmadi" name="filmadi" value="<?php echo $_film->film_adi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmOrjinalAdi" class="col-sm-2 control-label">Film Orjinal Adı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmOrjinalAdi" id="frmOrjinalAdi" value="<?php echo $_film->film_orj_adi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYapimYili" class="col-sm-2 control-label">Yapım Yılı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmYapimYili" id="frmYapimYili" value="<?php echo $_film->yil; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmUlke" class="col-sm-2 control-label">Ülke:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmUlke" id="frmUlke" value="<?php echo $_film->ulke; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmYonetmen" class="col-sm-2 control-label">Yönetmen:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmYonetmen" id="frmYonetmen" value="<?php echo $_film->yonetmen; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmOyuncular" class="col-sm-2 control-label">Oyuncular:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmOyuncular" id="frmOyuncular" value="<?php echo $_film->oyuncular; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmGosterimTarihi" class="col-sm-2 control-label">Gösterim Tarihi:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmGosterimTarihi" id="frmGosterimTarihi" value="<?php echo $_film->gosterim_tarihi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmTurkiyeGosterimTarihi" class="col-sm-2 control-label">Türkiye Gösterim Tarihi:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmTurkiyeGosterimTarihi" id="frmTurkiyeGosterimTarihi" value="<?php echo $_film->turkiye_tarihi; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmFilmSuresi" class="col-sm-2 control-label">Film Süresi:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmFilmSuresi" id="frmFilmSuresi" value="<?php echo $_film->sure; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmFilmResmi" class="col-sm-2 control-label">Film Resmi:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmFilmResmi" id="frmFilmResmi" value="<?php echo $_film->resim; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmFilmKonusu" class="col-sm-2 control-label">Film Konusu:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmFilmKonusu" id="frmFilmKonusu"><?php echo $_film->konu; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmFilmFragman" class="col-sm-2 control-label">Film Fragmanı:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmFilmFragman" id="frmFilmFragman"><?php echo $_film->fragman; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kategori" class="col-sm-2 control-label">Kategoriler:</label>
                        <div class="col-sm-10">
                            <?php
                            $_filmKategorileri = explode(',', $_film->kategori_id);

                            if (isset($_ustkat)) {
                                echo '<select id="kategori[]" name="kategori[]" multiple="multiple" size="15" class="form-control">';
                                foreach ($_ustkat->result() as $_row) {
                                    // üst kategoriler
                                    if (in_array($_row->id, $_filmKategorileri)) :
                                        echo '<option value="'. $_row->id .'" selected="selected">'. $_row->kategori_adi .'</option>';
                                    else:
                                        echo '<option value="'. $_row->id .'">'. $_row->kategori_adi .'</option>';
                                    endif;

                                    // alt kategoriler
                                    foreach ($_altkat->result() as $_r) {
                                        if ($_r->ust_kategori_id == $_row->id ) {
                                            if (in_array($_r->id, $_filmKategorileri)):
                                                echo '<option value="'. $_r->id .'" selected="selected">'. $_row->kategori_adi .' -> '. $_r->kategori_adi .'</option>';
                                            else:
                                                echo '<option value="'. $_r->id .'">'. $_row->kategori_adi .' -> '. $_r->kategori_adi .'</option>';
                                            endif;
                                        }
                                    }

                                }
                                echo "</select>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmSitePuan" class="col-sm-2 control-label">Film Puanı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmSitePuan" id="frmSitePuan" value="<?php echo $_film->puan; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmFilitre" class="col-sm-2 control-label">Aile Filitresi:</label>
                        <div class="col-sm-10">
                            <?php
                            $filitre = array('acik' => 'Açık', 'kapali' => 'Kapalı');
                            echo form_dropdown('frmFilitre',$filitre, $_film->filitre,'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Film Dili: </label>
                        <div class="col-sm-10">
                            <?php
                            $_filmdili = array('dublaj' => 'Türkçe & Dublaj', 'altyazi' => 'Türkçe Altyazılı');
                            echo form_dropdown('frmFilmDili',$_filmdili, $_film->dil,'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Film Durumu: </label>
                        <div class="col-sm-10">
                            <?php
                            $_filmDurumu = array('hazir' => 'İzlenebilir', 'upload' => 'Yükleniyor', 'download' => 'İndiriliyor');
                            echo form_dropdown('frmFilmDurumu',$_filmDurumu, $_film->durum,'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmEtiketler" class="col-sm-2 control-label">Film Etiketleri:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmEtiketler" id="frmEtiketler"><?php echo $_etiketler; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmLinkler" class="col-sm-2 control-label">İndirme Linkleri:</label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmLinkler" id="frmLinkler"><?php echo $_linkler; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmSeoTitle" class="col-sm-2 control-label">SEO Başlığı: </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="frmSeoTitle" id="frmSeoTitle" value="<?php echo $_film->seo_title; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label form="frmSeoKeywords" class="col-sm-2 control-label">SEO Anahtar Kelimeleri: </label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmSeoKeywords" id="frmSeoKeywords"><?php echo $_film->seo_keys; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label form="frmSeoDescription" class="col-sm-2 control-label">SEO Açıklaması: </label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control" cols="100%" name="frmSeoDescription" id="frmSeoDescription"><?php echo $_film->seo_desc; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary ajaxFilmEkle">Filmi Düzelt</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>