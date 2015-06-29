<div class="middle-login">
    <div class="block-flat">
        <div class="header">
            <h3 class="text-center"><strong>SKYWEBOFFICE FILM SCRIPTI</strong></h3>
        </div>
        <div>
            <form style="margin-bottom: 0px !important;" class="form-horizontal" method="post" action="<?php echo base_url('admin/login/dologin'); ?>">
                <div class="content">
                    <h4 class="title">Admin Girişi</h4>

                    <?php
                        if ( $this->session->flashdata('error')) :
                            echo $this->session->flashdata('error');
                        endif;
                    ?>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="Kullanıcı Adınız" id="kullanici_adi" name="kullanici_adi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" placeholder="Şifre" id="sifre" name="sifre" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="foot">
                    <a href="" class="btn btn-default">Şifremi Unuttum</a>
                    <button class="btn btn-primary" type="submit">Giriş Yap</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center out-links"><a href="#">&copy; Skyweboffice</a></div>
</div>