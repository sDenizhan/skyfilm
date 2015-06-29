<div class="row">
    <div class="col-md-12 spacer"><h2>Bilgilendirme</h2><br></div>

    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-green">
            <div class="content"><h1 class="text-left"><?php echo $data->filmSayisi; ?></h1><p>Film</p></div>
            <div class="icon"><i class="fa fa-flag"></i></div>
            <a class="details" href="<?php echo base_url('admin/filmler'); ?>">Filmler <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>


    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-red">
            <div class="content"><h1 class="text-left"><?php echo $data->toplamYorum - $data->onayliYorum; ?></h1><p>Yeni Yorum</p></div>
            <div class="icon"><i class="fa fa-comments"></i></div>
            <a class="details" href="<?php echo base_url('admin/yorumlar'); ?>">Yorumlar <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>



    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-prusia">
            <div class="content"><h1 class="text-left"><?php echo $data->yeniMesaj; ?></h1><p>Yeni Mesaj</p></div>
            <div class="icon"><i class="fa fa-heart"></i></div>
            <a class="details" href="<?php echo base_url('admin/mesajlar'); ?>">Mesajlar <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-purple">
            <div class="content"><h1 class="text-left"><?php echo $data->toplamUye - $data->aktifUye; ?></h1><p>Yeni Üye</p></div>
            <div class="icon"><i class="fa fa-eye"></i></div>
            <a class="details" href="<?php echo base_url('admin/uyeler'); ?>">Üyeler <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>


    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-concrete">
            <div class="content"><h1 class="text-left"><?php echo $data->baglantiSayisi; ?></h1><p>Bağlantı</p></div>
            <div class="icon"><i class="fa fa-download"></i></div>
            <a class="details" href="<?php echo base_url('admin/linkler'); ?>">Bağlantılar <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>


    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-blue">
            <div class="content"><h1 class="text-left">5</h1><p>Responses</p></div>
            <div class="icon"><i class="fa fa-reply"></i></div>
            <a class="details" href="#">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>


    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-lemon">
            <div class="content"><h1 class="text-left">245</h1><p>New Visits</p></div>
            <div class="icon"><i class="fa fa-globe"></i></div>
            <a class="details" href="#">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="fd-tile detail tile-orange">
            <div class="content"><h1 class="text-left">7</h1><p>New Uploads</p></div>
            <div class="icon"><i class="fa fa-upload"></i></div>
            <a class="details" href="#">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-flat">
            <div class="header">
                <h3>Turkcealtyazi.org En Son Çıkan Film Alt Yazıları</h3>
            </div>
            <div class="content">
                <div class="table-responsive">
                    <table class="table no-border hover">
                        <thead class="no-border">
                        <tr>
                            <th style="width:50%;"><strong>Film Adı</strong></th>
                            <th style="width:50%;" class="text-center"><strong>İşlem</strong></th>
                        </tr>
                        </thead>
                        <tbody class="no-border-y">
                        <?php foreach ($_rss as $film) : ?>
                        <tr>
                            <td><strong><?php echo $film->filmadi; ?></strong></td>
                            <td class="text-center">
                            <?php
                                echo '<a href="'. base_url('admin/filmbotu/index/'. urldecode($film->filmadi)).'" class="btn btn-primary" title="Yalnızca Filmin Bilgileri Çekilir !!"><i class="fa fa-share"></i> Filmi Çek</a>';
                            ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>