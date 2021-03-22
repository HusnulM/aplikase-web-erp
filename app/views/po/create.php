    <section class="content">
        <div class="container-fluid">
        <!-- action="<?= BASEURL; ?>/po/savepo" method="POST"  -->
            <form id="form-po-data" enctype="multipart/form-data">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    
                                </ul>
                            </div>
                            <div class="body">
                                
                                <div class="row clearfix">
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="vendor">Vendor</label>
                                                <input type="text" name="namavendor" id="namavendor" class="form-control"  readonly="true" required>
                                                <input type="hidden" name="vendor" id="vendor">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <br>
                                                <button class="btn bg-blue form-control" type="button" id="btn-search-vendor">
                                                <i class="material-icons">format_list_bulleted</i> <span>Choose Vendor</span>
                                                </button>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="potype">Type PO</label>
                                                <select class="form-control show-tick" name="potype" id="potype">
                                                    <option value="PO01">PO Stock</option>
                                                    <option value="PO02">PO Lokal</option>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick" name="warehouse" id="warehouse">
                                                    <?php foreach($data['whs'] as $whs): ?>
                                                    <option value="<?= $whs['gudang']; ?>"><?= $whs['deskripsi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>   
                                    
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="podate">PO Date</label>
                                                <input type="date" name="podate" id="podate" class="datepicker form-control" placeholder="" required value="<?= date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>                                    

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control" placeholder="Note" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>

                        <div class="card" id="div-po-item">
                            <div class="header">
                                <h2>
                                    Purchase Order Item
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row">
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
                                                        <th>Price Unit</th>
                                                        <th>Tax</th>
                                                        <th>Discount</th>
                                                        <th>PR Number</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-po-body" class="mainbodynpo">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ul class="pull-right">          
                                            <button type="button" id="btn-add-poitem-from-pr" class="btn bg-blue">
                                                <i class="material-icons">playlist_add</i> <span>ADD ITEM FROM PR</span>
                                            </button>

                                            <button type="button" id="btn-add-poitem" class="btn bg-blue">
                                                <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
                                            </button>

                                            <a href="<?= BASEURL ?>/po" type="button" id="btn-cancel" class="btn bg-red">
                                                <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                            </a>
                                            <button type="submit" id="btn-save" class="btn bg-green waves-effect">
                                                <i class="material-icons">save</i> <span>SAVE</span>
                                            </button>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        

            

            <div class="modal fade" id="prListModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Pilih PR</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-pr" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No PR</th>
                                            <th>PR Item</th>
                                            <th>Warehouse</th>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Open Quantity</th>
                                            <th>Unit</th>
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

            <div class="modal fade" id="vendorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="vendorModalLabel">Select Vendor</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-vendor" style="width:100%;">
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
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
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
                                            <!-- <th>Order Unit</th> -->
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
                                            <!-- <td></td> -->
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
        var vendor            = '';
        var namavendor        = '';
        let detail_order_beli = [];
        var _ppnchecked = '';

        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });

        $(document).ready(function(){
            var count = 0;
            $('#btn-search-vendor').on('click', function(){
                $('#vendorModal').modal('show');
                loadvendor();
            });            

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
                        // { "data": "orderunit" },
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
                    
                    if(materialExists(selected_data.material)){

                    }else{
                        detail_order_beli.push(selected_data);
                        kodebrg = selected_data.material;
                        count = count+1;
                        html = '';
                        html = `
                            <tr counter="`+ count +`" id="tr`+ count +`">
                                <td class="nurut"> 
                                    `+ count +`
                                    <input type="hidden" name="no[]" value="`+ count +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ selected_data.material +`" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:250px;" value="`+ selected_data.matdesc +`" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px; text-align:right;" required="true" autocomplete="off"/>
                                </td>
                                <td> 
                                    <select name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control whsCode" required style="width:100px;"></select>
                                </td>
                                <td> 
                                    <input type="text" name="itm_price[]" class="form-control disableInput inputNumber" style="width:100px;text-align: right;" counter="`+count+`" id="poprice`+count+`" required="true" autocomplete="off"/>
                                </td>
                                <td> 
                                    <select name="itm_ppn[]" counter="`+count+`" id="ppn`+count+`" class="form-control" required style="width:120px;">
                                        <option value="0"> </option>
                                        <option value="10"> PPN 10% </option>
                                    </select>
                                </td>
                                <td> 
                                    <input type="text" name="itm_discount[]" class="form-control disableInput inputNumber" style="width:100px;text-align: right;" counter="`+count+`" id="discount`+count+`" autocomplete="off"/>
                                </td>
                                <td> 
                                    <input type="text" name="prnum[]" counter="`+count+`" id="prnum`+count+`" class="form-control" style="width:130px;" readonly/>

                                    <input type="hidden" name="itm_prnum[]" value="NULL" />
                                    <input type="hidden" name="itm_pritem[]" value="NULL" />
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`" id="btnRemove`+count+`">Remove</button>
                                </td>
                            </tr>
                        `;
                        $('#tbl-po-body').append(html);
                        renumberRows();
                        var listItems;
                                listItems += "<option class='form-control' value='"+ selected_data.matunit +"'>"+ selected_data.matunit +"</option>";
                        $.ajax({
                            url: base_url+'/barang/getmaterialunit/data?material='+selected_data.material+'&&unit='+selected_data.matunit,
                            type: 'GET',
                            dataType: 'json',
                            cache:false,
                            success: function(result){
                                console.log(result)
                                for (var i = 0; i < result.length; i++) {
                                    listItems += "<option class='form-control' value='"+ result[i].altuom +"'>"+ result[i].altuom +"</option>";
                                };
                                $("#unit"+count).html(listItems);
                            }
                        });

                        $('#btnRemove'+count).on('click', function(e){
                            e.preventDefault();
                            var row_index = $(this).closest("tr").index();
                            removeitem(row_index);                        
                            $(this).closest("tr").remove();
                            renumberRows();
                            console.log(detail_order_beli)
                        });

                        // $('.removePO').on('click', function(e){
                        //     e.preventDefault();
                        //     $(this).closest("tr").remove();
                        //     renumberRows();
                        // });

                        $('.materialCode').on('change', function(){
                            var xcounter = $(this).attr('counter');
                            var kodebrg  = $('#material'+xcounter).val();

                            getMaterialbyKode(kodebrg, function(d){
                                console.log(d)
                                $('#matdesc'+xcounter).val(d.matdesc);
                                $('#unit'+xcounter).val(d.matunit);
                            });
                        });

                        $('.inputNumber').on('change', function(){
                            this.value = formatRupiah(this.value, '');
                        });
                    }
                } );
            }

            
            $('#btn-add-poitem-from-pr').on('click', function(){
                $('#prListModal').modal('show');
                var selectedwhs = $('#warehouse').val();
                loadopenpr(selectedwhs);
            });

            $('#btn-add-poitem').on('click', function(){
                if(vendor === ""){
                    showErrorMessage('Input Vendor');
                }else{
                    $('#barangModal').modal('show')
                }
            });

            function materialExists(material) {
                return detail_order_beli.some(function(el) {
                    return el.material === material;
                }); 
            }

            function pritemExists(prnum, pritem) {
                return detail_order_beli.some(function(el) {
                    console.log(el)
                    if(el.prnum === prnum && el.pritem === pritem){
                        return true;
                    }else{
                        return false;
                    }
                }); 
            }

            function removeitem(index){
                detail_order_beli.splice(index, 1);
            }

            $('#form-po-data').on('submit', function(event){
                event.preventDefault();
                if(detail_order_beli.length > 0){
                    var formData = new FormData(this);
                    console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/po/savepo',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('#btn-save').attr('disabled','disabled');
                        },
                        success:function(data)
                        {

                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err));
                            console.log(err);
                        }
                    }).done(function(result){
                        if(result.msgtype === "1"){
                            showSuccessMessage("PO "+ result.docnum + " Created");
                        }else{
                            showErrorMessage(result.docnum);
                        }
                    }) ;
                }else{
                    showErrorMessage("No Purchase Order Item");
                }
            })

            loadvendor();
            function loadvendor(){
                $('#list-vendor').dataTable({
                    "ajax": base_url+'/vendor/vendorlist',
                    "columns": [
                        { "data": "vendor" },
                        { "data": "namavendor" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Select</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-vendor tbody').on( 'click', 'button', function () {
                    var table = $('#list-vendor').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    vendor     = selected_data.vendor;
                    namavendor = selected_data.namavendor;
                    $('#vendor').val(selected_data.vendor);
                    $('#namavendor').val(selected_data.namavendor);
                    $('#vendorModal').modal('hide');
                } );                
            }

            
            function loadopenpr(_warehouse){
                $('#list-pr').dataTable({
                    "ajax": base_url+'/po/getapprovedpr/'+_warehouse,
                    "columns": [
                        { "data": "prnum" },
                        { "data": "pritem" },
                        { "data": "whsname" },
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "quantity" },
                        { "data": "openqty" },
                        { "data": "unit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Select</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-pr tbody').on( 'click', 'button', function () {
                    var table = $('#list-pr').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    if(pritemExists(selected_data.prnum, selected_data.pritem)){
                    }else{
                        detail_order_beli.push(selected_data);
                        // console.log(detail_order_beli)
                        var selqty  = '0';
                        var prpoqty = 0;
                        var prqty   = 0;
                        prpoqty     = selected_data.quantity-selected_data.openqty;
                        prqty       = selected_data.quantity;
                        selqty      = selected_data.openqty.replace('.00','');
                        selqty      = selqty.replace('.',',');
                        selqty      = selqty.replace('.',',');
                        selqty      = selqty.replace('.',',');
                        count = count+1;
                        html = '';
                        html = `
                            <tr counter="`+ count +`" id="tr`+ count +`">
                                <td class="nurut"> 
                                    `+ count +`
                                    <input type="hidden" name="no[]" value="`+ count +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control" style="width:150px;" value="`+ selected_data.material +`" required="true" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:250px;" value="`+ selected_data.matdesc +`" required="true" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px;text-align:right;" value="`+ formatRupiah(selqty,'') +`" required="true" autocomplete="off"/>

                                    <input type="hidden" name="itm_prpoqty[]" id="prpoqty`+count+`"  value="`+ prpoqty +`" />
                                    <input type="hidden" name="itm_prqty[]" id="prqty`+count+`"  value="`+ prqty +`" />
                                </td>
                                <td> 
                                    <select name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control whsCode" required style="width:100px;"></select>                                
                                </td>
                                <td> 
                                    <input type="text" name="itm_price[]" class="form-control disableInput inputNumber" style="width:100px;text-align: right;" counter="`+count+`" id="poprice`+count+`" required="true" autocomplete="off"/>
                                </td>
                                <td> 
                                    <select name="itm_ppn[]" counter="`+count+`" id="ppn`+count+`" class="form-control" required style="width:120px;">
                                        <option value="0"> </option>
                                        <option value="10"> PPN 10% </option>
                                    </select>
                                </td>
                                <td> 
                                    <input type="text" name="itm_discount[]" class="form-control disableInput inputNumber" style="width:100px;text-align: right;" counter="`+count+`" id="discount`+count+`" autocomplete="off"/>
                                </td>
                                <td> 
                                    <input type="text" name="prnum[]" counter="`+count+`" id="prnum`+count+`" class="form-control" style="width:130px;" value="`+ selected_data.prnum +` | `+ selected_data.pritem +`" readonly/>

                                    <input type="hidden" name="itm_prnum[]" id="selprnum`+count+`"  value="`+ selected_data.prnum +`" />
                                    <input type="hidden" name="itm_pritem[]" id="selpritem`+count+`"  value="`+ selected_data.pritem +`" />
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`" id="btnRemove`+count+`">Remove</button>
                                </td>
                            </tr>
                        `;
                        $('#tbl-po-body').append(html);
                        renumberRows();

                        var listItems;
                                listItems += "<option class='form-control' value='"+ selected_data.unit +"'>"+ selected_data.unit +"</option>";
                                
                        $.ajax({
                            url: base_url+'/barang/getmaterialunit/data?material='+selected_data.material+'&&unit='+selected_data.orderunit,
                            type: 'GET',
                            dataType: 'json',
                            cache:false,
                            success: function(result){
                                // console.log(result)
                                
                                for (var i = 0; i < result.length; i++) {
                                    listItems += "<option class='form-control' value='"+ result[i].altuom +"'>"+ result[i].altuom +"</option>";
                                };
                                $("#unit"+count).html(listItems);
                            }
                        });

                        $('#poqty'+count).on('change', function(e){
                            e.preventDefault();
                            var _prnum    = $('#selprnum'+count).val();
                            var _pritem   = $('#selpritem'+count).val();
                            var _prpoqty  = $('#prpoqty'+count).val();
                            var _prqty    = $('#prqty'+count).val();
                            var _totalqty = 0;
                            var _inputval = this.value;
                            _inputval = _inputval.replace('.','');
                            _inputval = _inputval.replace('.','');
                            _inputval = _inputval.replace('.','');
                            _inputval = _inputval.replace('.','');

                            _totalqty = _inputval*1+_prpoqty*1;
                            
                            if(_totalqty*1 > _prqty*1){
                                alert('Quantity PO Lebih Besar Dari Open Quantity PR');
                                this.value = (_prqty*1)-(_prpoqty*1);
                            }

                            // var res = _prnum.split("|");
                        });

                        $('#btnRemove'+count).on('click', function(e){
                            e.preventDefault();
                            var row_index = $(this).closest("tr").index();
                            removeitem(row_index);                        
                            $(this).closest("tr").remove();
                            renumberRows();
                            console.log(detail_order_beli)
                        });

                        // $('.removePO').on('click', function(e){
                        //     e.preventDefault();
                        //     $(this).closest("tr").remove();
                        //     renumberRows();
                        // });   
                        
                        $('.inputNumber').on('change', function(){
                            this.value = formatRupiah(this.value, '');
                        });
                    }


                    // console.log(selected_data)
                    // $('#prListModal').modal('hide');

                } );                
            }

            function getMaterialbyKode(materialcode, callback){
                $.ajax({
                    url: base_url+'/barang/caribarangbykode/'+materialcode,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        callback(result);
                    }
                });  
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/po';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
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
        })
    </script>