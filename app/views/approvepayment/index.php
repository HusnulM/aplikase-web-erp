    <section class="content">
        <div class="container-fluid">
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
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
                                                <td><?= $grdata['namavendor']; ?></td>
                                                <td><?= $grdata['note']; ?></td>
                                                <td style="text-align:right;">
                                                    <?php if (strpos($grdata['total_invoice'], '.00') !== false) {
                                                        echo number_format($grdata['total_invoice'], 0, ',', '.');
                                                    }else{
                                                        echo number_format($grdata['total_invoice'], 2, ',', '.');
                                                    } ?>
                                                </td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/approvepayment/detail/<?= $grdata['ivnum']; ?>" type="button" class="btn btn-success">Approve Payment</a>
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