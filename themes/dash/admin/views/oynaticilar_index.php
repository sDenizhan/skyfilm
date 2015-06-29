<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Oynatıcılar</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Oynatıcı Adı</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_oynaticilar->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->oynatici_adi; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/oynaticilar/oynaticisil/".$_row->id."/". seoURL($_row->oynatici_adi) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/oynaticilar/oynaticiduzelt/".$_row->id."/". seoURL($_row->oynatici_adi) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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

