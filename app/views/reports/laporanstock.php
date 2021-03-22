    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <!-- PO Item -->
                        <div class="header">
                            <h2>
                                Laporan Stok Barang
                            </h2>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Total Stok</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-body">
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['stock'] as $stock) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $stock['kodebrg']; ?></td>
                                                    <td><?= $stock['namabrg']; ?></td>
                                                    <td><?= $stock['quantity']; ?></td>
                                                    <td><?= $stock['satuan']; ?></td>
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
        </div>
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            $('#poitem').dataTable({});
        })
    </script>