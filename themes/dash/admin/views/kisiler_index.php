<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Kişiler</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Kişi ID</strong></th>
                        <th class="text-center"><strong>Adı Soyadı</strong></th>
                        <th class="text-center"><strong>Meslek</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_kisiler as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->id; ?></td>
                            <td class="text-center"><strong><?php echo $_row->adi_soyadi; ?></strong></td>
                            <td class="text-center"><?php echo ucfirst($_row->tur); ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/kisiler/sil/".$_row->id."/". seoURL($_row->adi_soyadi) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/kisiler/duzelt/".$_row->id."/". seoURL($_row->adi_soyadi) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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

