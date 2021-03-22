    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <!-- PO Item -->
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
                                <a href="<?= BASEURL; ?>/reports/batchstock" class="btn bg-blue">
                                   <i class="material-icons">backspace</i> BACK
                                </a>
                            </ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Material</th>
                                                <th>Description</th>
                                                <th>Warehouse</th>
                                                <th>Batch</th>
                                                <!-- <th>Part Name</th>
                                                <th>Part Number</th>                                                 -->
                                                <th style="text-align:right;">Quantity</th>
                                                <th>Base Uom</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-body">
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['stock'] as $stock) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $stock['material']; ?></td>
                                        <td><?= $stock['matdesc']; ?></td>
                                        <td><?= $stock['warehouse']; ?> - <?= $stock['whsname']; ?></td>
                                        <td><?= $stock['batch']; ?></td>
                                        <!-- <td><?= $stock['partname']; ?></td>
                                        <td><?= $stock['partnumber']; ?></td>                                         -->
                                        <td style="text-align:right;">
                                            <?php if (strpos($stock['quantity'], '.00') !== false) {
                                                echo number_format($stock['quantity'], 0, ',', '.');
                                            }else{
                                                echo number_format($stock['quantity'], 2, ',', '.');
                                            } ?>
                                        </td>
                                        <td><?= $stock['matunit']; ?></td>
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
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            $('#poitem').dataTable({});
        })
    </script>