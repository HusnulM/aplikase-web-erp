<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Report Inventory Movement
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/reports/movement" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:200%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Movement No</th>
                                                <th>Item</th>
                                                <th>Movement Type</th>
                                                <th>Movement Date</th>
                                                <th>Vendor</th>
                                                <th>Material</th>
                                                <th>Description</th>
                                                <th>Note</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Refrence</th>
                                                <th>Warehouse</th>
                                                <th>Warehouse Dest.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['mvdata'] as $prdata) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $prdata['grnum']; ?></td>
                                                    <td><?= $prdata['gritem']; ?></td>
                                                    <td><?= $prdata['movement']; ?> - <?= $prdata['movemventtext']; ?></td>
                                                    <td><?= $prdata['movementdate']; ?></td>
                                                    <td><?= $prdata['vendor']; ?></td>
                                                    <td><?= $prdata['material']; ?></td>
                                                    <td><?= $prdata['matdesc']; ?></td>
                                                    <td><?= $prdata['note']; ?></td>
                                                    <?php if($prdata['shkzg'] == "+") : ?>
                                                        <td style="text-align:right;"><?= number_format($prdata['quantity'], 0, ',', '.'); ?></td>
                                                    <?php else: ?>
                                                        <td style="text-align:right;background-color:red;color:white;"><?= number_format($prdata['quantity']*-1, 0, ',', '.'); ?></td>
                                                    <?php endif; ?>
                                                    
                                                    <td><?= $prdata['unit']; ?></td>
                                                    <?php if($prdata['movement'] == "101") : ?>
                                                        <td><?= $prdata['ponum']; ?> | <?= $prdata['poitem']; ?></td>
                                                    <?php elseif($prdata['movement'] == "201" || $prdata['movement'] == "211" || $prdata['movement'] == "261"): ?>
                                                        <td><?= $prdata['resnum']; ?> | <?= $prdata['resitem']; ?></td>
                                                    <?php endif; ?>
                                                    <td><?= $prdata['warehouse']; ?> - <?= $prdata['whsname']; ?></td>
                                                    <td><?= $prdata['warehouseto']; ?> - <?= $prdata['whsdest']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>