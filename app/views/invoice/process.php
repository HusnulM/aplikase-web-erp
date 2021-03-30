    <section class="content">
        <div class="container-fluid">
            <b>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Payment Process With Receipt Number : <?= $data['grnum']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--2">
                            <a href="<?= BASEURL; ?>/payment" type="button" id="btn-back" class="btn btn-danger"  data-type="danger">Cancel</a>
                                <button type="button" id="btn-process" class="btn btn-primary"  data-type="success">Post Data</button>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" id="vendor" value="<?= $data['vendor']['vendor']; ?>">
                                            <label for="namavendor">Vendor</label>
                                            <input type="text" name="namavendor" id="namavendor" class="form-control" value="<?= $data['vendor']['namavendor']; ?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="ivdate">Payment Date</label>
                                            <input type="date" name="ivdate" id="ivdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" class="form-control" placeholder="Note">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="hidden" id="idproject" value="<?= $data['grheader']['idproject']; ?>">
                                            <label for="note">Project</label>
                                            <input type="text" name="project" id="project" class="form-control" placeholder="Project" value="<?= $data['grheader']['namaproject']; ?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <br>
                                            <button id="btn-view-file" class="btn btn-success form-control">Preview File</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                        <label id="paytotal">Total Payment</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="dg" class="easyui-datagrid" style="width:98%;height:200px"  fitColumns="false" singleSelect="false">
                                            <thead>
                                                <tr>
                                                    <th field="gritem"   width="50">No</th>
                                                    <th field="kodebrg"  width="100">Item Code</th>
                                                    <th field="namabrg"  width="350">Item Name</th>
                                                    <th field="jumlah"   width="100" align="right">Received Qty</th>
                                                    <th field="satuan"   width="80">Unit</th>
                                                    <th field="harga"    width="120" align="right">Price</th>
                                                    <th field="total"    width="120" align="right">Total Price</th>
                                                    <th field="ponum"    width="80">PO Number</th>
                                                    <th field="poitem"   width="80">PO Item</th>
                                                </tr>
                                            </thead>
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

    <!-- url="<?= BASEURL; ?>/payment/grdata/<?= $data['grnum']; ?>/<?= $data['year']; ?>" -->
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            var totalpayment = 0;
            readpodata();
            function readpodata(){
                $.ajax({
                    url: base_url+"/payment/grdata/<?= $data['grnum']; ?>/<?= $data['year']; ?>",
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        for(var i = 0; i < result.length; i++){
                            $('#dg').datagrid('appendRow',{
                                gritem      : result[i].gritem,
                                kodebrg     : result[i].kodebrg,
                                namabrg     : result[i].namabrg,
                                jumlah      : result[i].jumlah,
                                satuan      : result[i].satuan,
                                harga       : formatRupiah(result[i].harga,''),
                                total       : formatRupiah(result[i].jumlah * result[i].harga,''),
                                ponum       : result[i].ponum, 
                                poitem      : result[i].poitem
                            });

                            totalpayment = totalpayment + (result[i].jumlah * result[i].harga);
                        }

                        $('#paytotal').html('Total Payment : '+formatRupiah(totalpayment,''))
                        $('#dg').datagrid('reload');
                    }
                });
            }

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

            $('#btn-view-file').on('click', function(){
                var filename = "<?= $data['file']['filename']; ?>";
                if(filename != ''){
                    window.open(base_url+"/images/grfile/"+filename, '_blank');
                }else{
                    showErrorMessage('No file uploaded')
                }
            })

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

                var ivtotal = 0;

                var rows = $('#dg').datagrid('getRows');
                console.log(rows)
                for(var i = 0; i < rows.length; i++){
                    let object = new Object();
                    object["ivitem"]       = i + 1;
                    object["ponum"]        = rows[i].ponum;
                    object["poitem"]       = rows[i].poitem;
                    object["kodebrg"]      = rows[i].kodebrg;
                    object["namabrg"]      = rows[i].namabrg;
                    object["quantity"]     = rows[i].jumlah;
                    object["unit"]         = rows[i].satuan;

                    var aharga     = rows[i].harga.split('.');
                    var xharga = '';
                    for(var x=0; x < aharga.length; x++){
                        xharga = xharga+''+aharga[x];
                    }

                    object["price"]        = xharga;
                    object["refdoc"]       = "<?= $data['grnum'] ?>";
                    object["refdocitem"]   = rows[i].gritem;
                    object["ivdate"]       = $('#ivdate').val();
                    ivitems.push(object);

                    ivtotal = ivtotal + (xharga * rows[i].jumlah)
                }

                oheader.vendor     = $('#vendor').val();
                oheader.namavendor = $('#namavendor').val();
                oheader.ivdate     = $('#ivdate').val();
                oheader.note       = $('#note').val();
                oheader.project    = $('#idproject').val();
                oheader.grnum      = "<?= $data['grnum'] ?>";
                oheader.totalinv   = ivtotal;
                oheader.bankacc    = $('#bankacc').val();
                ivhead.push(oheader);

                ivdata = {
                    'header' : ivhead,
                    'items'  : ivitems
                }

                console.log(ivdata)
                showBasicMessage();
                $("#btn-process").attr("disabled", true);
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