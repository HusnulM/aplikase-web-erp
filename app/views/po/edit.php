<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Purchase Order <b><?= $data['pohead']['ponum']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="vendor">Vendor</label>
                                                <input type="hidden" id="ponum" value="<?= $data['pohead']['ponum']; ?>">
                                                <input type="hidden" id="vendor"value="<?= $data['pohead']['idsupp']; ?>" >
                                                <input type="text" name="namavendor" id="namavendor" class="form-control" placeholder="Vendor" value="<?= $data['pohead']['namavendor']; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br>
                                                <button class="btn btn-primary" type="button" id="btn-search-vendor">Choose Vendor</button>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control" placeholder="Note" value="<?= $data['pohead']['keterangan']; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" id="idproject" value="<?= $data['pohead']['idproject']; ?>">
                                                <label for="project">Project</label>
                                                <input type="text" name="project" id="project" class="form-control" placeholder="Project" value="<?= $data['pohead']['project']; ?>" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="podate">Order Date</label>
                                                <input type="date" name="podate" id="podate" class="datepicker form-control" placeholder="" value="<?= $data['pohead']['tgl_order']; ?>">
                                            </div>
                                        </div>    
                                    </div>
                                    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="checkbox" id="poref" class="filled-in"/>
                                                <label for="poref">Pilih Barang Dari Purchase Request </label> 
                                            </div>
                                        </div>    
                                    </div>  -->
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card" id="div-po-item">
                        <!-- PO Item -->
                        <div class="header">
                            <h2>
                                Purchase Order Item
                            </h2>

                            <ul class="header-dropdown m-r--5">          
                                <!-- <button type="button" id="btn-add-item" class="btn btn-success waves-effect pull-right">Tambah Item</button>

                                 -->
                                 <!-- <button type="button" id="btn-dlg-pilih" class="btn btn-success waves-effect m-r-20" >Pilih Item</button> -->
                                <a href="<?= BASEURL; ?>/po" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                    <button type="button" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>
                            </ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="dg" class="easyui-datagrid" style="width:98%;height:200px" toolbar="#toolbar" fitColumns="true" singleSelect="true">
                                    <thead>
                                        <tr>
                                            <th field="namabrg"  width="500">Item Name</th>
                                            <th field="quantity" width="120">Quantity</th>
                                            <th field="unit"     width="80">Unit</th>
                                            <th field="price"    width="120">Price</th>
                                            <th field="subtot"   width="120">Sub Total</th>
                                            <th field="prnum"    width="100">PR Number</th>
                                            <th field="pritem"   width="100">PR Item</th>
                                        </tr>
                                    </thead>
                                </table>
                                <div id="toolbar">
                                    <!-- <button class="easyui-linkbutton" iconCls="icon-add" plain="true" id="add-new-item">Add New Item</button> -->
                                    <button class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="btn-input-price">Change Price</button>
                                    <button class="easyui-linkbutton" iconCls="icon-remove" plain="true" id="delete-po-item">Delete Selected Item</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Add New Item</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                            <table class="table" id="list-pr">
                                    <thead>
                                        <tr>
                                            <th>PR Number</th>
                                            <th>Item</th>
                                            <!-- <th>Kode Barang</th> -->
                                            <th style="width:250px;">Item Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="vendorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="vendorModalLabel">Select Vendor</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table" id="list-vendor">
                                    <thead>
                                        <tr>
                                            <th>Vendor</th>
                                            <th>Vendor Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Harga / Edit Harga -->
            <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content modal-col-teal">
                        <div class="modal-header">
                            <h4 class="modal-title" id="smallModalLabel">Price</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="yharga" class="form-control" placeholder="Price">
                                    <input type="hidden" id="yqty" class="form-control" placeholder="">
                                    <input type="hidden" id="rindex">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-change-price" class="btn btn-primary waves-effect" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>
                     
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        
        $(function(){
            var vendor            = $('#vendor').val();
            var kodebrg           = '';
            var namabrg           = '';
            var namavendor        = '';
            var withref           = false;
            let detail_order_beli = [];
            let selected_data     = [];

            // alert(JSON.stringify("te"))

            $.ajax({
                url: base_url+'/po/getpoitem/'+$('#ponum').val(),
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    for(var i=0; i<result.length; i++){
                        add_po_item(result[i].kodebrg, result[i].namabrg, result[i].jumlah, result[i].satuan, result[i].harga,result[i].prnum,result[i].pritem);
                    }
                },error: function(err){
                }
            });

            if (vendor === ''){
                $('#div-po-item').hide()
            }else{
                $('#div-po-item').show()
            }

            $('#vendor').on('input', function(){
                autocomplete_vendor($('#vendor').val())
            })

            function autocomplete_vendor(param){
                vendor = '';
                namavendor = '';
                $("#vendor").autocomplete({
                    source: base_url+"/vendor/carivendor/"+param,
                    select: function(event, ui){				
                        var uilabel = ui.item.label.split(' ');
                        vendor     = uilabel[0];
                        for(var i=1; i < uilabel.length; i++){
                            namavendor = namavendor + ' ' + uilabel[i]
                        }
                        $('#div-po-item').show()
                    }
                }); 
            }       

            $('#btn-input-price').on('click', function(){
                var rows = $('#dg').datagrid('getSelections');
                if(rows.length > 1){
                    showErrorMessage('Please Select one item')
                }else if(rows.length < 1){
                    showErrorMessage('No data selected')
                }else{
                    var row = $('#dg').datagrid('getSelected');					
                    var rowIndex = $("#dg").datagrid("getRowIndex", row);
                    $('#smallModal').modal('show')
                    $('#yharga').val(row.price)
                    $('#yqty').val(row.quantity)
                    $('#rindex').val(rowIndex)
                }
            })

            $('#btn-change-price').on('click', function(){
                
                var idx   = $('#rindex').val();
                var harga = $('#yharga').val();
                var yqty  = $('#yqty').val();
                
                var aharga     = harga.split('.');
                var xharga = '';
                for(var x=0; x < aharga.length; x++){
                    xharga = xharga+''+aharga[x];
                }

                detail_order_beli[idx].harga = $('#yharga').val();

                $('#dg').datagrid('updateRow', {
                    index: idx,
                    row: {
                        price     : formatRupiah(xharga,''),
                        subtot    : formatRupiah(xharga * yqty, '')
                    }
                });

                $('#dg').datagrid('reload');
                $('#smallModal').modal('hide')
            })

            $('#add-new-item').on('click', function(){
                $('#largeModal').modal('show');
                $('#list-pr').dataTable( {
                    "ajax": base_url+'/po/listopenpritem',
                    "columns": [
                        { "data": "prnum" },
                        { "data": "pritem" },
                        { "data": "kodebrg" },
                        { "data": "namabrg" },
                        { "data": "jumlah" },
                        { "data": "satuan" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Add</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   false,
                    "searching":   false,
                });

                $('#list-pr tbody').on( 'click', 'button', function () {
                    var table = $('#list-pr').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    var data_exists = false;

                    for(var i = 0; i < detail_order_beli.length; i++){
                        if(detail_order_beli[i].prnum == selected_data.prnum && detail_order_beli[i].pritem == selected_data.pritem ){
                            data_exists = true;
                        }
                    }

                    if(data_exists == false){
                        add_po_item('', selected_data.namabrg, selected_data.jumlah, 
                                selected_data.satuan, selected_data.harga, 
                                selected_data.prnum, selected_data.pritem)
                    }else{
                        showErrorMessage('PR '+ selected_data.prnum + ' and PR Item ' + selected_data.pritem + ' Already exist in PO Item')
                    }
                } );
            })   

            $('#btn-search-vendor').on('click', function(){
                $('#vendorModal').modal('show');
                
                $('#list-vendor').dataTable({
                    "ajax": base_url+'/vendor/vendorlist',
                    "columns": [
                        { "data": "vendor" },
                        { "data": "namavendor" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Select</button>"}
                    ],
                    // "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-vendor tbody').on( 'click', 'button', function () {
                    var table = $('#list-vendor').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    // alert(selected_data.namavendor)
                    vendor     = selected_data.vendor;
                    namavendor = selected_data.namavendor;
                    $('#vendor').val(selected_data.vendor);
                    $('#namavendor').val(selected_data.namavendor);
                    $('#vendorModal').modal('hide');
                } );
            }) 

            function clearinput(){
                $('#namabrg').val('')
                $('#jumlah').val('')
                $('#satuan').val('')
                $('#harga').val('')
            }

            $('#btn-save').on('click', function(){
                
                $("#btn-save").attr("disabled", true);
                if(vendor == ''){
                    showErrorMessage('Input Vendor')
                }else if($('#podate').val() == ''){
                    showErrorMessage('Input Order Date')
                }else{

                    if(detail_order_beli.length > 0){
                        let object = new Object();
                        var oheader = {};
                        var oitem   = {};
                        var podata  = {};
                        var header  = [];
                        var items   = [];

                        oheader.idsupplier = $('#vendor').val();
                        oheader.nmsupplier = $('#namavendor').val();
                        oheader.tglorder   = $('#podate').val();
                        oheader.note       = $('#note').val();
                        oheader.project    = $('#idproject').val();
                        header.push(oheader);

                        for(var i=0; i < detail_order_beli.length; i++){
                            oitem = {};
                            oitem.poitem   = i + 1;
                            oitem.kodebrg  = detail_order_beli[i].kodebrg;
                            oitem.namabrg  = detail_order_beli[i].namabrg;
                            oitem.jmlPesan = detail_order_beli[i].jmlPesan;
                            oitem.satuan   = detail_order_beli[i].satuan.toUpperCase();
                            var aharga     = detail_order_beli[i].harga.split('.');
                            var xharga = '';
                            for(var x=0; x < aharga.length; x++){
                                xharga = xharga+''+aharga[x];
                            }
                            oitem.harga    = xharga;
                            oitem.prnum    = detail_order_beli[i].prnum;
                            oitem.pritem   = detail_order_beli[i].pritem;
                            items.push(oitem);
                        }

                        podata = {
                            'header' : header,
                            'items'  : items
                        }
                        $.ajax({
                            url: base_url+'/po/updatepo/'+$('#ponum').val(),
                            data: podata,
                            type: 'POST',
                            dataType: 'json',
                            cache:false,
                            success: function(result){
                                showSuccessMessage('PO '+ $('#ponum').val() + ' Updated')
                                detail_order_beli = [];
                                setpoitem();
                                $("#btn-save").attr("disabled", false);
                            },error: function(err){
                                showSuccessMessage(JSON.stringify(err))
                            }
                        });
                        
                        $('#vendor').val('');
                        $('#note').val('');
                    }else{
                        showErrorMessage('No PO Item')
                        $("#btn-save").attr("disabled", false);
                    }
                }    
                $("#btn-save").attr("disabled", false);            
            })

            $('#delete-po-item').on('click', function(){
                var ids = [];
                var rows = $('#dg').datagrid('getSelections');
                for(var i=0; i<rows.length; i++){
                    ids.push(rows[i].namabrg);
                    var rowIndex = $("#dg").datagrid("getRowIndex", rows[i]);
                    $('#dg').datagrid('deleteRow', rowIndex);
                    removeitem(rowIndex)
                }
                $('#dg').datagrid('reload');
            })

            function removeitem(index){
                detail_order_beli.splice(index, 1);
            }

            var yharga = document.getElementById('yharga');

            yharga.addEventListener('keyup', function(e){
                yharga.value = formatRupiah(this.value, '');
            });

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

            function add_po_item(pkodebrg, namabrg, jmlPesan, satuan, harga, prnum, pritem){
                let object = new Object();                    
                if(namabrg == ""){
                    showErrorMessage('Input Item Name')
                }else if(jmlPesan == ""){
                    showErrorMessage('Input Quantity')
                }else if(harga == ""){
                    showErrorMessage('Input Price')
                }else{

                    var aharga     = harga.split('.');
                    var xharga = '';
                    for(var x=0; x < aharga.length; x++){
                        xharga = xharga+''+aharga[x];
                    }
                    
                    object["kodebrg"]  = pkodebrg;
                    object["namabrg"]  = namabrg;
                    object["jmlPesan"] = jmlPesan;
                    object["satuan"]   = satuan;
                    object["harga"]    = harga;
                    object["prnum"]    = prnum;
                    object["pritem"]   = pritem;
                    detail_order_beli.push(object);

                    var count = $('#dg').datagrid('getRows');

                    $('#dg').datagrid('appendRow',{
                        item        : count.length + 1,
                        namabrg     : namabrg,
                        quantity  	: jmlPesan,
                        unit        : satuan.toUpperCase(),
                        price       : formatRupiah(xharga,''), 
                        subtot      : formatRupiah(xharga * jmlPesan, ''),
                        prnum       : prnum,
                        pritem      : pritem
                    });
                    $('#dg').datagrid('reload');		
                    kodebrg = '';
                }
            }

            function removeitem(index){
                detail_order_beli.splice(index, 1);
                setpoitem();
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/po';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        })

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }        
    </script>