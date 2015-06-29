<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '<?php echo $_facebook_app_id; ?>',
            status     : true,
            xfbml      : true
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function getAccessToken()
    {
        FB.login(function(response){
            if (response.authResponse)
            {
                getPageAccessToken();
            }
            else
            {
                document.getElementById('facebook_access_token').value = 'Bir Hata Oluştu..! Tekrar Deneyiniz..';
            }

        }, {scope: 'manage_pages,offline_access,publish_stream'});
    }

    function getLongTimeAccessToken(shortAccessToken)
    {
        $.post('/admin/ayarlar/getLongTimeAccessToken', { fb_exchange_token : shortAccessToken },
            function(gelen)
            {
                document.getElementById('facebook_access_token').value = gelen;
            }
        );
    }

    function getPageAccessToken()
    {
        FB.api('/me/accounts', function(response){
            if (response && !response.error)
            {
                for(var i=0; i <= response.data.length; i++)
                {
                    if (response.data[i].id == '<?php echo $_facebook_page_id; ?>' || response.data[i].name == '<?php echo $_facebook_page_name;?>')
                    {
                        getLongTimeAccessToken(response.data[i].access_token);
                    }
                }
            }
        });
    }
</script>
<div class="row">

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="tab-container">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#adresler" data-toggle="tab">Sosyal Ağ Adresleri</a>
                </li>
                <li><a href="#facebook" data-toggle="tab">Facebook Ayarlar</a></li>
                <li><a href="#twitter" data-toggle="tab">Twitter Ayarları</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active cont" id="adresler">
                    <h3 class="hthin">Sosyal Ağ Adresleri</h3>
                    <?php echo form_open(site_url("admin/ayarlar/sosyalagkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                    <div class="form-group">
                        <label class="col-sm-2">Facebook Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmFacebookAdresi',ayar_getir('facebook_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Twitter Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmTwitterAdresi',ayar_getir('twitter_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Youtube Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmYoutubeAdresi',ayar_getir('youtube_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Digg Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmDiggAdresi',ayar_getir('digg_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">RSS Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmRSSAdresi',ayar_getir('rss_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Site Haritası Adresi:</label>
                        <div class="col-sm-10">
                            <?php echo form_input('frmSitemapAdresi',ayar_getir('sitemap_address'),'class="form-control"'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <!-- seo ayarları -->
                <div class="tab-pane cont" id="facebook">
                    <h2>Seo Ayarları</h2>
                    <?php echo form_open(site_url("admin/ayarlar/facebookayarkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                    <div class="form-group">
                        <label class="col-sm-2">Eklenen Filmler Facebook'ta Paylaşılsın mı?:</label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                            echo form_dropdown('fb_paylasim', $options, ayar_getir('fb_paylasim'),'class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Facebook Access Token:</label>
                        <div class="col-sm-7">
                            <?php
                            echo form_input('facebook_access_token', ayar_getir('facebook_access_token'),'class="form-control" id="facebook_access_token"');
                            ?>
                        </div>
                        <a href="#" onclick="getAccessToken();" class="btn btn-danger">Access Token Al</a>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>

                <!-- yorum ayarları -->
                <div class="tab-pane" id="twitter">
                    <h3>Twitter Ayarları</h3>
                    <?php echo form_open(site_url("admin/ayarlar/facebookayarkaydet"), array('class' => 'form-horizontal', 'method' => 'post', 'role' => 'form')); ?>
                    <div class="form-group">
                        <label class="col-sm-2">Eklenen Filmler Twitter'ta Paylaşılsın mı?:</label>
                        <div class="col-sm-10">
                            <?php
                            $options = array('Evet' => 'Evet', 'Hayir' => 'Hayir');
                            echo form_dropdown('twitter_paylasim', $options, ayar_getir('twitter_paylasim'),'class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2">Twitter:</label>
                        <div class="col-sm-7">
                            <?php
                            echo form_input('facebook_access_token', ayar_getir('facebook_access_token'),'class="form-control" id="facebook_access_token"');
                            ?>
                        </div>
                        <a href="#" onclick="getAccessToken();" class="btn btn-danger">Access Token Al</a>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Ayarları Kaydet</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
    </div>

</div>