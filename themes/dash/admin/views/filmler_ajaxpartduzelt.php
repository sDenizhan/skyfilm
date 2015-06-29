<div class="block-flat" id="part-duzelt-form">
    <div class="header">
        <h3>Part Düzelt</h3>
    </div>
    <div class="content">

        <form role="form">
            <div class="form-group">
                <label>Part Başlığı:</label>
                <input type="text" placeholder="Part Adı Giriniz" name="partadi" id="partadi" class="form-control" value="<?php echo $_part->baslik; ?>">
            </div>
            <div class="form-group">
                <label>Part Adresi / HTML Kodu:</label>
                <textarea rows="5" name="parturl" id="parturl" class="form-control"><?php echo $_part->url; ?></textarea>
            </div>
            <div class="form-group">
                <label>Part Açıklaması:</label>
                <textarea rows="5" name="partaciklama" id="partaciklama" class="form-control"><?php echo $_part->aciklama; ?></textarea>
            </div>
            <div class="form-group">
                <label>Alternatif Seçiniz:</label>
                <select id="partalternatif" name="partalternatif" class="form-control">
                    <option value="1" <?php if ($_part->alternatif == '1' ) { echo 'selected="selected"'; } ?>>Alternatif 1</option>
                    <option value="2" <?php if ($_part->alternatif == '2' ) { echo 'selected="selected"'; } ?>>Alternatif 2</option>
                    <option value="3" <?php if ($_part->alternatif == '3' ) { echo 'selected="selected"'; } ?>>Alternatif 3</option>
                    <option value="4" <?php if ($_part->alternatif == '4' ) { echo 'selected="selected"'; } ?>>Alternatif 4</option>
                </select>
            </div>
            <div class="form-group">
                <label>Oynatıcı Seçiniz:</label>
                <?php
                echo '<select name="partoynatici" id="partoynatici" class="form-control">';
                foreach ($_players->result() as $_row) {
                    if ($_row->oynatici_adi == $_part->player)
                    {
                        echo '<option value="'. seoURL($_row->oynatici_adi) .'" selected="selected">'. ucwords($_row->oynatici_adi) .'</option>';
                    }
                    else
                    {
                        echo '<option value="'. seoURL($_row->oynatici_adi) .'">'. ucwords($_row->oynatici_adi) .'</option>';
                    }

                }
                echo '</select>';
                ?>
            </div>
            <input type="hidden" id="partid" name="partid" value="<?php echo $_part->id; ?>" />
            <button class="btn btn-primary ajaxDuzeltButton" type="submit">Partı Düzelt</button>
            <button class="btn btn-primary cancelButton" type="submit">İptal</button>
        </form>



    </div>
</div>