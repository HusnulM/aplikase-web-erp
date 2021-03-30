<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Order Payment
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Receipt Number</th>
                                            <th>Year</th>
                                            <th>Receipt Date</th>
                                            <th>Vendor</th>
                                            <th>Note</th>
                                            <th>Total Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['grdata'] as $grdata) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $grdata['grnum']; ?></td>
                                                <td><?= $grdata['year']; ?></td>
                                                <td><?= $grdata['tglterima']; ?></td>
                                                <td><?= $grdata['namavendor']; ?></td>
                                                <td><?= $grdata['keterangan']; ?></td>
                                                <td><?= $grdata['valdisp']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/payment/process/<?= $grdata['grnum']; ?>/<?= $grdata['year']; ?>/<?= $grdata['idsupp']; ?>" type="button" class="btn btn-success">Process Payment</a>
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