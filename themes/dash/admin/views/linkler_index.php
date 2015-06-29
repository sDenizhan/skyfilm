<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Bağlantılar</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Bağlantı ID</strong></th>
                        <th class="text-center"><strong>Bağlantı Adı</strong></th>
                        <th class="text-center"><strong>Bağlantı Adresi</strong></th>
                        <th class="text-center"><strong>Tıklanma</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_links->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->id; ?></td>
                            <td class="text-center"><strong><?php echo $_row->ad; ?></strong></td>
                            <td class="text-center"><?php echo $_row->url; ?></td>
                            <td class="text-center"><?php echo $_row->hit; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/linkler/linksil/".$_row->id."/". seoURL($_row->ad) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/linkler/linkduzelt/".$_row->id."/". seoURL($_row->ad) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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