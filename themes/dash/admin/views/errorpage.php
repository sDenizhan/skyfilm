<?php if ($e->durum == 'hata') { ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="block-flat">
                <div class="header">
                    <h3>HATA </h3>
                </div>
                <div class="content">

                    <div class="alert alert-danger rounded">
                        <strong>Hata!</strong>
                        <?php
                            if ($e->type == 'normal'):
                                echo $e->mesaj;
                            elseif ($e->type == 'uploadform'):
                                echo $this->upload->display_errors();
                            elseif  ($e->type == 'dizi'):
                                foreach($e->mesaj as $mesaj)
                                {
                                    echo $mesaj.'<br>';
                                }
                            elseif ($e->type == 'imagelib'):
                                echo $this->image_lib->display_errors();
                            elseif ($e->type == 'formvalidation'):
                                echo validation_errors();
                            endif;
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="block-flat">
                <div class="header">
                    <h3>İşlem Tamam</h3>
                </div>
                <div class="content">

                    <div class="alert alert-success rounded">
                        <strong>İşlem Tamam!</strong>
                        <?php
                        if ($e->type == 'normal'):
                            echo $e->mesaj;
                        elseif  ($e->type == 'dizi'):
                            foreach($e->mesaj as $mesaj)
                            {
                                echo $mesaj.'<br>';
                            }
                        endif;
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>