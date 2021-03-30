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
                                Approve Purchase Order
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="prlist"></table>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. PO</th>
                                            <th>Tanggal Order</th>
                                            <th>Vendor</th>
                                            <th>Nama Vendor</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['podata'] as $pr) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $pr['ponum']; ?></td>
                                                <td><?= $pr['podat']; ?></td>
                                                <td><?= $pr['vendor']; ?></td>
                                                <td><?= $pr['namavendor']; ?></td>
                                                <td><?= $pr['note']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/approvepo/detail/data?ponum=<?= $pr['ponum']; ?>" type="button" class="btn btn-success">Detail</a>
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