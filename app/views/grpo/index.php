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
                                <?= $data['title']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>PO Number</th>
                                            <th>Order Date</th>
                                            <th>Vendor</th>
                                            <th>Note</th>
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
                                                <td><?= $podata['tgl_order']; ?></td>
                                                <td><?= $podata['namasup']; ?></td>
                                                <td><?= $podata['keterangan']; ?></td>
                                                <td>Waiting</td>
                                                <td>
                                                    <?php if($_SESSION['usr']['userlevel'] == 'Admin') : ?>
                                                        <a href="<?= BASEURL; ?>/grpo/closepo/<?= $podata['ponum']; ?>" type="button" class="btn btn-danger">Close</a>
                                                    <?php elseif($_SESSION['usr']['userlevel'] == 'Staff') : ?>
                                                        <a href="<?= BASEURL; ?>/grpo/proses/<?= $podata['ponum']; ?>" type="button" class="btn btn-success">Process</a>
                                                    <?php endif; ?>
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