<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-pr-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                            Display Purchase Request <?= $data['prhead']['prnum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">        
                            <button type="button" id="btn-change" class="btn btn-success waves-effect">Change</button>                        
							<a href="<?= BASEURL; ?>/pr" class="btn btn-danger waves-effect">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['prhead']['note']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Request Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['prhead']['prdate']; ?>">
                                            </div>
                                        </div>    
                                    </div>

                                    <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="project">Project</label>
                                                <select class="form-control show-tick readOnly" name="project" id="project">
                                                    <option value="<?= $data['prhead']['idproject']; ?>"><?= $data['_prj']['namaproject']; ?></option>
                                                    <?php foreach($data['project'] as $proj) : ?>
                                                    <option value="<?= $proj['idproject']; ?>"><?= $proj['namaproject']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div> -->

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick readOnly" name="warehouse" id="warehouse">
                                                    <option value="<?= $data['prhead']['warehouse']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
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
                                                <input type="text" class="form-control readOnly" name="requestor" id="requestor" value="<?= $data['prhead']['requestby']; ?>">
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
                                <button type="button" id="btn-dlg-add-item" class="btn bg-blue hideComponent">
                                    <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
                                </button>

                                <button type="submit" class="btn bg-blue hideComponent">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>
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
                                                <th class="hideComponent">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

            

            <div class="modal fade" id="barangModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModal">Pilih Barang</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-barang" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
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

        $(function(){
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;

            var sel_prnum = "<?= $data['prhead']['prnum']; ?>";

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
                        { "data": "matunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    // "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-barang tbody').on( 'click', 'button', function () {
                    var table = $('#list-barang').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
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
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px; text-align:right;" required="true" />
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ selected_data.matunit +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_remark[]" class="form-control" style="width:200px;" counter="`+count+`" id="poprice`+count+`"/>
                            </td>
                            <td class="hideComponent">
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

            $.ajax({
                url: base_url+'/pr/getpritem/'+sel_prnum,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    console.log(result)
                    for(var i=0; i<result.length; i++){
                        count = count+1;
                        html = '';
                        html = `
                            <tr counter="`+ count +`" id="tr`+ count +`">
                                <td class="nurut"> 
                                    `+ count +`
                                    <input type="hidden" name="itm_no[]" value="`+ count +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode readOnly" style="width:150px;" required="true" value="`+ result[i].material +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control readOnly" style="width:300px;" value="`+ result[i].matdesc +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber readOnly" style="width:100px; text-align:right;" required="true" value="`+ result[i].quantity.replaceAll('.00','') +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control readOnly" style="width:80px; readOnly" required="true" value="`+ result[i].unit +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_remark[]" class="form-control readOnly" style="width:200px;" counter="`+count+`" id="poprice`+count+`" value="`+ result[i].remark +`"/>
                                </td>
                                <td class="hideComponent">
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
                        });

                        $('.hideComponent').hide();
                        $('.readOnly').attr("readonly", true);
                    }
                    // for(var i=0; i<result.length; i++){
                    //     let object = new Object();
                    //     object["kodebrg"]  = result[i].material;
                    //     object["namabrg"]  = result[i].matdesc;
                    //     object["jmlPesan"] = result[i].quantity;
                    //     object["satuan"]     = result[i].unit;
                    //     object["remark"]   = result[i].remark;

                    //     detail_order_beli.push(object);		
                    //     // setpritem();
                    //     var count = $('#dg').datagrid('getRows');
                    //     $('#dg').datagrid('appendRow',{
                    //         item        : count.length + 1,
                    //         kodebrg     : result[i].material,
                    //         namabrg     : result[i].matdesc,
                    //         quantity	: result[i].quantity,
                    //         unit        : result[i].unit,
                    //         remark      : result[i].remark
                    //     });

                    //     $('#dg').datagrid('reload');
                    // }
                },error: function(err){
                }
            });

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }

            $('#form-pr-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/pr/updatepr/'+sel_prnum,
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
                        showSuccessMessage('PR ' + sel_prnum + ' Updated!')
                    })
            })

            $('.readOnly').attr("readonly", true);
            $('.hideComponent').hide();

            $('#btn-change').on('click', function(){
                if(this.innerText === "Change"){
                    document.getElementById("btn-change").innerText = 'Display';
                    $('.readOnly').attr("readonly", false);
                    $('.hideComponent').show();
                    $('#title').html("Edit Purchase Request <?= $data['prhead']['prnum']; ?>");
                }else{
                    document.getElementById("btn-change").innerText = 'Change';
                    $('.readOnly').attr("readonly", true);
                    $('.hideComponent').hide();
                    $('#title').html("Display Purchase Request <?= $data['prhead']['prnum']; ?>");
                }                
            })

            $('#btn-dlg-add-item').on('click', function(){
                $('#barangModal').modal('show')
            })

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
                                oitem.satuan   = detail_order_beli[i].satuan;
                                // var aharga = detail_order_beli[i].harga.split('.');  
                                // var xharga = '';
                                // for(var x=0; x < aharga.length; x++){
                                //     xharga = xharga+''+aharga[x];
                                // }
                                // oitem.harga    = xharga;
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
                                url: base_url+'/pr/updatepr/'+sel_prnum,
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
                                    showSuccessMessage('PR '+ sel_prnum +' Updated!')
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
							showSuccessMessage('PR '+ sel_prnum +' Updated!')
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
                        object["remark"]   = $('#remark').val();

                        detail_order_beli.push(object);	

                        var count = $('#dg').datagrid('getRows');
                        var pritem = (detail_order_beli.length)*1;

                        $('#dg').datagrid('appendRow',{
                            item        : count.length + 1,
                            kodebrg     : kodebrg,
                            namabrg     : $('#namabrg').val(),
                            quantity	: jmlPesan,
                            unit        : satuan,
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

                        detail_order_beli[rowIndex].kodebrg  = kodebrg;
                        detail_order_beli[rowIndex].namabrg  = $('#namabrg').val();
                        detail_order_beli[rowIndex].jmlPesan = jmlPesan;
                        detail_order_beli[rowIndex].satuan   = satuan;
                        // detail_order_beli[rowIndex].harga    = xharga;
                        // detail_order_beli[rowIndex].total    = xharga * jmlPesan;
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
                        remark    : remark
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