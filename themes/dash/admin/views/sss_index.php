<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Sık Sorulan Sorular</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Soru</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_sorular->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->soru; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/sss/sorusil/".$_row->id."/". seoURL($_row->soru) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/sss/soruduzelt/".$_row->id."/". seoURL($_row->soru) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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