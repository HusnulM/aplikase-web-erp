    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Master Bank
                            </h2>
							
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/bank/create" class="btn btn-success waves-effect pull-right">Create Bank Account</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bank ID</th>
                                            <th>Bank Account Number</th>
                                            <th>Bank Account Name</th>
                                            <th>Opening Balance</th>
                                            <th>Balance</th>
                                            <th>User</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['bank'] as $bank) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $bank['deskripsi']; ?></td>
                                                <td><?= $bank['bankno']; ?></td>
                                                <td><?= $bank['bankacc']; ?></td>
                                                <td><?= number_format($bank['balance'],2); ?></td>
                                                <td><?= number_format($bank['saldo_akhir'],2); ?></td>
                                                <td><?= $bank['user']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/bank/edit/<?= $bank['id']; ?>" type="button" class="btn btn-success">Edit</a>
                                                    <a href="<?= BASEURL; ?>/bank/delete/<?= $bank['id']; ?>" type="button" class="btn btn-danger">Delete</a>
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