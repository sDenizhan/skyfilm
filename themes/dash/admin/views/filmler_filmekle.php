<form class="form-horizontal" method="post" action="<?php echo base_url('admin/filmler/kaydet'); ?>" role="form">
<div class="row">
    <div class="col-sm-12 col-md-9 col-lg-9">
        <div class="block-flat">
            <div class="header">
                <h3>Film Ekle</h3>
            </div>
            <div class="content">
                    <label for="filmadi" class="control-label">Film Adı:</label>
                    <input type="text" class="form-control" id="film_adi" name="film_adi" placeholder="">
                    <input type="hidden" class="form-control" id="film_id" name="film_id" placeholder="">

                    <label for="frmFilmKonusu" class="control-label">Film Konusu:</label>
                    <textarea rows="5" class="form-control" cols="100%" name="film_konusu" id="film_konusu"></textarea>

                    <label for="frmFilmFragman" class="control-label">Film Fragmanı:</label>
                    <textarea rows="5" class="form-control" cols="100%" name="film_fragman" id="film_fragman"></textarea>
            </div>
        </div>

        <div class="block-flat">
            <div class="header">
                <h3>Film Bilgisi Ekle</h3>
            </div>
            <div class="content">

                <div class="">
                    <label>Bilgi Adı:</label>
                    <input type="text" id="bilgi_adi" name="ozellik_adi" placeholder="Yapım Yılı" />
                    <label>Bilgi Değeri:</label>
                    <input type="text" id="bilgi_degeri" name="ozellik_degeri" placeholder="2015" />
                    <a href="#" class="btn btn-primary btn-sm">Ekle</a>
                </div>

            </div>
        </div>

        <div class="block-flat">
            <div class="header">
                <h3>Oyuncular</h3>
            </div>

            <div class="content">
                <div class="">
                    <label>Oyuncu Ara:</label>
                    <input type="text" id="oyuncu_adi" name="oyuncu_id" />
                    <a href="#" class="btn btn-primary btn-sm">Ekle</a>
                </div>
            </div>
        </div>

        <div class="block-flat">
            <div class="header">
                <h3>Seo Ayarları</h3>
            </div>
            <div class="content">

                    <label for="frmSeoTitle" class="control-label">SEO Başlığı: </label>
                    <input type="text" class="form-control" name="frmSeoTitle" id="frmSeoTitle">

                    <label form="frmSeoKeywords" class="control-label">SEO Anahtar Kelimeleri: </label>
                    <textarea rows="5" class="form-control" cols="100%" name="frmSeoKeywords" id="frmSeoKeywords"></textarea>

                    <label form="frmSeoDescription" class="control-label">SEO Açıklaması: </label>
                    <textarea rows="5" class="form-control" cols="100%" name="frmSeoDescription" id="frmSeoDescription"></textarea>

            </div>
        </div>

    </div>


    <div class="col-sm-12 col-md-3 col-md-3">

        <div class="block-flat">
            <div class="header">
                <h3>Film Resmi</h3>
            </div>
            <div id="film_resim" class="content">
                <img src="" width="150" height="250" id="skyfile_img" border="0" style="display: none" /> <br><br>
                <input type="hidden" class="form-control" name="frmFilmResmi" id="frmFilmResmi" >
                <a href="#" class="btn btn-primary" onclick="SkyFileManager(this, 'frmFilmResmi');">Resim Ekle</a>
            </div>
        </div>

        <div class="block-flat">
            <div class="header">
                <h3>Film Kategorileri</h3>
            </div>

            <div class="content">

                <?php
                if (isset($_ustkat)) {
                    echo '<select id="kategori[]" name="kategori[]" multiple size="10" class="select2">';
                    foreach ($_ustkat->result() as $_row) {
                        echo '<option value="'. $_row->id .'">'. $_row->kategori_adi .'</option>';

                        // alt kategoriler
                        foreach ($_altkat->result() as $_r) {
                            if ($_r->parent_id == $_row->id ) {
                                echo '<option value="'. $_r->id .'">'. $_row->kategori_adi .' -> '. $_r->kategori_adi .'</option>';
                            }
                        }

                    }
                    echo "</select>";
                }

                ?>

            </div>
        </div>


        <div class="block-flat">
            <div class="header">
                <h3>Film Ayarları</h3>
            </div>
            <div id="" class="content">

                    <label for="frmFilitre" class="control-label">Aile Filitresi:</label>
                    <?php
                    $filitre = array('acik' => 'Açık', 'kapali' => 'Kapalı');
                    echo form_dropdown('frmFilitre',$filitre,'kapali','class="form-control"');
                    ?>

                    <label class="control-label">Film Dili: </label>
                    <?php
                    $_filmdili = array('dublaj' => 'Türkçe & Dublaj', 'altyazi' => 'Türkçe Altyazılı');
                    echo form_dropdown('frmFilmDili',$_filmdili,'','class="form-control"');
                    ?>

                    <label class="control-label">Film Durumu: </label>
                    <?php
                    $_filmDurumu = array('hazir' => 'İzlenebilir', 'upload' => 'Yükleniyor', 'download' => 'İndiriliyor');
                    echo form_dropdown('frmFilmDurumu',$_filmDurumu,'','class="form-control"');
                    ?>

            </div>
        </div>

        <div class="block-flat">
            <div class="header">
                <h3>Film Etiketleri</h3>
            </div>

            <div class="content" id="film_etiket">
                <input type="text" class="tags" name="frmEtiketler" id="frmEtiketler" />
            </div>
        </div>

    </div>
</div>
</form>
<?php
echo Assets::add_js($_assets_url.'/js/jquery.select2/select2.min.js', 'footer', true);
echo Assets::add_css($_assets_url.'/js/jquery.select2/select2.css', 'header', true);
echo Assets::set_kcfinder();
Assets::start_js();
?>
<script>
    $(document).ready(function(){
        $(".select2").select2({
            width: '100%'
        });

        $(".tags").select2({tags: 0,width: '100%'});

        //
        $('input#film_adi').on('blur', function(){

            var film_adi = $(this).val();

            if ( film_adi != '' )
            {
                $.post('/admin/filmler/ajax_film_kaydet', {'film_adi' : film_adi }, function (response) {

                    if ( response && response.status == 'ok')
                    {
                        $('input#film_id').val(response.data.film_id);
                    }
                    else
                    {
                        alert(response.message);
                    }

                });
            }

        });



    });
</script>
<?php Assets::end_js('footer'); ?>
