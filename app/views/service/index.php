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

                            <ul class="header-dropdown m-r--5">  
                                <a href="<?= BASEURL; ?>/service/create" class="btn bg-blue pull-right" id="btn-post">
                                <i class="material-icons">create_new_folder</i> <span>Create Service</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                     
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Service</th>
                                            <th>Tanggal Service</th>
                                            <th>NO. Polisi</th>
                                            <th>Keterangan</th>
                                            <th>Mekanik</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['srvdata'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['servicenum']; ?></td>
                                                <td><?= $out['servicedate']; ?></td>
                                                <td><?= $out['nopol']; ?></td>
                                                <td><?= $out['note']; ?></td>
                                                <td><?= $out['mekanik']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/service/detail/<?= $out['servicenum']; ?>" type="button" class="btn btn-success">Edit</a>
                                                    <a href="<?= BASEURL; ?>/service/delete/<?= $out['servicenum']; ?>" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>                                
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
