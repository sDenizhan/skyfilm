<div class="row">
    <div class="panel-group accordion" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="fa fa-angle-right"></i> Filitreler
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="get" action="<?php echo base_url('admin/duyurular/filitrele/'); ?>">
                        <div class="form-group">
                            <label for="aranan" class="col-sm-2 control-label">Aranacak Kelime:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="aranan" name="aranan" placeholder="Aranan Kelime">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id" class="col-sm-2 control-label">ID Numarası:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" name="id" placeholder="ID Numarası">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="siralama" class="col-sm-2 control-label">Sıralama:</label>
                            <div class="col-sm-10">
                                <select name="siralama" id="siralama" class="form-control">
                                    <option value="ASC">ARTAN</option>
                                    <option value="DESC">AZALAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Filitrele</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="block-flat">
        <div class="header">
            <h3>Duyurular</h3>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table no-border hover">
                    <thead class="no-border">
                    <tr>
                        <th class="text-center"><strong>Duyuru ID</strong></th>
                        <th class="text-center"><strong>Başlık</strong></th>
                        <th class="text-center"><strong>Tarih</strong></th>
                        <th class="text-center"><strong>Tür</strong></th>
                        <th class="text-center"><strong>İşlemler</strong></th>
                    </tr>
                    </thead>
                    <tbody class="no-border-y">
                    <?php foreach ($_news->result() as $_row) : ?>
                        <tr>
                            <td class="text-center"><?php echo $_row->id; ?></td>
                            <td class="text-center"><strong><?php echo $_row->baslik; ?></strong></td>
                            <td class="text-center"><?php echo date('d/m/Y H:i:s', $_row->tarih); ?></td>
                            <td class="text-center"><?php echo $_row->tur != "manset" ? "Normal" : "Manşet"; ?></td>
                            <td class="text-center">
                                <a href="<?php echo base_url("admin/duyurular/duyurusil/".$_row->id."/". seoURL($_row->baslik) .""); ?>" class="btn btn-xs btn-warning"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo base_url("admin/duyurular/duyuruduzelt/".$_row->id."/". seoURL($_row->baslik) .""); ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
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

