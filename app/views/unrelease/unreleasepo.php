<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="msg-alert">
                        <?php
                            Flasher::msgInfo();
                        ?>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>
                                Cancel Approve Purchase Order
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Tanggal Order</th>
                                            <th>Vendor</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['podata'] as $podata) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $podata['ponum']; ?></td>
                                                <td><?= $podata['podat']; ?></td>
                                                <td><?= $podata['namavendor']; ?></td>
                                                <td><?= $podata['note']; ?></td>
                                                <td>Open</td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/unrelease/cancelpo/data?ponum=<?= $podata['ponum']; ?>" type="button" class="btn btn-success">Cancel Approve</a>
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