<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Report Reservation
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/reports/reservasi" type="button" class="btn bg-teal">
                            <i class="material-icons">backspace</i> <span>BACK</span>
                            </a>
							</ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Reservation</th>
                                                <th>Item</th>
                                                <th>Reservation Date</th>
                                                <th>Material</th>
                                                <th>Description</th>
                                                <th>Note</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Warehouse</th>
                                                <th>Warehouse Dest.</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['mvdata'] as $prdata) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $prdata['resnum']; ?></td>
                                                    <td><?= $prdata['resitem']; ?></td>
                                                    <td><?= $prdata['resdate']; ?></td>
                                                    <td><?= $prdata['material']; ?></td>
                                                    <td><?= $prdata['matdesc']; ?></td>
                                                    <td><?= $prdata['note']; ?></td>
                                                    <td style="text-align:right;"><?= number_format($prdata['quantity'], 0, ',', '.'); ?></td>
                                                    <td><?= $prdata['unit']; ?></td>
                                                    <td><?= $prdata['fromwhs']; ?> - <?= $prdata['whsname']; ?></td>
                                                    <td><?= $prdata['towhs']; ?> - <?= $prdata['whsdest']; ?></td>
                                                    <?php if($prdata['movementstat'] === "X") : ?>
                                                        <td style="background-color:green;color:white;">Completed</td>
                                                    <?php else : ?>
                                                        <td style="background-color:yellow;color:black;">Open</td>
                                                    <?php endif; ?>
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