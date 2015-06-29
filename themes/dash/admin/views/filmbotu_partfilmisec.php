<?php if (count($bilgiler->filmadlari) > 0) : ?>
    <div class="row">
        <div class="block-flat">
            <div class="header">
                <h3>Filmler</h3>
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
                        foreach ($bilgiler->filmadlari as $key => $value):
                            $resim = $bilgiler->resimler[$key];
                        ?>
                            <tr>
                                <td class="text-center"><img src="<?php echo $resim;  ?>" /></td>
                                <td class="text-center"><strong><?php echo $value; ?></strong></td>
                                <td class="text-center"><?php echo $bilgiler->linkler[$key]; ?></td>
                                <td class="text-center">
                                <?php
                                    echo form_open(base_url('admin/filmbotu/partcek'));

                                    echo form_hidden('filmLinki', $bilgiler->linkler[$key]);
                                    echo form_hidden('filmResmi', $resim);
                                    echo form_hidden('filmadi', $value);
                                    echo form_hidden('filmKaynak', $kaynak);
                                    echo form_hidden('filmBotu', $_filmBotu);
                                    echo '<input type="submit" class="btn btn-primary" value="Partları Göster" title="Yalnızca Filmin Partları Çekilir !!" />';

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
    </div>
<?php endif; ?>