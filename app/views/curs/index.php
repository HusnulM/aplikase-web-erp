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
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/curs/create" class="btn btn-success waves-effect pull-right">Maintain Curs</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="prlist"></table>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>From Currency</th>
                                            <th>Value</th>
                                            <th>To Currency</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['cursdata'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['currency1']; ?></td>
                                                <td><?= $out['kurs1']; ?></td>
                                                <td><?= $out['currency1']; ?></td>
                                                <td><?= $out['kurs2']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/curs/detail/<?= $out['currency1']; ?>" type="button" class="btn btn-success">Detail</a>
                                                    
                                                    <?php if($_SESSION['usr']['userlevel'] == "SysAdmin") : ?>
                                                        <a href="<?= BASEURL; ?>/curs/delete/<?= $out['currency1']; ?>" type="button" class="btn btn-danger">Delete</a>
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