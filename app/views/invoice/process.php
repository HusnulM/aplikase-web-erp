    <?php 
        $totalprice = 0;
    ?>
    <section class="content">
        <div class="container-fluid">
            <b>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create Payment Purchase Order : <?= $data['ponum']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--2">
                                <a href="<?= BASEURL; ?>/payment" type="button" id="btn-back" class="btn bg-red"  data-type="danger">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
                                <button type="button" id="btn-process" class="btn bg-blue"  data-type="success">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-9 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" id="vendor" value="<?= $data['vendor']['vendor']; ?>">
                                            <label for="namavendor">Vendor</label>
                                            <input type="text" name="namavendor" id="namavendor" class="form-control" value="<?= $data['vendor']['namavendor']; ?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="ivdate">Payment Date</label>
                                            <input type="date" name="ivdate" id="ivdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" class="form-control" placeholder="Note">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label id="paytotal">Total Payment</label>
                                        <input type="text" name="total" id="totalprice" class="form-control" placeholder="Note" readonly>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="table-responsive">
                                    <table class="table table-responsive table-bordered table-striped" id="tbl-pr-item">
                                        <thead>
                                            <tr>
                                                <th>PO Item</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Tax</th>
                                                <th>Discount</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['podata'] as $pr) : ?>
                                                <?php 
                                                    $no++; 
                                                    $totalprice = $totalprice + $pr['subtot'];
                                                ?>
                                                <tr>
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
                                                    <td style="text-align:right;"><?= $pr['ppn']; ?>%</td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['discount'], '.00') !== false) {
                                                            echo number_format($pr['discount'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['discount'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['subtot'], '.00') !== false) {
                                                            echo number_format($pr['subtot'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['subtot'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" style="text-align:right;font-weight:bold;">
                                                    Total Payment
                                                </td>                                                
                                                <td style="text-align:right;font-weight:bold;">
                                                    <?= number_format($totalprice, 0, ',', '.'); ?>
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

            <!-- Modal Select Bank Payment Account -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Select Bank Account</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="bankacc" id="bankacc" data-live-search="true">
                                                <option value="">Bank Account</option>
                                                <?php foreach($data['banklist'] as $bank) : ?>
                                                    <option value="<?= $bank['bankno']; ?>"> <?= $bank['bankno']; ?> : <?= $bank['bankacc']; ?> - <?= $bank['deskripsi']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>               
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-add-bank-account" class="btn btn-primary">OK</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Select Bank Payment Account -->
            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Select Bank Account</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="form-control show-tick" name="bankacc" id="bankacc">
                                                <option value="">Bank Account</option>
                                                <?php foreach($data['banklist'] as $bank) : ?>
                                                    <option value="<?= $bank['bankno']; ?>"> <?= $bank['bankno']; ?> : <?= $bank['bankacc']; ?> - <?= $bank['deskripsi']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>               
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-add-bank-account" class="btn btn-primary">OK</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            var poitem = <?= json_encode($data['podata']); ?>;
            var totalpayment = "<?= $totalprice; ?>";
            $('#totalprice').val(formatRupiah(totalpayment,''))
            
            console.log(poitem)
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

            $('#btn-process').on('click',function(){
                $('#largeModal').modal('show');                
            })

            $('#btn-add-bank-account').on('click',function(){
                if($('#bankacc').val() === ''){
                    showErrorMessage('Please select bank account')
                }else{
                    processpayment();                
                }                
            })

            function processpayment(){
                var oheader = {};
                var oitem   = {};
                var ivdata  = {};
                var ivhead  = [];
                var ivitems = [];
                for(var i = 0; i < poitem.length; i++){
                    let object = new Object();
                    object["ivitem"]       = i + 1;
                    object["ponum"]        = poitem[i].ponum;
                    object["poitem"]       = poitem[i].poitem;
                    object["kodebrg"]      = poitem[i].material;
                    object["namabrg"]      = poitem[i].matdesc;
                    object["quantity"]     = poitem[i].quantity;
                    object["unit"]         = poitem[i].unit;
                    object["price"]        = poitem[i].price;
                    object["ivdate"]       = $('#ivdate').val();
                    ivitems.push(object);
                }

                oheader.vendor     = $('#vendor').val();
                oheader.namavendor = $('#namavendor').val();
                oheader.ivdate     = $('#ivdate').val();
                oheader.note       = $('#note').val();
                oheader.totalinv   = totalpayment;
                oheader.bankacc    = $('#bankacc').val();
                ivhead.push(oheader);

                ivdata = {
                    'header' : ivhead,
                    'items'  : ivitems
                }

                console.log(ivdata)

                $.ajax({
                    url: base_url+'/payment/post',
                    data: ivdata,
                    type: 'POST',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        if(result.msg == 'error'){
                            showWarningMessage(result.text)
                        }else{
                            showSuccessMessage('Payment Successfully '+ JSON.stringify(result))
                        }
                        
                        $("#btn-process").attr("disabled", false);
                    },error: function(err){
                        showErrorMessage(JSON.stringify(err))
                    }
                }).done(function(data){
                    $("#btn-process").attr("disabled", false);
                });
            }

            function showBasicMessage() {
                swal({title:"Loading...", text:"Mohon Menunggu", showConfirmButton: false});
            }

            function showSuccessMessage(message) {
                swal({title: "Success", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/payment';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }

            function showWarningMessage(message){
                swal("", message, "warning");
            }
        })
    </script>