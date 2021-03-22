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
                                Master Vendor
                            </h2>
							
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/vendor/create" class="btn btn-success waves-effect pull-right">Create Vendor</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vendor</th>
                                            <th>Nama Vendor</th>
                                            <th>Alamat</th>
                                            <th>Telepone</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['vendor'] as $vendor) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $vendor['vendor']; ?></td>
                                                <td><?= $vendor['namavendor']; ?></td>
                                                <td><?= $vendor['alamat']; ?></td>
                                                <td><?= $vendor['notelp']; ?></td>
                                                <td><?= $vendor['email']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/vendor/edit/<?= $vendor['vendor']; ?>" type="button" class="btn btn-success">Edit</a>
                                                    <a href="<?= BASEURL; ?>/vendor/delete/<?= $vendor['vendor']; ?>" type="button" class="btn btn-danger">Delete</a>
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