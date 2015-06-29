<div class="row">
    <div class="block-flat">
<?php if ($_filmadlari != FALSE) : ?>
            <div class="header">
                <h3>Film Arama Sonuçları</h3>
            </div>
            <div class="content">
                <div class="table-responsive">
                    <table class="table no-border hover">
                        <thead class="no-border">
                        <tr>
                            <th class="text-center"><strong>Film Resmi</strong></th>
                            <th class="text-center"><strong>Film Adı</strong></th>
                            <th class="text-center"><strong>Kaynak</strong></th>
                            <th class="text-center"><strong>İşlemler</strong></th>
                        </tr>
                        </thead>
                        <tbody class="no-border-y">
                        <?php
                            foreach ($_filmadlari as $key => $value):
                            $resim = str_replace('film/images/', '', $_resimler[$key]);
                        ?>
                            <tr>
                                <td class="text-center"><img src="<?php echo trim($resim);  ?>" /></td>
                                <td class="text-center"><?php echo $value; ?></td>
                                <td class="text-center"><?php echo $_linkler[$key]; ?></td>
                                <td class="text-center">
                                    <?php
                                    echo form_open(base_url('admin/filmbotu/filmicek'));

                                    echo form_hidden('filmLinki', $_linkler[$key]);
                                    echo form_hidden('filmResmi', $resim);
                                    echo form_hidden('filmBotu', $_bot);
                                    echo '<input type="submit" class="btn btn-rad btn-danger" value="Filmi Çek" title="Yalnızca Filmin Bilgileri Çekilir !!" />';

                                    echo form_close();

                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php else:?>
        <div class="alert alert-danger">
            <p>Filmi Bulamadık. <a href="<?php echo base_url('admin/filmbotu'); ?>">Geri Dön</a></p>
        </div>
<?php endif; ?>
    </div>
</div>
