    <?php 
        $totaliv = 0;
    ?>
    <section class="content">
        <div class="container-fluid">
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                                Detail Payment <?= $data['ivhead']['ivnum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">  
                                <a href="<?= BASEURL; ?>/approvepayment" class="btn bg-teal waves-effect">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
                                <a href="<?= BASEURL; ?>/approvepayment/approve/<?= $data['ivnum']; ?>" class="btn bg-green" id="btn-approve">
                                    <i class="material-icons">done_all</i> <span>APPROVE</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">
                            <b>
                                <div class="row clearfix">                                    
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="vendor">Vendor</label>
                                                <input type="text" name="vendor" id="vendor" class="form-control readOnly" placeholder="Vendor" value="<?= $data['ivhead']['namavendor']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly"  value="<?= $data['ivhead']['note']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Payment Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['ivhead']['ivdate']; ?>" readonly>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </b>
                        </div>
                    </div>

                    <div class="card">
                        <!-- PR Item -->
                        <div class="header">
                            <h2>
                                Payment Item
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-responsive table-bordered table-striped" id="tbl-pr-item">
                                        <thead>
                                            <tr>
                                                <th>Payment Item</th>
                                                <th>PO Number</th>
                                                <th>PO Item</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Unit Price</th>
                                                <th>Discount</th>
                                                <th>Tax</th>                                                
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['ivitem'] as $pr) : ?>
                                                <?php 
                                                    $no++; 
                                                    $totaliv = $totaliv + $pr['subtotal'];
                                                ?>
                                                <tr>
                                                    <td><?= $pr['ivitem']; ?></td>
                                                    <td><?= $pr['ponum']; ?></td>
                                                    <td><?= $pr['poitem']; ?></td>
                                                    <td><?= $pr['material']; ?></td>
                                                    <td><?= $pr['matdesc']; ?></td>
                                                    <td><?= $pr['mattypedesc']; ?></td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['quantity'], '.00') !== false) {
                                                            echo number_format($pr['quantity'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['quantity'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    <td><?= $pr['unit']; ?></td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['price'], '.00') !== false) {
                                                            echo number_format($pr['price'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['price'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['discount'], '.00') !== false) {
                                                            echo number_format($pr['discount'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['discount'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    <td style="text-align:right;"><?= $pr['ppn']; ?>%</td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['subtotal'], '.00') !== false) {
                                                            echo number_format($pr['subtotal'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['subtotal'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="11" style="text-align:right;font-weight:bold;">
                                                    Total Payment
                                                </td>                                                
                                                <td style="text-align:right;font-weight:bold;">
                                                    <?= number_format($totaliv, 0, ',', '.'); ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function(){
            // var totalpayment = "<?= $totaliv; ?>";
            // $('#totalpayment').val(formatRupiah(totalpayment,''))

            function formatRupiah(angka, prefix){
                var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                split   		  = number_string.split(','),
                sisa     		  = split[0].length % 3,
                rupiah     		  = split[0].substr(0, sisa),
                ribuan     		  = split[0].substr(sisa).match(/\d{3}/gi);
            
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
            
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }
        })
    </script>