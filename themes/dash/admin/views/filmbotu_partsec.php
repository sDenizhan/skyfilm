<?php if (count($partlar) > 0) : ?>

    <?php echo form_open('admin/filmbotu/partkaydet'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="block-flat">
                <div class="header">
                    <h2><?php echo $filmadi.' Partları'; ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="block block-color">
                <div class="header">
                    <h3>Filmi Seçiniz</h3>
                </div>
                <div class="content">
                    <?php
                    echo '<select name="film" class="form-control" id="film" size="15">';
                    foreach($filmler->result() as $film)
                    {
                        echo '<option value="'. $film->id .'">'. $film->film_adi .' | '. $film->film_orj_adi .'</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
            </div>

        </div>
        <div class=" col-md-6 col-sm-6 col-lg-6">
            <div class="block block-color success">
                <div class="header">
                    <h3>Yeniden Boyutlandır</h3>
                </div>
                <div class="content">
                        <div class="form-group">
                            <label>Yükseklik</label>
                            <input type="text" name="width" id="width" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Genişlik</label>
                            <input type="text" name="height" id="height" class="form-control">
                        </div>
                        <?php echo '<button type="submit" class="btn btn-primary" title="Hayırlı Olsun :D !!"> Partları Kaydet </button>'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        $i = 0;
        foreach ($partlar as $key => $part) {
        $i++
    ?>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="block block-color warning">
                <div class="header">
                    <h3>Part Önizleme</h3>
                </div>
                <div class="content">
                    <?php echo $part; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="block block-color danger">
                <div class="header">
                    <h3><?php echo 'Part '. $i . ' Kodu'; ?></h3>
                </div>
                <div class="content">
                    <div class="form-group">
                        <label>Part Başlığı:</label>
                        <input type="text" name="partbaslik[]" id="partbaslik[]" class="form-control" value="<?php echo $filmadi.' Part '. $i .''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Part Kodu:</label>
                        <textarea name="partembed[]" id="partembed[]" rows="10" cols="75" class="form-control"><?php echo trim($part); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Partı Ekle:</label>
                        <?php
                            $options = array('ekle' => 'Bunu EKLE', 'ekleme' => 'Bu Partı EKLEME');
                            echo form_dropdown('frmEkle[]', $options, '', 'class="form-control"');
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Alternatif Seçiniz:</label>
                        <select id="frmAlternatif[]" name="frmAlternatif[]" class="form-control">
                            <option value="1">Alternatif 1</option>
                            <option value="2">Alternatif 2</option>
                            <option value="3">Alternatif 3</option>
                            <option value="4">Alternatif 4</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <div class="block-flat text-center">
            <button type="submit" class="btn btn-primary"> Partları Kaydet !</button>
        </div>
    </div>

    <?php echo form_close(); ?>

<?php endif; ?>