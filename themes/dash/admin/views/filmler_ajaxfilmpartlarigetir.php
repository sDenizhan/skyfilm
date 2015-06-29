<table class="table no-border hover">
    <thead class="no-border">
    <tr>
        <th class="text-center"><strong>Part Başlığı</strong></th>
        <th class="text-center"><strong>Alternatif</strong></th>
        <th class="text-center"><strong>İşlemler</strong></th>
    </tr>
    </thead>
    <tbody class="no-border-y">
    <?php
    if ($_links != FALSE) :
        foreach($_links->result() as $part):
            ?>
            <tr>
                <td class="text-center"><?php echo $part->baslik; ?></td>
                <td class="text-center"><strong><?php echo 'Alternatif '. $part->alternatif; ?></strong></td>
                <td class="text-center">
                    <a href="<?php echo base_url("admin/filmler/partsil/".$part->id."/". seoURL($part->baslik) .""); ?>" class="btn btn-xs btn-warning deletepart">
                        <i class="fa fa-trash-o"></i>
                    </a>
                    <a href="<?php echo base_url("admin/filmler/partduzelt/".$part->id."/". seoURL($part->baslik) .""); ?>" class="btn btn-xs btn-primary editpart">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>