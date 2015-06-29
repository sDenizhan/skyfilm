<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="block-flat">
            <div class="header">
                <h3>Bot Ekle</h3>
            </div>
            <div class="content">
                <form class="form-horizontal" method="post" action="<?php echo base_url('admin/botlar/botkaydet'); ?>" role="form">
                    <div class="form-group">
                        <label for="frmBotAdi" class="col-sm-2 control-label">Bot Adı:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="frmBotAdi" name="frmBotAdi">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frmBotAciklamasi" class="col-sm-2 control-label">Bot Açıklaması:</label>
                        <div class="col-sm-10">
                            <textarea rows="5" cols="100%" class="form-control" name="frmBotAciklamasi" id="frmBotAciklamasi"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bot Durumu: </label>
                        <div class="col-sm-10">
                            <?php
                            $durum = array('Aktif' => 'Aktif', 'Pasif' => 'Pasif');
                            echo form_dropdown('frmBotDurumu', $durum, 'Aktif', 'class="form-control"');
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bot Görevi: </label>
                        <div class="col-sm-10">
                            <?php
                            $kullanim_yeri = array(
                                    'bilgi' => 'Bilgi Çekme Botu',
                                    'part' => 'Part Çekme Botu',
                            );
                            echo form_dropdown('frmKullanimYeri', $kullanim_yeri, 'bilgi', 'class="form-control"');
                            ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bot Dosyası:</label>
                        <div class="col-sm-10">
                            <?php
                                echo '<select name="frmBotFile" id="frmBotFile" class="form-control">';
                                foreach($_botlar as $bot)
                                {
                                    echo '<option value="'. $bot .'">'. $bot .'</option>';
                                }
                                echo '</select>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Bot Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>