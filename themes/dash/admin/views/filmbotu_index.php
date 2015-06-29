<?php
    if ($film_adi != FALSE):
        $film_adi = $film_adi;
    else:
        $film_adi = '';
    endif;
?>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Film Bilgisi Çek</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/filmbotu/filmara'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmFilmAdi" class="col-sm-2 control-label">Film Adı</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmFilmAdi" name="frmFilmAdi" value="<?php echo $film_adi; ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmAranacakSite" class="col-sm-2 control-label">Bot Seçiniz</label>
                        <div class="col-sm-10">
                            <?php
                            if ($_bilgi != FALSE)
                            {
                                echo '<select name="frmAranacakSite" id="frmAranacakSite" class="form-control">';
                                foreach($_bilgi->result() as $_bot)
                                {
                                    echo '<option value="'. $_bot->dosya_adi .'">'. ucwords($_bot->bot_adi) .'</option>';
                                }
                                echo '</select>';
                            }
                            else
                            {
                                echo 'Bilgi Botu Eklemelisiniz..';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Film Ara</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Part Çek</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/filmbotu/partara'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmFilmAdi" class="col-sm-2 control-label">Film Adı</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmFilmAdi" name="frmFilmAdi" value="<?php echo $film_adi; ?>" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="frmAranacakSite" class="col-sm-2 control-label">Bot Seçiniz</label>
                        <div class="col-sm-10">
                            <?php
                            if ($_part != FALSE)
                            {
                                echo '<select name="frmAranacakSite" id="frmAranacakSite" class="form-control">';
                                foreach($_part->result() as $_bot)
                                {
                                    echo '<option value="'. $_bot->dosya_adi .'">'. ucwords($_bot->bot_adi) .'</option>';
                                }
                                echo '</select>';
                            }
                            else
                            {
                                echo 'Part Botu Eklemelisiniz..';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Film Ara</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
