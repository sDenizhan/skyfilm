<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Film Kategorileri</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Kategori Adı</strong></th>
                        <th class="text-center"><strong>Üst Kategori Adı</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_cats->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->kategori_adi; ?></td>
                            <td class="text-center"><strong><?php echo ($_row->parent_id == 0) ? "Ana Kategori" : $_row->parent_adi; ?></strong></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/kategoriler/kategorisil/".$_row->id."/". seoURL($_row->kategori_adi) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/kategoriler/kategoriduzelt/".$_row->id."/". seoURL($_row->kategori_adi) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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

