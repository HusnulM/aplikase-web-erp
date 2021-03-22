    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Payment Number</th>
                                            <th>Payment Date</th>
                                            <th>PO Number</th>                                            
                                            <th>Vendor</th>
                                            <th>Note</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['paymentdata'] as $grdata) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $grdata['ivnum']; ?></td>
                                                <td><?= $grdata['ivdate']; ?></td>
                                                <td><?= $grdata['ponum']; ?></td>                                                
                                                <td><?= $grdata['namavendor']; ?></td>
                                                <td><?= $grdata['note']; ?></td>
                                                <td style="text-align:right;">
                                                    <?php if (strpos($grdata['povalue'], '.00') !== false) {
                                                        echo number_format($grdata['povalue'], 0, ',', '.');
                                                    }else{
                                                        echo number_format($grdata['povalue'], 2, ',', '.');
                                                    } ?>
                                                </td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/payment/approvepayment/<?= $grdata['ponum']; ?>/<?= $grdata['vendor']; ?>" type="button" class="btn btn-success">Process Payment</a>
                                                </td>
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
    </section>