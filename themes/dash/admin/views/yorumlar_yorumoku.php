<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <?php if ($_film != FALSE) : ?>
                    <h3><?php echo $_film->film_adi; ?></h3>
                <?php endif; ?>
                <i>Bu yorum <strong><?php echo date('d/m/Y H:i:s', $_yorum->tarih); ?></strong> tarihinde <strong><?php echo $_yorum->ad_soyad; ?> </strong> tarafından <strong><a href="<?php echo getFilmURL($_film->film_adi); ?>" target="_blank"><?php echo $_film->film_adi; ?></a></strong> filmine yapıldı.</i>
            </div>
            <div class="content">
                <?php echo $_yorum->yorum; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Yorum İşlemleri</h3>
            </div>
            <div class="content">
                <input type="button" value="Yorumu Sil" class="btn btn-info" onclick="javascript:window.location = '<?php echo base_url('/admin/yorumlar/YorumSil/'.$_yorum->id.'/'.seoURL($_yorum->ad_soyad)); ?>';" />
                <?php if ($_yorum->onay != "Onayli") : ?>
                    <input type="button" value="Yorumu Aktifleştir" class="btn btn-success" onclick="javascript:window.location = '<?php echo base_url('/admin/yorumlar/yorumonayla/'.$_yorum->id.'/'.seoURL($_yorum->ad_soyad)); ?>';"/>
                <?php else: ?>
                    <input type="button" value="Yorumu Pasifleştir" class="btn btn-danger" onclick="javascript:window.location = '<?php echo base_url('/admin/yorumlar/yorumpasifle/'.$_yorum->id.'/'.seoURL($_yorum->ad_soyad)); ?>';"/></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Yorumu Cevaplayın</h3>
            </div>
            <div class="content">
                <form role="form" class="form-horizontal" method="post" action="<?php echo base_url('/admin/yorumlar/yorumcevaplakaydet/'. $_yorum->id .'/'. seoURL($_yorum->ad_soyad)); ?>">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="15" name="frmYorumCevap" id="frmYorumCevap"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Yorumu Gönder</button>
                </form>
            </div>
        </div>
    </div>
</div>