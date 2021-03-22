<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Receipt Purchase Order <b><?= $data['pohead']['ponum']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <form enctype="multipart/form-data">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" id="ponum" value="<?= $data['pohead']['ponum']; ?>">
                                                <input type="hidden" id="vendor" value="<?= $data['pohead']['idsupp']; ?>">
                                                <label for="namavendor">Vendor</label>
                                                <input type="text" name="namavendor" id="namavendor" class="form-control" placeholder="Vendor" value="<?= $data['pohead']['namasup']; ?>" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="grdate">Receipt Date</label>
                                                <input type="date" name="grdate" id="grdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control" placeholder="Note">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="btn btn-primary btn-sm float-left">
                                            <span>Upload File</span>
                                                <input type="file" id="ifile">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                            <label id="pricetotal"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card" id="div-po-item">
                        <!-- PO Item -->
                        <div class="header">
                            <h2>
                                Receipt Item
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <a href="<?= BASEURL; ?>/grpo" type="button" id="btn-back" class="btn btn-danger"  data-type="danger">Cancel</a>
                                <button type="button" id="btn-process" class="btn btn-primary"  data-type="success">Post Data</button>
                                <!-- <button type="button" id="btn-upload" class="btn btn-primary"  data-type="success">Upload File</button> -->
                            </ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="dg" class="easyui-datagrid" style="width:98%;height:200px" toolbar="#toolbar" fitColumns="true" singleSelect="false">
                                            <thead>
                                                <tr>
                                                    <th field="ck"       checkbox="true">Item Name</th>
                                                    <th field="item"  width="50">No</th>
                                                    <th field="namabrg"  width="500">Item Name</th>
                                                    <th field="jumlah"   width="120" align="right">Quantity</th>
                                                    <th field="grqty"   width="150" align="right">Input Received Qty</th>
                                                    <th field="satuan"   width="80">Unit</th>
                                                    <th field="harga"    width="120" align="right" >Price</th>
                                                    <th field="subtot"   width="120" align="right">Total Price</th>
                                                </tr>
                                            </thead>
                                </table>
                                <div id="toolbar">
                                    <button class="easyui-linkbutton" iconCls="icon-remove" plain="true" id="delete-gr-item">Delete Selected Item</button>
                                    <button class="easyui-linkbutton" iconCls="icon-edit" plain="true" id="gr-item-detail">Change Receipt Quantity</button>
                                    <button class="easyui-linkbutton" iconCls="icon-reload" plain="true" id="refresh-gr-item">Refresh Data</button>
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
                            <h4 class="modal-title" id="largeModalLabel">Receipt Item Data</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="namabrg">Item Name</label>
                                            <input type="text" name="namabrg" id="namabrg" class="form-control" placeholder="Item Name" autocomplete="false" readonly="true"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="podate">Quantity</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Quantity" onkeypress="return isNumber(event)" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="rgrqty">Total Received Quantity</label>
                                            <input type="number" name="rgrqty" id="rgrqty" class="form-control" placeholder="Receipt Quantity" onkeypress="return isNumber(event)" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="grqty">Input Received Quantity</label>
                                            <input type="number" name="grqty" id="grqty" class="form-control" placeholder="Receipt Quantity" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="satuan">Unit</label>
                                            <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Unit" style="text-transform:uppercase" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="harga">Price</label>
                                            <input type="text" name="harga" id="harga" class="form-control" placeholder="Price" readonly="true">
                                        </div>
                                    </div>
                                </div>                                                                     
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-change-item" class="btn btn-primary">Change Data</button>
                        </div>
                    </div>
                </div>
            </div>
		
		<div id="spinner" class="spinner" style="display:none;">
                <img id="img-spinner" src="<?= BASEURL; ?>/images/spinningwheel.gif" alt="Loading"/>
            </div>
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>

        $(function(){
			
			$("#spinner").bind("ajaxSend", function() {
                $(this).show();
            }).bind("ajaxStop", function() {
                $(this).hide();
            }).bind("ajaxError", function() {
                $(this).hide();
            });
			
            let gr_item           = [];
            let selected_data     = [];
            var totalprice = 0;

            var ponum = "<?= $data['ponum']; ?>";
            readpodata();
            function readpodata(){
                $.ajax({
                    url: base_url+'/po/getPODtl/'+ponum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        for(var i = 0; i < result.length; i++){
                            add_gr_item(result[i].ponum, result[i].poitem, result[i].kodebrg,result[i].namabrg, 
                                        result[i].jumlah,result[i].grqty,result[i].satuan, 
                                        result[i].harga,result[i].grqty)
                        }
                    }
                });
            }
            $('#refresh-gr-item').on('click', function(){
                $('#dg').datagrid('loadData', []);
                gr_item = [];
                totalprice = 0;
                readpodata()
            })

            $('#btn-change-item').on('click', function(){
                var row      = $('#dg').datagrid('getSelected');					
                var rowIndex = $("#dg").datagrid("getRowIndex", row);
                console.log(row)
                // alert($('#grqty').val())

                if((($('#grqty').val()*1) + ($('#rgrqty').val()*1)) > ($('#jumlah').val()*1)){
                    showWarningMessage('Total Receipt Quantity Greater than PO Quantity!')
                }else{
                    doeditRow(rowIndex, $('#grqty').val(), $('#harga').val())
                }
            })

            function doeditRow(rowIndex, grqty, price) {
                var aharga = price.split('.');
                var xharga = '';

                for(var x=0; x < aharga.length; x++){
                    xharga = xharga+''+aharga[x];
                }

                $('#dg').datagrid('updateRow', {
                    index: rowIndex,
                    row: {
                        grqty   : grqty,
                        subtot  : formatRupiah(grqty * xharga,'')
                    }
                });

                gr_item[rowIndex].grqty    = grqty;

                
                
                console.log(gr_item)
                var totharga = 0;
                // var rows = $('#dg').datagrid('getRows');
                for(var i = 0; i < gr_item.length; i++){
                    totharga = totharga + (gr_item[i].grqty * gr_item[i].harga);
                }
                $('#pricetotal').html('Total Price : '+formatRupiah(totharga,''))
                $('#dg').datagrid('reload');
                $('#largeModal').modal('hide');
            }
            // $('#poitem').dataTable({});
            function add_gr_item(ponum,poitem,pkodebrg,namabrg,qty,grqty,satuan,harga,rgrqty){
                var sgrqty = 0;
                
                if(grqty > 0){
                    var tgrqty = qty-grqty;
                }else{
                    var tgrqty = qty;
                }

                var tmpqty = tgrqty.toString().split('.');
                if(tmpqty.length > 1){
                    sgrqty = tmpqty[1];
                    sgrqty = sgrqty.substring(0,3)
                    sgrqty = sgrqty.replace('0','')
                    sgrqty = tmpqty[0]+'.'+sgrqty
                }else{
                    sgrqty = tgrqty;
                }

                let object = new Object();
                object["ponum"]     = ponum;
                object["poitem"]    = poitem;
                object["kodebrg"]   = pkodebrg;
                object["namabrg"]   = namabrg;
                object["jumlah"]    = qty;
                object["grqty"]     = sgrqty;
                object["satuan"]    = satuan;
                object["harga"]     = harga;
                object["rgrqty"]    = grqty;
                gr_item.push(object);

                var aharga     = harga.split('.');
                var xharga = '';
                for(var x=0; x < aharga.length; x++){
                    xharga = xharga+''+aharga[x];
                }                
                var subtotal = 0;
                console.log(qty);
                console.log(sgrqty)
                if(grqty > 0){
                    totalprice = totalprice + (sgrqty * xharga);
                    subtotal   = (sgrqty * xharga);
                }else{
                    totalprice = totalprice + (qty * xharga);
                    subtotal   = qty * xharga;
                }
                
                $('#pricetotal').html('Total Price : '+formatRupiah(totalprice,''))

                var count = $('#dg').datagrid('getRows');
                
                // alert(sgrqty)
                $('#dg').datagrid('appendRow',{
                    item        : count.length + 1,
                    ponum       : ponum,
                    poitem      : poitem,
                    namabrg     : namabrg,
                    jumlah  	: qty,
                    grqty       : sgrqty,
                    satuan      : satuan,
                    harga       : formatRupiah(xharga,''), 
                    subtot      : formatRupiah(subtotal, ''),
                });

                $('#dg').datagrid('reload');
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

            function getgrqty(poitem){
                $.ajax({
                    url: base_url+'/grpo/getgrqty/'+ponum+'/'+poitem,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        $('#rgrqty').val(result.grqty)
                    }
                });
            }
            

            $('#gr-item-detail').on('click', function(){
                var ids = [];
                var rows = $('#dg').datagrid('getSelections');
                if(rows.length > 1){
                    showErrorMessage('Please select one item')
                }else if(rows.length < 1){
                    showErrorMessage('No item selected')
                }
                else{

                    getgrqty(rows[0].poitem);
                    $('#largeModal').modal('show')
                    $('#namabrg').val(rows[0].namabrg)
                    $('#jumlah').val(rows[0].jumlah)
                    $('#grqty').val(rows[0].grqty)
                    
                    $('#satuan').val(rows[0].satuan)
                    $('#harga').val(rows[0].harga)
                }
                
            })
            $('#delete-gr-item').on('click', function(){
                var ids = [];
                var rows = $('#dg').datagrid('getSelections');
                for(var i=0; i<rows.length; i++){
                    ids.push(rows[i].namabrg);
                    var rowIndex = $("#dg").datagrid("getRowIndex", rows[i]);
                    $('#dg').datagrid('deleteRow', rowIndex);
                    removeitem(rowIndex)
                }
                // alert(ids.join('\n'));
                $('#dg').datagrid('reload');
            })

            function removeitem(index){
                gr_item.splice(index, 1);
                var totharga = 0;
                for(var i = 0; i < gr_item.length; i++){
                    totharga = totharga + (gr_item[i].grqty * gr_item[i].harga);
                }
                $('#pricetotal').html('Total Price : '+formatRupiah(totharga,''))
            }
            
            $('#btn-process').on('click', async function(){
                
                console.log(gr_item)
                if($('#ifile').val() == ''){
                    showErrorMessage('Please attach file!')
                }else{
                    if (gr_item.length > 0){
                        var oheader = {};
                        var oitem   = {};
                        var grdata  = {};
                        var header  = [];
                        var items   = [];
                        
                        oheader.vendor     = $('#vendor').val();
                        oheader.namavendor = $('#namavendor').val();
                        oheader.tglterima  = $('#grdate').val();
                        oheader.note       = $('#note').val();
                        oheader.project    = '0';
                        header.push(oheader);

                        var heads = [];
                        $("thead").find("th").each(function () {
                            heads.push($(this).text().trim().replace(/\s/g, ''));
                        });
                        var rows = [];
                        $("tbody tr").each(function () {
                            cur = {};
                            $(this).find("td").each(function(i, v) {
                                cur[heads[i]] = $(this).text().trim();
                            });
                            rows.push(cur);
                            cur = {};
                        });

                        for(var i = 0; i < gr_item.length; i++){
                            let object = new Object();
                            object["ponum"]     = gr_item[i].ponum;
                            object["poitem"]    = gr_item[i].poitem;
                            object["kodebrg"]   = gr_item[i].kodebrg;
                            object["namabrg"]   = gr_item[i].namabrg;
                            object["jumlah"]    = gr_item[i].jumlah;
                            object["grqty"]     = gr_item[i].grqty;
                            object["satuan"]    = gr_item[i].satuan;
                            object["harga"]     = gr_item[i].harga;
                            items.push(object);
                        }

                        grdata = {
                            'header' : header,
                            'items'  : items
                        }
                        $("#btn-save").attr("disabled", true);
                        console.log(grdata)
                        //$('#spinner').show();
                        showLoading();
                        $.ajax({
                            url: base_url+'/grpo/post',
                            data: grdata,
                            type: 'POST',
                            dataType: 'json',
                            cache:false,
                            success: await function(result){
                                // console.log(result)
                                // showSuccessMessage('Receipt PO Successfully '+ JSON.stringify(result))
                            },error: function(err){
                                showErrorMessage(JSON.stringify(err))
                            }
                        }).done(function(data){
                            if( document.getElementById("ifile").files.length == 0 ){
                                showSuccessMessage('Receipt PO Successfully '+ data)
                            }else{
                                showBasicMessage();
                                uploadFile(data);
                            }
                            $("#btn-save").attr("disabled", false);
                        });
                    }else{
                        showErrorMessage('No receive items')
                    }
                }
            });

            function uploadFile(refdoc){
                var fd = new FormData();
                var files = $('#ifile')[0].files[0];
                fd.append('file',files);

                if(files){
                    $.ajax({
                        url: base_url+'/grpo/uploadfile/'+refdoc,
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
							showSuccessMessage('Receipt PO Successfully '+ refdoc)
                        },
                        error: function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    });
                }
            }
			
			function showBasicMessage() {
                swal({title:"Loading...", text:"Uploading file", showConfirmButton: false});
            }

            function showLoading() {
                swal({title:"Loading...", text:"Sending Email...", showConfirmButton: false});
            }
			
            function showSuccessMessage(message) {
                // swal("Success", message, "success");
                swal({title: "Success", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/grpo';
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