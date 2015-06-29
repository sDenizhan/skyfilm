<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Mesajlar</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Durum</strong></th>
                        <th class="text-center"><strong>Konu</strong></th>
                        <th class="text-center"><strong>Tarih</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_mesajlar->result() as $_row) : ?>
                        <tr>
                            <td class="text-center">
                                <?php
                                if ($_row->yeni == 'Evet')
                                {
                                    echo '<i class="fa fa-envelope"></i>';
                                }
                                else
                                {
                                    echo '<i class="fa fa-envelope-o"></i>';
                                }
                                ?>
                            </td>
                            <td class="text-center"><?php echo $_row->konu; ?></td>
                            <td class="text-center"><strong><?php echo date('d/m/Y H:i:s', $_row->tarih); ?></strong></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/mesajlar/mesajsil/".$_row->id."/". seoURL($_row->konu) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/mesajlar/mesajoku/".$_row->id."/". seoURL($_row->konu) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <?php echo $_pages; ?>
    </div>
</div>

