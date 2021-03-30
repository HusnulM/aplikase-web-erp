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
							<a href="<?= BASEURL; ?>/bom/create" class="btn btn-success waves-effect pull-right">Create BOM</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="prlist"></table>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Part Number</th>
                                            <th>Part Name</th>
                                            <th>Customer</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['partlist'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['partnumber']; ?></td>
                                                <td><?= $out['partname']; ?></td>
                                                <td><?= $out['customer']; ?></td>
                                                
                                                <td>
                                                    <a href="<?= BASEURL; ?>/wosimage/maintainimage/<?= $out['bomid']; ?>" type="button" class="btn btn-success">Maintain WOS Image</a>

                                                    <a href="<?= BASEURL; ?>/wosimage/maintainpartimage/<?= $out['bomid']; ?>" type="button" class="btn btn-success">Maintain Part Image</a>
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