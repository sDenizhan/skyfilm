<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Film Yorumları</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Yorum ID</strong></th>
                        <th class="text-center"><strong>Gönderen</strong></th>
                        <th class="text-center"><strong>Durum</strong></th>
                        <th class="text-center"><strong>Tarih</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_yorumlar->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->id; ?></td>
                            <td class="text-center"><?php echo $_row->ad_soyad; ?></td>
                            <td class="text-center"><strong><?php echo ($_row->onay == "Onayli") ? 'Aktif' : 'Pasif'; ?></strong></td>
                            <td class="text-center"><?php echo date('d/m/Y H:i:s', $_row->tarih); ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/yorumlar/yorumsil/".$_row->id."/". seoURL($_row->ad_soyad) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/yorumlar/yorumoku/".$_row->id."/". seoURL($_row->ad_soyad) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-comment"></i></a>
                            <?php if ($_row->onay == 'Onayli') : ?>
                                <a href="<?php echo base_url("admin/yorumlar/yorumpasifle/".$_row->id."/". seoURL($_row->ad_soyad) .""); ?>" class="btn btn-xs btn-info"><i class="fa fa-thumbs-o-down"></i></a>
                            <?php else: ?>
                                <a href="<?php echo base_url("admin/yorumlar/yorumonayla/".$_row->id."/". seoURL($_row->ad_soyad) .""); ?>" class="btn btn-xs btn-success"><i class="fa fa-thumbs-o-up"></i></a>
                            <?php endif; ?>
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