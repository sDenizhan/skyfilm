<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span class="mws-i-24 i-create">Yorum Oku</span>
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-content">
            <?php if ($_film != FALSE) : ?>
            <h1><?php echo $_film->film_adi; ?></h1>
            <?php endif; ?>
            <p> Gönderen Ad Soyad : <?php echo $_yorum->ad_soyad; ?> <br>
                Gönderen Email Adresi : <?php echo $_yorum->email; ?> <br>
                Gönderilen Tarih : <?php echo $_yorum->tarih; ?>
                </p>

            <p><?php echo wordwrap($_yorum->yorum, 150, "<br>", TRUE); ?></p>

        </div>
    </div>
</div>

<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span class="mws-i-24 i-list">Yorumu Cevapla !</span>
    </div>
    <div class="mws-panel-body">
        <form class="mws-form" method="post" action="<?php echo base_url('/admin/yorumlar/yorumcevaplakaydet/'. $_yorum->id .'/'. seoURL($_yorum->ad_soyad)); ?>">
            <div class="mws-form-inline">
                <div class="mws-form-row">
                    <label>Cevabınız</label>
                    <div class="mws-form-item large">
                        <textarea rows="100%" cols="100%" name="frmYorumCevap" id="frmYorumCevap"></textarea>
                    </div>
                </div>
            </div>
            <div class="mws-button-row">
                <input type="submit" value="Yorumu Cevapla" class="mws-button green" />
                <input type="reset" value="Forumu Temizle" class="mws-button red" />
            </div>
        </form>
    </div>
</div>

