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
							<a href="<?= BASEURL; ?>/activity/create" class="btn btn-success waves-effect pull-right">Add New Activity Process</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="prlist"></table>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Process</th>
                                            <th style="text-align:right;">Cycle Time</th>
                                            <th>Cycle Unit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['activity'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['activity']; ?></td>
                                                <td style="text-align:right;">
                                                    <?php if (strpos($out['cycletime'], '.00') !== false) {
                                                        echo number_format($out['cycletime'], 0, ',', '.');
                                                    }else{
                                                        echo number_format($out['cycletime'], 2, ',', '.');
                                                    } ?>   
                                                </td>
                                                <td><?= $out['cycvleunit']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/activity/edit/<?= $out['id']; ?>" type="button" class="btn btn-success">Edit</a>

                                                    <a href="<?= BASEURL; ?>/activity/delete/<?= $out['id']; ?>" type="button" class="btn btn-danger">Delete</a>
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