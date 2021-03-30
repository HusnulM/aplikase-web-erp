<section class="content">
        <div class="container-fluid">
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <div class="row clearfix">
            <form action="<?= BASEURL; ?>/service/save" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                        </div>
                        <div class="body">                     
                            <div class="table-responsive">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Service Number</th>
                                                <th>No. Polisi</th>
                                                <th>Tanggal Service</th>
                                                <th>Mekanik</th>
                                                <th>Keterangan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">
                                            <?php $no = 0; ?>
                                            <?php foreach($data['services'] as $out) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $out['servicenum']; ?></td>
                                                    <td><?= $out['nopol']; ?></td>
                                                    <td><?= $out['servicedate']; ?></td>
                                                    <td><?= $out['mekanik']; ?></td>
                                                    <td><?= $out['note']; ?></td>
                                                    <td>
                                                        <a href="<?= BASEURL; ?>/service/serviceconfirm/<?= $out['servicenum']; ?>" type="button" class="btn btn-success">Confirm</a>
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
            </form>
            </div>
        </div>
    </section>
