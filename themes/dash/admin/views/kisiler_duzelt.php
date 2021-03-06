<form class="form-horizontal" method="post" action="<?php echo base_url('admin/kisiler/guncelle'); ?>" role="form" id="oyuncu_form">
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-9">

            <div id="result" class="alert hide">
            </div>

            <div class="block-flat">
                <div class="header">
                    <h3>Kişi Ekle</h3>
                </div>
                <div class="content">
                    <label for="kisi_adi" class="control-label">Kişi Adı:</label>
                    <input type="text" class="form-control" id="kisi_adi" name="kisi_adi" value="<?php echo $_kisi->adi_soyadi; ?>" placeholder="">
                    <input type="hidden" class="form-control" id="kisi_id" name="kisi_id" value="<?php echo $_kisi->id; ?>" placeholder="">

                    <label for="frmFilmKonusu" class="control-label">Meslek:</label>
                    <?php
                        $options = array('oyuncu' => 'Oyuncu', 'yonetmen' => 'Yönetmen', 'senarist' => 'Senarist', 'yapimci' => 'Yapımcı');
                        echo form_dropdown('tur', $options, $_kisi->tur, 'class="form-control" id="tur"');
                    ?>
                </div>
            </div>

            <div class="block-flat">
                <div class="header">
                    <h3>Kişi Bilgisi Ekle</h3>
                </div>
                <div class="content">

                    <div class="">
                        <label>Başlık:</label>
                        <input type="text" id="baslik" name="baslik" placeholder="Doğum Tarihi" />
                        <label>Bilgi Değeri:</label>
                        <input type="text" id="deger" name="deger" placeholder="" />
                        <a href="#" class="btn btn-primary btn-sm bilgi-ekle">Ekle</a>

                        <table class="table no-border hover">
                            <thead class="no-border">
                                <th><strong>Başlık</strong></th>
                                <th><strong>Değer</strong></th>
                                <th><strong>İşlem</strong></th>
                            </thead>
                            <tbody class="no-border-y bilgiler">
                            <?php
                                if ( $_bilgiler != false ):
                                    foreach ($_bilgiler as $bilgi) {
                                        echo '<tr>
                                                <td>'. $bilgi->baslik .'</td>
                                                <td>'. $bilgi->deger .'</td>
                                              </tr>';
                                    }
                                endif;
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="block-flat">
                <div class="header">
                    <h3>Seo Ayarları</h3>
                </div>
                <div class="content">

                    <label for="seo_title" class="control-label">SEO Başlığı: </label>
                    <input type="text" class="form-control" name="seo_title"  value="<?php echo $_kisi->seo_title; ?>" id="seo_title">

                    <label form="seo_keywords" class="control-label">SEO Anahtar Kelimeleri: </label>
                    <textarea rows="5" class="form-control" cols="100%" name="seo_keywords" id="seo_keywords"><?php echo $_kisi->seo_keys; ?></textarea>

                    <label form="seo_description" class="control-label">SEO Açıklaması: </label>
                    <textarea rows="5" class="form-control" cols="100%" name="seo_description" id="seo_description"><?php echo $_kisi->seo_desc; ?></textarea>

                </div>
            </div>

        </div>


        <div class="col-sm-12 col-md-3 col-md-3">

            <div class="block-flat">
                <div class="header">
                    <h3>Kişi Resmi</h3>
                </div>
                <div id="kisi_resim" class="content">
                    <?php if ( empty($_kisi->resim) ) : ?>
                        <img src="" width="150" height="250" id="skyfile_img" border="0" style="display: none" /> <br><br>
                        <input type="hidden" class="form-control" name="kisi_resmi" id="kisi_resmi" >
                    <?php else: ?>
                        <img src="<?php echo $_kisi->resim; ?>" width="150" height="250" id="skyfile_img" border="0" /> <br><br>
                        <input type="hidden" class="form-control" name="kisi_resmi" id="kisi_resmi" value="<?php echo $_kisi->resim; ?>" >
                    <?php endif; ?>
                    <a href="#" class="btn btn-primary" onclick="SkyFileManager(this, 'kisi_resmi');">Resim Ekle</a>
                    <button type="submit" class="btn btn-success">Güncelle</button>
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
        $('input#kisi_adi').on('blur', function(){

            var kisi_adi = $(this).val();
            var kisi_id = $('#kisi_id').val();

            if ( kisi_adi != '' && kisi_id == '')
            {
                $.post('/admin/kisiler/ajax_kisi_kaydet', {'kisi_adi' : kisi_adi }, function (response) {

                    if ( response && response.status == 'ok')
                    {
                        $('input#kisi_id').val(response.data.kisi_id);
                    }
                    else
                    {
                        alert(response.message);
                    }

                });
            }

        });

        //bilgi ekleme
        $('a.bilgi-ekle').on('click', function(e){
            //link bir yere gitmesin
            e.preventDefault();

            //değerler
            var baslik = $('#baslik').val();
            var deger = $('#deger').val();
            var kisi_id = $('#kisi_id').val();

            if ( kisi_id == '' || isNaN(kisi_id))
            {
                alert('Kişi ID Bilgisine Erişilemedi..!');
            }
            else
            {
                $.post('/admin/kisiler/ajax_bilgi_kaydet', { 'kisi_id' : kisi_id, 'baslik' : baslik, 'deger' : deger }, function(result){

                    if ( result && result.status == 'ok' )
                    {
                        var bilgi_id = result.id;
                        var table_tr = $('.bilgiler').html();
                        var tr = '<tr><td>'+ baslik +'</td><td>'+ deger +'</td>';
                            tr += '<td><a href="#" title="'+ bilgi_id +'" class="btn btn-sm btn-danger delete_bilgi">';
                            tr += '<i class="fa fa-trash-o"></i></td></tr>';

                        $('.bilgiler').html( table_tr + tr);
                    }
                    else
                    {
                        alert(result.message);
                    }
                });
            }

        });

        //bilgi silme
        $(document).on('click', '.delete_bilgi', function(e){

            e.preventDefault();

            var tr = $(this).parent().parent();
            var bilgi_id = $(this).attr('title');

            $.post('/admin/kisiler/ajax_bilgi_sil', { 'bilgi_id' : bilgi_id }, function(result){

                if ( result && result.status == 'ok') 
                {
                    tr.remove();
                }
                else
                {
                    alert(result.message);
                }
            });
        });

        //oyuncu bilgilerini güncelleme
        $(document).on('submit', 'form#oyuncu_form', function(e){

            e.preventDefault();

            var kisi_id = $('#kisi_id').val();
            var resim = $('#kisi_resmi').val();
            var meslek = $('#tur').val();
            var seo_title = $('#seo_title').val();
            var seo_desc = $('#seo_description').val();
            var seo_keys = $('#seo_keywords').val();

            $.post(
                '/admin/kisiler/ajax_kisi_guncelle', 
                {
                    'kisi_id' : kisi_id,
                    'resim_adresi' : resim,
                    'meslek' : meslek,
                    'seo_title': seo_title,
                    'seo_keys' : seo_keys,
                    'seo_desc' : seo_desc
                },
                function(result)
                {
                    if ( result && result.status == 'ok')
                    {
                        $('#result').removeClass('hide').removeClass('alert-danger').addClass('alert-success').html(result.message);
                    }
                    else
                    {
                        $('#result').removeClass('hide').removeClass('alert-success').addClass('alert-danger').html(result.message);
                    }
                }
            );

        });

    });
</script>
<?php Assets::end_js('footer'); ?>
