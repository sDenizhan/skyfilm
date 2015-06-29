<div class="row">
    <div class="col-sm-6 col-md-6" id="part-form">
        <div class="block-flat" id="part-ekle-form">
            <div class="header">
                <h3>Part Ekle</h3>
            </div>
            <div class="content">

                <form role="form">
                    <div class="form-group">
                        <label>Part Başlığı:</label>
                        <input type="text" placeholder="Part Adı Giriniz" name="frmPartAdi" id="frmPartAdi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Part Adresi / HTML Kodu:</label>
                        <textarea rows="5" name="frmPartAdresi" id="frmPartAdresi" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Part Açıklaması:</label>
                        <textarea rows="5" name="frmPartAciklama" id="frmPartAciklama" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Alternatif Seçiniz:</label>
                        <select id="frmAlternatif" name="frmAlternatif" class="form-control">
                            <option value="1">Alternatif 1</option>
                            <option value="2">Alternatif 2</option>
                            <option value="3">Alternatif 3</option>
                            <option value="4">Alternatif 4</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Oynatıcı Seçiniz:</label>
                        <?php
                        echo '<select name="frmPlayer" id="frmPlayer" class="form-control">';
                        foreach ($_players->result() as $_row) {
                            echo '<option value="'. seoURL($_row->oynatici_adi) .'">'. ucwords($_row->oynatici_adi) .'</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                    <a href="#" class="btn btn-primary ajaxAddLinkButton">Part Ekle</a>
                </form>

            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-6">
        <div class="block-flat">
            <div class="header">
                <h3>Film Partları</h3>
            </div>
            <div class="content">
                <div class="table-responsive" id="partDataTable">
                    <table class="table no-border hover">
                        <thead class="no-border">
                        <tr>
                            <th class="text-center"><strong>Part Başlığı</strong></th>
                            <th class="text-center"><strong>Alternatif</strong></th>
                            <th class="text-center"><strong>İşlemler</strong></th>
                        </tr>
                        </thead>
                        <tbody class="no-border-y">
                            <?php
                                if ($_partlar != FALSE) :
                                    foreach($_partlar->result() as $part):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $part->baslik; ?></td>
                                <td class="text-center"><strong><?php echo 'Alternatif '. $part->alternatif; ?></strong></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url("admin/filmler/partsil/".$part->id."/". seoURL($part->baslik) .""); ?>" class="btn btn-xs btn-warning deletepart">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                    <a href="<?php echo base_url("admin/filmler/partduzelt/".$part->id."/". seoURL($part->baslik) .""); ?>" class="btn btn-xs btn-primary editpart">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                    endforeach;
                                endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="partDuzelt">

        </div>

    </div>
</div>
<?php Assets::start_js(); ?>
<script>
    $(document).ready(function() {

        //ajax film partı ekler..
        $(".ajaxAddLinkButton").bind('click', function(event){
            event.preventDefault();

            var filmID = getURLSection(4, '/');
            var partAdi = $("#frmPartAdi").val();
            var partAdresi = $("#frmPartAdresi").val();
            var aciklama = $("#frmPartAciklama").val();
            var alternatif = $("#frmAlternatif").val();
            var player = $("#frmPlayer").val();

            $.post('/admin/filmler/ajax_part_kaydet', {'partadi' : partAdi, 'filmID' : filmID, 'partadresi' : partAdresi, 'player' : player, 'alternatif' : alternatif, 'partAciklama': aciklama}, function(result){

                if ( result && result.status == 'ok')
                {
                    filmpartlarinigetir(filmID);
                    //$.jGrowl(result.message, {position: "bottom-right"});
                }
                else
                {
                    //$.jGrowl(result.message, {position: "bottom-right"});
                }

            });

        });


        //film partlarını gösteren fonksiyon..
        function filmpartlarinigetir(filmID){
            $.post('/admin/filmler/ajax_part_getir', {'filmID': filmID}, function(result){

                if ( result && result.status == 'ok')
                {
                    var adet = result.data.length;

                    var tr = '';
                    for(var i = 0; i < adet; i++)
                    {
                        tr += '<tr>';
                        tr += '<td class="text-center">'+ result.data[i].baslik +'</td>';
                        tr += '<td class="text-center"><strong>Alternatif '+ result.data[i].alternatif +'</strong></td>';
                        tr += '<td class="text-center">';
                        tr += '<a href="/admin/filmler/partsil/'+ result.data[i].id +'/" class="btn btn-xs btn-warning deletepart">';
                        tr += '<i class="fa fa-trash-o"></i>';
                        tr += '</a>';
                        tr += '<a href="/admin/filmler/partduzelt/'+ result.data[i].id +'/" class="btn btn-xs btn-primary editpart">';
                        tr += '<i class="fa fa-edit"></i>';
                        tr += '</a>';
                        tr += '</td>';
                        tr += '</tr>';
                    }

                    $('tbody.no-border-y').empty().html(tr);
                }
                else
                {
                    alert(result.message);
                }

            });
        }

        //url'nin belirtilen kısmını alır..
        function getURLSection(section, char){
            var pathArray = window.location.pathname.split(char);
            return pathArray[section];
        }

        //botla çekilen filme resim ekler...
        $(".botResimEkle").bind('click', function(e)
        {
            e.preventDefault();

            var data = $('.resimEkle').serialize();
            var url = $('.resimEkle').attr('action');
            partAjax(url, data, 'imageResult');

        });




        //ajax part duzeltme fonksiyonu..
        $(document).on('click', '.ajaxDuzeltButton', function(event){
            var partAdi = $("#partadi").val();
            var partAdresi = $("#parturl").val();
            var aciklama = $("#partaciklama").val();
            var alternatif = $("#partalternatif").val();
            var player = $("#partoynatici").val();
            var partID = $("#partid").val();

            partAjax('/admin/filmler/partduzeltkaydet', {'partID' : partID, 'partadi' : partAdi, 'partadresi' : partAdresi, 'player' : player, 'alternatif' : alternatif, 'partAciklama': aciklama}, 'result');
            setTimeout(function(){
                var filmID = getURLSection(4, '/');
                filmpartlarinigetir(filmID);
            }, '500');
            event.preventDefault();
        });



        //ajax part silme ...
        $("#partDataTable").on('click', ".deletepart", function(event){
            event.preventDefault();
            var href = $(this).attr('href').split('/');
            var partID = href[6];
            postAjax('/admin/filmler/partsil', {'partID' : partID}, 'partDataTable');
            var filmID = getURLSection(4, '/');
            filmpartlarinigetir(filmID);

        });

        //ajax part duzeltme
        $(document).on('click', '.editpart', function(event){
            var href = $(this).attr('href').split('/');
            var partID = href[6];
            $.post('/admin/filmler/partduzelt', {'partID' : partID}, function(Cevap){
                $('#partDuzelt').html(Cevap);
            });
            event.preventDefault();
        });

        //ajax duzelt iptal butonu..
        $(document).on('click', '.cancelButton', function(event){

            $('#part-duzelt-form').remove();

            event.preventDefault();
        });

    });

</script>
<?php Assets::end_js('footer');?>