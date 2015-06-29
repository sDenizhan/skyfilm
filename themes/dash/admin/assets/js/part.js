$(document).ready(function() {

    //ajax için kısayol...
    function postAjax(url,data,divSonuc){
        $.post(url, data, function(Cevap){
            if (Cevap.search('NoPost') > -1) {
                $.jGrowl("Tüm Forumu Doldurmalısınız..!", {position: "bottom-right"});
            } else if (Cevap.search('NoResult') > -1) {
                $.jGrowl("Kayıt Bulunamadı..!", {position: "bottom-right"});
            } else if (Cevap.search('Again') > -1) {
                $.jGrowl("Kayıt Zaten Var. Lütfen Bilgileriniz Değiştirin.!", {position: "bottom-right"});
            } else if (Cevap.search('ResultOk') > -1) {
                $.jGrowl("İşlem Başarıyla Gerçekleştirildi.!", {position: "bottom-right"});
            } else if (Cevap.search('ResultNo') > -1) {
                $.jGrowl("İşlem Gerçekleştirilemedi. Lütfen Tekrar Deneyiniz..!", {position: "bottom-right"});
            } else {
                $("#"+divSonuc).show().html(Cevap);
                setTimeout(function(){
                    $("#"+divSonuc).hide();
                }, '3000');

            }
        });

    }

    //part ajaxı için kısayoll...
    function partAjax(url,data,divSonuc){
        $.post(url, data, function(Cevap){
            if (Cevap.search('NoPost') > -1) {
                alert("Tüm Forumu Doldurmalısınız..!");
            } else if (Cevap.search('NoResult') > -1) {
                $("#"+divSonuc).html('Kayıt Bulunamadı ..!');
            } else if (Cevap.search('Again') > -1) {
                alert("Kayıt Zaten Var. Lütfen Bilgileriniz Değiştirin.!");
            } else if (Cevap.search('ResultOk') > -1) {
                alert("İşlem Başarıyla Gerçekleştirildi.!");
            } else if (Cevap.search('ResultNo') > -1) {
                alert("İşlem Gerçekleştirilemedi. Lütfen Tekrar Deneyiniz..!");
            } else {
                $("#"+divSonuc).empty().html(Cevap);
            }
        });

    }

    //film partlarını gösteren fonksiyon..
    function filmpartlarinigetir(filmID){
        partAjax('/admin/filmler/ajaxfilmpartlarigetir', {'filmID': filmID}, 'partDataTable');
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


    //ajax film partı ekler..
    $(".ajaxAddLinkButton").bind('click', function(event){
        var filmID = getURLSection(4, '/');
        var partAdi = $("#frmPartAdi").val();
        var partAdresi = $("#frmPartAdresi").val();
        var aciklama = $("#frmPartAciklama").val();
        var alternatif = $("#frmAlternatif").val();
        var player = $("#frmPlayer").val();

        $.post('/admin/filmler/ajaxfilmpartkaydet', {'partadi' : partAdi, 'filmID' : filmID, 'partadresi' : partAdresi, 'player' : player, 'alternatif' : alternatif, 'partAciklama': aciklama}, function(Cevap){
            filmpartlarinigetir(filmID);
        });

        event.preventDefault();
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
