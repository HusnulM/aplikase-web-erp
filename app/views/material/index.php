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
							<a href="<?= BASEURL; ?>/material/create" class="btn btn-success waves-effect pull-right">Create Material</a>
							</ul>
                        </div>
                        
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Material</th>
                                            <th>Deskripsi</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <?php if($data['showprice']['rows'] == "1") : ?>
                                            <th>Unit Price</th>
                                            <th>Unit Price (USD)</th>
                                            <?php endif; ?>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['material'] as $barang) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $barang['material']; ?></td>
                                                <td><?= $barang['matdesc']; ?></td>
                                                <td><?= $barang['partname']; ?></td>
                                                <td><?= $barang['partnumber']; ?></td>
                                                <?php if($data['showprice']['rows'] == "1") : ?>

                                                    <?php if($barang['stdpriceusd'] > 0) : ?>
                                                        <td>
                                                            <?= number_format($barang['stdpriceusd']*$barang['curs'], 0, ',', '.'); ?>
                                                        </td>

                                                        <td>
                                                            <?= number_format($barang['stdpriceusd'], 4, ',', '.'); ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>
                                                            <?= number_format($barang['stdprice'], 0, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                            <?= number_format($barang['stdpriceusd'], 4, ',', '.'); ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    
                                                <?php endif; ?>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/material/edit/data?material=<?= $barang['material']; ?>" type="button" class="btn btn-success">Edit</a>
                                                    <a href="<?= BASEURL; ?>/material/delete/data?material=<?= $barang['material']; ?>" type="button" class="btn btn-danger">Hapus</a>
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

    