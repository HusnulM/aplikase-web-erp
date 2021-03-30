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
                                <a href="<?= BASEURL; ?>/wip" class="btn bg-blue">
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
                                                <th>Customer</th>
                                                <th>Partnumber</th>
                                                <th>Area</th>
                                                <th style="text-align:right;">Quantity
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-body">
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['wip'] as $stock) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $stock['customer']; ?></td>
                                                    <td><?= $stock['partnumber']; ?></td>
                                                    <td><?= $stock['deskripsi']; ?></td>
                                                    <td style="text-align:right;"><?= $stock['quantity']; ?></td>
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