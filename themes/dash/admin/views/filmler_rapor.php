<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Film Raporları</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Rapor ID</strong></th>
                        <th class="text-center"><strong>Film ID</strong></th>
                        <th class="text-center"><strong>Filmin Adı</strong></th>
                        <th class="text-center"><strong>Rapor Tarihi</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_videos->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->id; ?></td>
                            <td class="text-center"><strong><?php echo $_row->film_id; ?></strong></td>
                            <td class="text-center"><?php echo $_row->film_adi; ?></td>
                            <td class="text-center"><?php echo ($_row->tarih != NULL) ? date('d/m/Y H:i:s', $_row->tarih) : ''; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/filmler/raporsil/".$_row->id."/". seoURL($_row->film_adi) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/filmbotu/index/". urldecode($_row->film_adi) .""); ?>" class="btn btn-xs btn-danger"><i class="fa fa-cloud-upload"></i></a>
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

