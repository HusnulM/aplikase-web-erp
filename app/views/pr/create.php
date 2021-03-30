    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-pr-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create Purchase Request
                            </h2>
                        </div>
                        <div class="body">
                            
                                <div class="row clearfix">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control" placeholder="Note">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Request Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control" placeholder="">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick" name="warehouse" id="warehouse">
                                                    <option value="">Select Warehose</option>
                                                    <?php foreach($data['whs'] as $out) : ?>
                                                    <option value="<?= $out['gudang']; ?>"><?= $out['deskripsi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-8 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="requestor">Requestor</label>
                                                <input type="text" class="form-control" name="requestor" id="requestor">
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Request Item
                            </h2>
                                    
                            <ul class="header-dropdown m-r--5">                                
                                
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Material</th>
                                                <th>Material Description</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Remark</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">

                                        </tbody>
                                    </table>
                                    <ul class="pull-right">    
                                        <button type="button" id="btn-dlg-add-item" class="btn bg-blue">
                                            <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
                                        </button>
                                        <a href="<?= BASEURL; ?>/pr" class="btn bg-red">
                                            <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                        </a>
                                        <button type="submit" class="btn bg-blue">
                                            <i class="material-icons">save</i> <span>SAVE</span>
                                        </button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>

            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Add Purchase Request Item</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="namabrg">Item Name</label>
                                            <input type="text" name="namabrg" id="namabrg" class="form-control" placeholder="Item Name" autocomplete="false" > 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">-</label>
                                            <button id="btn-pilih-barang" class="form-control btn btn-primary">Pilih Barang</button> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="btn btn-primary btn-sm float-left" style="width:100%;">
                                            <span>Upload Photo Barang</span>
                                            <input type="file" id="ifile" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <button class="form-control btn btn-primary" id="btn-clear-file">Clear File</button>
                                    </div>
                                </div>  
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="podate">Quantity</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Quantity" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="satuan">Unit</label>
                                            <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Unit" style="text-transform:uppercase">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="hidden" name="harga" id="harga" class="form-control" placeholder="Price">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="remark" class="form-control" id="remark" cols="30" rows="3" placeholder="Remark"></textarea>
                                        </div>
                                    </div>
                                </div>                                                                     
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-add-item" class="btn btn-primary">Add Item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="barangModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModal">Pilih Material</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-barang" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <th>Unit</th>
                                            <th>Order Unit</th>
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
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });
        
        $(function(){
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;

            $('#namabrg').on('input', function(){
                // autocomplete_produk($('#namabrg').val())
            })

            loaddatabarang();
            function loaddatabarang(){
                $('#list-barang').dataTable({
                    "ajax": base_url+'/barang/listbarang',
                    "columns": [
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "partname" },
                        { "data": "partnumber" },
                        { "data": "matunit" },
                        { "data": "orderunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-barang tbody').on( 'click', 'button', function () {
                    var table = $('#list-barang').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    kodebrg = selected_data.material;
                    $('#namabrg').val(selected_data.matdesc);
                    $('#satuan').val(selected_data.orderunit);
                    // $('#barangModal').modal('hide');

                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ selected_data.material +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ selected_data.matdesc +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px; text-align:right;" required="true" autocomplete="off"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ selected_data.matunit +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_remark[]" class="form-control" style="width:200px;" counter="`+count+`" id="poprice`+count+`" autocomplete="off"/>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-pr-body').append(html);
                    renumberRows();

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
                    })

                    $('.materialCode').on('change', function(){
                        var xcounter = $(this).attr('counter');
                        var kodebrg  = $('#material'+xcounter).val();

                        getMaterialbyKode(kodebrg, function(d){
                            console.log(d)
                            $('#matdesc'+xcounter).val(d.matdesc);
                            $('#unit'+xcounter).val(d.matunit);
                        });
                    })

                    $('.inputNumber').on('change', function(){
                        this.value = formatRupiah(this.value, '');
                    })
                } );
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }
            
            function autocomplete_produk(namaproduk){
                // alert(namaproduk)
                kodebrg = '';
                namabrg = '';
                $("#namabrg").autocomplete({
                    source: base_url+"/barang/caribarang/"+namaproduk,
                    select: function(event, ui){				
                        var uilabel = ui.item.label.split(' ');
                        kodebrg = '';
                        namabrg = '';
                        kodebrg = uilabel[0];
                        // namabrg = uilabel[1];
                        console.log(uilabel);
                        $('#satuan').val(uilabel[uilabel.length - 1]);
                        getnamabarang(kodebrg)
                    }
                }); 
            }

            function getnamabarang(_kodebrg){
                $.ajax({
                    url: base_url+'/barang/caribarangbykode/'+_kodebrg,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        namabrg = result.namabrg
                    }
                });                
            }

            $('#btn-dlg-add-item').on('click', function(){
                $('#barangModal').modal('show')
            })

            $('#btn-pilih-barang').on('click', function(){
                $('#barangModal').modal('show')
            });

            $('#add-new-item').on('click', function(){
                $('#largeModalLabel').html('Add New Item')
                $('#largeModal').modal('show');
                $('#btn-add-item').html('Add Item');
                action = 'add';
            })

            $('#edit-pr-item').on('click', function(){
                var row      = $('#dg').datagrid('getSelected');					
                var rowIndex = $("#dg").datagrid("getRowIndex", row);
                if(rowIndex == "-1"){
                    showErrorMessage('No data selected')
                }else{
                    $('#largeModalLabel').html('Edit Item')
                    $('#largeModal').modal('show');
                    action = 'edit';
                    $('#btn-add-item').html('Update Item');

                    kodebrg = row.kodebrg;
                    $('#namabrg').val(row.namabrg); 
                    $('#jumlah').val(row.quantity);
                    $('#satuan').val(row.unit);
                    $('#harga').val(row.price);
                    $('#remark').val(row.remark);
                }
            });

            $('#form-pr-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/pr/savepr',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            // $('#btn-save').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	console.log(data);
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(data){
                        showSuccessMessage('PR Created '+ data)
                    })
            })

            $('#delete-pr-item').on('click', function(){
                deleterow();
            })

            $('#btn-save').on('click', async function(){
                    $("#btn-save").attr("disabled", true);
                    if(detail_order_beli.length > 0){
                        if ($('#reqdate').val() == ''){
                            showErrorMessage('Please fill request date')
                        }else if ($('#project').val() == ''){
                            showErrorMessage('Please select project')
                        }else{
                            let object = new Object();
                            let tglorder = $('#reqdate').val();
                            let tnote    = $('#note').val();
                            let project  = $('#project').val();

                            var oheader = {};
                            var oitem   = {};
                            var prdata  = {};
                            var header  = [];
                            var items   = [];

                            oheader.tglorder   = tglorder;
                            oheader.note       = tnote;
                            oheader.project    = $('#project').val();
                            oheader.warehouse  = $('#warehouse').val();
                            oheader.requestby  = $('#requestor').val();
                            header.push(oheader);

                            for(var i=0; i < detail_order_beli.length; i++){
                                oitem = {};
                                oitem.pritem   = i + 1;
                                oitem.kodebrg  = detail_order_beli[i].kodebrg;
                                oitem.namabrg  = detail_order_beli[i].namabrg;
                                oitem.jmlPesan = detail_order_beli[i].jmlPesan;
                                oitem.satuan   = detail_order_beli[i].satuan.toUpperCase();
                                var aharga = detail_order_beli[i].harga.split('.');  
                                var xharga = '';
                                for(var x=0; x < aharga.length; x++){
                                    xharga = xharga+''+aharga[x];
                                }
                                oitem.harga    = xharga;
                                oitem.remark   = detail_order_beli[i].remark;
                                items.push(oitem);
                            }

                            prdata = {
                                'header' : header,
                                'items'  : items
                            }

                            $("#btn-save").attr("disabled", true);
                            showBasicMessage();

                            $.ajax({
                                url: base_url+'/pr/savepr',
                                data: prdata,
                                type: 'POST',
                                dataType: 'json',
                                cache:false,
                                success: await function(result){
                                    
                                },error: await function(err){
                                    showErrorMessage(JSON.stringify(err))
                                    $("#btn-save").attr("disabled", false);
                                }
                            }).done(function(data){
                                if(imgupload.length > 0 ){
                                    uploadfile(data);
                                }else{
                                    showSuccessMessage('PR Created '+ data)
                                    detail_order_beli = [];
                                    setpritem();
                                    $("#btn-save").attr("disabled", false);
                                }
                            });
                            
                            $('#note').val('');
                        }
                    }else{
                        showErrorMessage('Request item is empty')
                    }       
                    
                    $("#btn-save").attr("disabled", false);
            })

            function uploadfile(prnum){
                for(var i = 0; i < imgupload.length; i++){
                    var fd = new FormData();
                    var item = (i+1)*1;
                    fd.append('file',imgupload[i].files);
                    $.ajax({
                        url: base_url+'/pr/uploadfile/'+prnum+'/'+item,
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){
							showSuccessMessage('PR Created '+ prnum)
                            detail_order_beli = [];
                            setpritem();
                            $("#btn-save").attr("disabled", false);
                        },
                        error: function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    });
                }
            }

            $('#btn-add-item').on('click', function(){		
                let object = new Object();
                let harga    = 0;
                let jmlPesan = $('#jumlah').val();
                let satuan   = $('#satuan').val();
                namabrg      = $('#namabrg').val();

                if(namabrg == ""){
                    showErrorMessage('Input Item Name')
                }else if(jmlPesan == ""){
                    showErrorMessage('Input Quantity')
                }else if(satuan == ""){
                    showErrorMessage('Input Unit')
                }else{
                    if(action === 'add'){
                        var aharga = $('#harga').val().split('.');
                        var xharga = '';
                        for(var x=0; x < aharga.length; x++){
                            xharga = xharga+''+aharga[x];
                        }

                        object["kodebrg"]  = kodebrg;
                        object["namabrg"]  = $('#namabrg').val();
                        object["jmlPesan"] = jmlPesan;
                        object["satuan"]   = satuan;
                        object["harga"]    = xharga;
                        object["total"]    = xharga * jmlPesan;
                        object["remark"]   = $('#remark').val();

                        detail_order_beli.push(object);	

                        var count = $('#dg').datagrid('getRows');
                        var pritem = (detail_order_beli.length)*1;

                        $('#dg').datagrid('appendRow',{
                            item        : count.length + 1,
                            namabrg     : $('#namabrg').val(),
                            quantity	: jmlPesan,
                            unit        : satuan.toUpperCase(),
                            price       : $('#harga').val(), 
                            subtot      : formatRupiah(xharga * jmlPesan, ''),
                            remark      : $("#remark").val()
                        });

                        var files = $('#ifile')[0].files[0];
                        
                        if(files){
                            let imgobject = new Object();
                            imgobject["pritem"] = pritem;
                            imgobject["files"]  = files;
                            imgupload.push(imgobject)
                        }
                        
                        console.log(imgupload)
                        $("#ifile").val('');

                    }else if(action === 'edit'){
                        var row      = $('#dg').datagrid('getSelected');					
                        var rowIndex = $("#dg").datagrid("getRowIndex", row);

                        var aharga = $('#harga').val().split('.');
                        var xharga = '';
                        for(var x=0; x < aharga.length; x++){
                            xharga = xharga+''+aharga[x];
                        }

                        detail_order_beli[rowIndex].namabrg  = $('#namabrg').val();
                        detail_order_beli[rowIndex].jmlPesan = jmlPesan;
                        detail_order_beli[rowIndex].satuan   = satuan;
                        detail_order_beli[rowIndex].harga    = xharga;
                        detail_order_beli[rowIndex].total    = xharga * jmlPesan;
                        detail_order_beli[rowIndex].remark   = $('#remark').val();

                        var files = $('#ifile')[0].files[0];
                        
                        if(files){
                            imgupload.splice(rowIndex,1);
                            let imgobject = new Object();
                            imgobject["pritem"] = (rowIndex+1)*1;;
                            imgobject["files"]  = files;
                            imgupload.push(imgobject)
                        }
                        console.log(imgupload)
                        $("#ifile").val('');

                        doeditRow(rowIndex, $('#namabrg').val(), jmlPesan, satuan, xharga, $("#remark").val());
                    }

                    $('#dg').datagrid('reload');
                    $('#largeModal').modal('hide');
                    kodebrg = '';
                    namabrg = '';
                    clearinput();
                }
            })

            function doeditRow(rowIndex, namabrg, qty, unit, price, remark) {
                $('#dg').datagrid('updateRow', {
                    index: rowIndex,
                    row: {
                        kodebrg   : kodebrg,
                        namabrg   : namabrg,
                        quantity  : qty,
                        unit      : unit,
                        // price     : formatRupiah(price,''),
                        // subtot    : formatRupiah(price * qty, ''),
                        remark    : remark
                    }
                });
            }

            function createCell(i, row, text) {
                var btn = document.createElement('input');
                var td = document.createElement('td');
                var content = document.createTextNode(text);

                if(text == 'Edit'){			
                    btn.type = "button";
                    btn.className = "btn btn-primary btn-xs";
                    btn.value     = 'Edit';
                    td.appendChild(btn);
                    td.addEventListener('click', function() { 
                        edititem(i);
                    }, false);
                }else if(text == 'Hapus'){			
                    btn.type = "button";
                    btn.className = "btn btn-danger btn-xs";
                    btn.value     = 'Hapus';
                    td.appendChild(btn);
                    td.addEventListener('click', function() { 
                        removeitem(i);
                    }, false);
                }else{
                    td.appendChild(content);
                }	
                row.appendChild(td);
            }

            function clearinput(){
                $('#namabrg').val('');
                $('#jumlah').val('');
                $('#satuan').val('');
                $('#harga').val('');
                $('#remark').val('');
            }

            function deleterow(){
                var row = $('#dg').datagrid('getSelected');					
                var rowIndex = $("#dg").datagrid("getRowIndex", row);

                var index = rowIndex+1;
                $('#dg').datagrid('deleteRow', rowIndex);
                removeitem(rowIndex)
                // $.messager.confirm('Confirm','Are you sure to delete PR item '+ index +' ?',function(r){
                //     if (r){
                //         $('#dg').datagrid('deleteRow', rowIndex);
                //     }
                // });
            }

            function removeitem(index){
                detail_order_beli.splice(index, 1);
                // setpritem();
            }

            function setpritem(){
                $("#tbl-body").html('');
                for(var i = 0; i < detail_order_beli.length; i++){
                    let num   = i + 1;
                    var tr = document.createElement('tr');
                    createCell(i, tr, num);
                    // createCell(i, tr, detail_order_beli[i].kodebrg);
                    createCell(i, tr, detail_order_beli[i].namabrg);
                    createCell(i, tr, detail_order_beli[i].jmlPesan);
                    createCell(i, tr, detail_order_beli[i].satuan);	
                    createCell(i, tr, detail_order_beli[i].harga);	
                    createCell(i, tr, formatRupiah(detail_order_beli[i].total,''));	
                    // createCell(i, tr, 'Edit');		
                    createCell(i, tr, 'Hapus');			
                    document.querySelectorAll('#tbl-body')[0].appendChild(tr);
                }

                $('#nmBarang').val('');
                $('#jmlPesan').val('');
                $('#hargabarang').val('');
            }

            var harga  = document.getElementById('harga');

            harga.addEventListener('keyup', function(e){
                harga.value = formatRupiah(this.value, '');
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

            function showBasicMessage() {
                swal({title:"Loading...", text:"Mohon Menunggu", showConfirmButton: false});
            }

            function showSuccessMessage(message) {
                // swal("Success", message, "success");
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/pr';
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