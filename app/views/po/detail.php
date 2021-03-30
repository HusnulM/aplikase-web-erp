    <section class="content">
        <div class="container-fluid">
            <form id="form-po-data" enctype="multipart/form-data">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2 id="title">
                                    <?= $data['menu']; ?> <?= $data['pohead']['ponum']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">   
                                     
                                    <a href="<?= BASEURL ?>/po" type="button" id="btn-cancel" class="btn btn-sm bg-red hideComponent">
                                        <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                    </a>
                                    <button type="submit" id="btn-save" class="btn btn-sm bg-green hideComponent">
                                        <i class="material-icons">save</i> 
                                        <span>SAVE</span>
                                    </button>

                                    <button type="button" id="btn-change" class="btn bg-blue ">
                                        <i class="material-icons" id="_icon">edit</i> 
                                        <span id="act-txt">CHANGE</span>
                                    </button>    
                                </ul>
                            </div>
                            <div class="body">
                            <b>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#basic_data_view" data-toggle="tab">
                                            <i class="material-icons">description</i> Header Data
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#alt_uom_view" data-toggle="tab">
                                            <i class="material-icons">line_weight</i> Additional Data
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="basic_data_view">
                                        <div class="row clearfix">
                                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="vendor">Vendor</label>
                                                        <input type="text" name="namavendor" id="namavendor" class="form-control readOnly" value="<?= $data['vendor']['namavendor']; ?>" required>
                                                        <input type="hidden" name="vendor" id="vendor" value="<?= $data['pohead']['vendor']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 hideComponent">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <br>
                                                        <button class="btn bg-blue form-control hideComponent" type="button" id="btn-search-vendor">
                                                        <i class="material-icons">format_list_bulleted</i> <span>Choose Vendor</span>
                                                        </button>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="note">Note</label>
                                                        <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['pohead']['note']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="podate">PO Date</label>
                                                        <input type="date" name="podate" id="podate" class="datepicker form-control readOnly" placeholder="" required value="<?= $data['pohead']['podat']; ?>">
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <?php if($data['pohead']['ppn'] > 0): ?>
                                                        <input type="checkbox" id="basic_checkbox_2" class="filled-in form-control readOnly" checked/>
                                                    <?php else: ?>
                                                        <input type="checkbox" id="basic_checkbox_2" class="filled-in form-control readOnly"/>
                                                    <?php endif; ?>
                                                    <label for="basic_checkbox_2">PPN (10%)</label>
                                                    <input type="hidden" name="ppnval" id="ppnval" value="<?= $data['pohead']['ppn']; ?>">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="alt_uom_view">
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="price">PRICE</label>
                                                        <input type="text" class="form-control readOnly" name="tf_price" value="<?= $data['pohead']['tf_price']; ?>">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="dest">DESTINATION</label>
                                                        <input type="text" class="form-control readOnly" name="tf_dest" value="<?= $data['pohead']['tf_dest']; ?>">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="dest">SHIPMENT</label>
                                                        <input type="text" class="form-control readOnly" name="tf_shipment" value="<?= $data['pohead']['tf_shipment']; ?>">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="shipdate">Shipment Date</label>
                                                        <input type="date" name="tf_shipdate" id="tf_shipdate" class="datepicker form-control readOnly" value="<?= $data['pohead']['tf_shipdate']; ?>" >
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="dest">PAYMENT TERM</label>
                                                        <input type="text" class="form-control readOnly" name="tf_top" value="<?= $data['pohead']['tf_top']; ?>">
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-sm-3 col-xs-3">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <label for="dest">PACKING</label>
                                                        <input type="text" class="form-control readOnly" name="tf_packing" value="<?= $data['pohead']['tf_packing']; ?>">
                                                    </div>
                                                </div> 
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
                                        
                                <ul class="header-dropdown m-r--5">          
                                    <button type="button" id="btn-add-poitem-from-pr" class="btn bg-blue hideComponent">
                                        <i class="material-icons">playlist_add</i> <span>ADD ITEM FROM PR</span>
                                    </button>

                                    <button type="button" id="btn-add-poitem" class="btn bg-blue hideComponent">
                                        <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
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
                                                        <th>Price Unit</th>
                                                        <th>PR Number</th>
                                                        <th class="hideComponent">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-po-body" class="mainbodynpo">

                                                </tbody>
                                            </table>
                                        </div>
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
                            <h4 class="modal-title" id="largeModalLabel">Pilih Purchase Request</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-pr">
                                    <thead>
                                        <tr>
                                            <th>No PR</th>
                                            <th>PR Item</th>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Warehouse</th>
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
        var vendor            = "<?= $data['pohead']['vendor']; ?>";
        var namavendor        = '';
        var _ppnchecked       = '';

        var sel_ponum = "<?= $data['pohead']['ponum']; ?>";

        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });

        $(document).ready(function(){

            var ppn = $('#ppnval').val().replaceAll('.00','');
            if(ppn > 0){
                _ppnchecked = 'X';
            }
            $('#basic_checkbox_2').on('change', function(){
                if(_ppnchecked === ''){
                    _ppnchecked = 'X'
                    $('#ppnval').val('10');
                }else{
                    _ppnchecked = ''
                    $('#ppnval').val('0');
                }
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

                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:120px;" required="true" value="`+ selected_data.material +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:250px;" value="`+ selected_data.matdesc +`"/>
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
                                <input type="text" name="prnum[]" counter="`+count+`" id="prnum`+count+`" class="form-control" style="width:130px;" readonly/>

                                <input type="hidden" name="itm_prnum[]" value="NULL" />
                                <input type="hidden" name="itm_pritem[]" value="NULL" />
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-po-body').append(html);
                    renumberRows();
                    var listItems;
                            listItems += "<option class='form-control' value='"+ selected_data.orderunit +"'>"+ selected_data.orderunit +"</option>";
                    $.ajax({
                        url: base_url+'/barang/getmaterialunit/data?material='+selected_data.material+'&&unit='+selected_data.orderunit,
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

            $('.hideComponent').hide();

            $('#btn-change').on('click', function(){
                if(this.innerText === "edit CHANGE"){
                    $('#act-txt').html('DISPLAY')
                    $('#_icon').html('pageview');
                    $('.readOnly').attr("readonly", false);
                    $('.hideComponent').show();
                    $('#title').html("Edit Purchase Order <?= $data['pohead']['ponum']; ?>");
                    $('.readOnly').attr('readonly', false);
                }else{
                    $('#act-txt').html('CHANGE')
                    $('#_icon').html('edit');
                    $('.readOnly').attr("readonly", true);
                    $('.hideComponent').hide();
                    $('#title').html("Detail Purchase Order <?= $data['pohead']['ponum']; ?>");
                }                
            })

            var count = 0;
            $('#btn-search-vendor').on('click', function(){
                $('#vendorModal').modal('show');
                loadvendor();
            });

            
            $('#btn-add-poitem-from-pr').on('click', function(){
                $('#prListModal').modal('show');
            });

            $('#btn-add-poitem').on('click', function(){
                if(vendor === ""){
                    showErrorMessage('Input Vendor');
                }else{
                    $('#barangModal').modal('show')
                }
            });

            $('#form-po-data').on('submit', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/po/updatepo/data?ponum='+sel_ponum,
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
                        	console.log(data);
                        },
                        error:function(err){
                            console.log(err)
                        }
                    }).done(function(data){
                        showSuccessMessage('PO '+ sel_ponum + ' Updated!');
                    })
            })

            loadpoitem();
            function loadpoitem(){
                
                $.ajax({
                    url: base_url+'/po/getpoitem/data?ponum='+sel_ponum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        // console.log(result)
                        for(var i=0; i<result.length; i++){
                            var stringprnum = '';
                            if(result[i].prnum == null){
                                
                            }else{
                                stringprnum = result[i].prnum + ' | ' + result[i].pritem;
                            }
                            count = count+1;
                            html = '';
                            html = `
                                <tr counter="`+ count +`" id="tr`+ count +`">
                                    <td class="nurut"> 
                                        `+ count +`
                                        <input type="hidden" name="no[]" value="`+ count +`" />
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:120px;" required="true" value="`+ result[i].material +`" readonly />
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:250px;" value="`+ result[i].matdesc +`" readonly/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber readOnly" style="width:100px; text-align:right;" required="true" value="`+ result[i].quantity.replaceAll('.00','') +`"/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ result[i].unit +`" readonly/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_price[]" class="form-control disableInput inputNumber readOnly" style="width:100px;text-align: right;" counter="`+count+`" id="poprice`+count+`" required="true" value="`+ formatRupiah(result[i].price.replaceAll('.00',''),'') +`"/>
                                    </td>
                                    <td> 

                                        <input type="text" name="prnum[]" counter="`+count+`" id="prnum`+count+`" class="form-control" style="width:130px;" readonly value="`+ stringprnum +`"/>

                                        <input type="hidden" name="itm_prnum[]" value="`+ result[i].prnum +`" />
                                        <input type="hidden" name="itm_pritem[]" value="`+ result[i].pritem +`" />
                                    </td>
                                    <td class="hideComponent">
                                        <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                                    </td>
                                </tr>
                            `;
                            $('#tbl-po-body').append(html);
                            renumberRows();

                            $('.removePO').on('click', function(e){
                                e.preventDefault();
                                $(this).closest("tr").remove();
                                renumberRows();
                            });

                            $('.readOnly').attr('readonly', true);

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
                            
                            $('.hideComponent').hide();
                        }
                    }
                });
            }

            $('.readOnly').attr('readonly', true);

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

            loadopenpr();
            function loadopenpr(){
                $('#list-pr').dataTable({
                    "ajax": base_url+'/pr/getapprovedpr',
                    "columns": [
                        { "data": "prnum" },
                        { "data": "pritem" },
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "quantity" },
                        { "data": "unit" },
                        { "data": "whsname" },
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
                    
                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control" style="width:120px;" value="`+ selected_data.material +`" required="true" />
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:250px;" value="`+ selected_data.matdesc +`" required="true"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px;text-align:right;" value="`+ formatRupiah(selected_data.quantity.replaceAll('.00',''),'') +`" required="true" />
                            </td>
                            <td> 
                                <select name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control whsCode" required style="width:100px;"></select>
                            </td>
                            <td> 
                                <input type="text" name="itm_price[]" class="form-control disableInput inputNumber" style="width:100px;text-align: right;" counter="`+count+`" id="poprice`+count+`" required="true" />
                            </td>
                            <td> 
                                <input type="text" name="prnum[]" counter="`+count+`" id="prnum`+count+`" class="form-control" style="width:130px;" value="`+ selected_data.prnum +` | `+ selected_data.pritem +`" readonly/>

                                <input type="hidden" name="itm_prnum[]" value="`+ selected_data.prnum +`" />
                                <input type="hidden" name="itm_pritem[]" value="`+ selected_data.pritem +`" />
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
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
                            console.log(result)
                            
                            for (var i = 0; i < result.length; i++) {
                                listItems += "<option class='form-control' value='"+ result[i].altuom +"'>"+ result[i].altuom +"</option>";
                            };
                            $("#unit"+count).html(listItems);
                        }
                    });

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
                    });   
                    
                    $('.inputNumber').on('change', function(){
                        this.value = formatRupiah(this.value, '');
                    })

                    console.log(selected_data)
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