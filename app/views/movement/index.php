    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <form id="form-post-data" method="POST" enctype="multipart/form-data">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    Inventory Movement
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="movement">Inventory Movement</label>
                                                <select class="form-control" name="movement" id="movement">
                                                    <option value="">Select Inventory Movement</option>
                                                    <?php foreach($data['invmov'] as $out) : ?>
                                                        <option value="<?= $out['movement']; ?>"><?= $out['movement']; ?> - <?= $out['description']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-4 hideHeader">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="refnum">Reference Number</label>
                                                <input type="text" class="form-control" name="refnum" id="refnum"/>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-4 hideHeader">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="refnum">-</label>
                                                <button type="button" id="btn-sel-ref" class="btn btn-primary form-control">Reference</button>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-4 hideHeader">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="refnum">Movement Type</label>
                                                <input type="text" class="form-control" name="immvt" id="immvt" required readonly/>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

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
                                                <label for="regdate">Movement Date</label>
                                                <input type="date" name="mvdate" id="mvdate" class="datepicker form-control" required>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-12 txt-message">
                                        <label id="txt-message" style="color:red;"></label>    
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card hideComponent">
                            <div class="header">
                                <h2>
                                    Movement Items
                                </h2>
                                        
                                <ul class="header-dropdown m-r--5">                                
                                    <button type="button" id="btn-dlg-add-item" class="btn bg-blue moveOther">
                                        <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
                                    </button>

                                    <button type="submit" class="btn bg-blue" id="btn-post">
                                        <i class="material-icons">save</i> <span>POST</span>
                                    </button>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered table-striped table-hover" id="tbl-move-item">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Material</th>
                                                    <th>Material Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Warehouse</th>
                                                    <th class="reservasi">Warehouse Dest</th>
                                                    <th id="threfnum">Ref. Num</th>
                                                    <th id="threfitm">Ref. Item</th>
                                                    <th>Remark</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl-item-body" class="mainbodynpo">

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
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModalText">Pilih Material</h4>
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

            <!-- Modal PO Ref -->
            <div class="modal fade" id="referenceGR01Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="referenceGR01ModalText">Pilih PO</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-po-togr" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>PO Number</th>
                                            <th>Vendor</th>
                                            <th>PO Date</th>
                                            <th>Note</th>
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

            <!-- Modal Reservasi Ref -->
            <div class="modal fade" id="referenceTF01Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="referenceTF01ModalText">Pilih Reservasi</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-reservasi-tf" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Reservasi</th>
                                            <th>Note</th>
                                            <th>Created By</th>
                                            <th>Date</th>
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

            <!-- Modal Error Message -->
            <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="errorModalText">Info</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="tbl-err-msg" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-err-body">
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

            var whslist = <?= $data['whslist']; ?>;

            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;
            var eind  = '';
            
            $('.hideComponent, .hideHeader, .reservasi, .moveOther,.txt-message').hide();

            $('#movement').on('change', function(){
                $('.hideHeader').show();
                $('#tbl-item-body').html('');
                    if($('#movement').val() === "GR01"){
                        $('#threfnum').html('PO Number');
                        $('#threfitm').html('PO Item');
                        $('#immvt').val('101');
                        $('.reservasi').hide();
                    }else if($('#movement').val() === "TF01"){
                        $('#threfnum').html('Reservation Number');
                        $('#threfitm').html('Resservation Item');
                        $('#immvt').val('201');
                        $('.reservasi').show();
                    }else if($('#movement').val() === "TF02"){
                        $('#threfnum').html('Refrence Number');
                        $('#threfitm').html('Refrence Item');
                        $('#immvt').val('211');
                        $('.reservasi').show();
                        $('.hideComponent, .moveOther').show();
                    }else if($('#movement').val() === "GI01"){
                        $('#threfnum').html('Refrence Number');
                        $('#threfitm').html('Refrence Item');
                        $('#immvt').val('261');
                        $('.reservasi').hide();
                        $('.hideComponent').show();
                        $('.moveOther').show();
                    }
            })

            $('#refnum').on('keyup', function(e){
                if (e.key === 'Enter' || e.keyCode === 13) {
                    $('.txt-message, .hideComponent').hide();
                    $('#tbl-item-body').html('');
                    if($('#movement').val() === "GR01"){
                        $('#threfnum').html('PO Number');
                        $('#threfitm').html('PO Item');
                        $('#immvt').val('101');
                        $('.reservasi').hide();
                        readpoitem(this.value);
                    }else if($('#movement').val() === "TF01"){
                        $('#threfnum').html('Reservation Number');
                        $('#threfitm').html('Resservation Item');
                        $('#immvt').val('201');
                        $('.reservasi').show();
                        readreservationitem(this.value);
                    }else if($('#movement').val() === "TF02"){
                        $('#threfnum').html('Refrence Number');
                        $('#threfitm').html('Refrence Item');
                        $('#immvt').val('211');
                        $('.reservasi').show();
                        $('.hideComponent, .moveOther').show();
                    }else if($('#movement').val() === "GI01"){
                        $('#threfnum').html('Refrence Number');
                        $('#threfitm').html('Refrence Item');
                        $('#immvt').val('261');
                        $('.reservasi').hide();
                        $('.hideComponent').show();
                        $('.moveOther').show();
                    }
                }
            });

            $('#refnum').on('change', function(e){
                $('.txt-message, .hideComponent').hide();
                if($('#movement').val() === "GR01"){
                    $('#threfnum').html('PO Number');
                    $('#threfitm').html('PO Item');
                    $('#immvt').val('101');
                    $('.reservasi').hide();
                    readpoitem(this.value);
                }else if($('#movement').val() === "TF01"){
                    $('#threfnum').html('Reservation Number');
                    $('#threfitm').html('Resservation Item');
                    $('#immvt').val('201');
                    $('.reservasi').show();
                    readreservationitem(this.value);
                }else if($('#movement').val() === "TF02"){
                    $('#threfnum').html('Refrence Number');
                    $('#threfitm').html('Refrence Item');
                    $('#immvt').val('211');
                    $('.reservasi').show();
                    $('.hideComponent, .moveOther').show();
                }else if($('#movement').val() === "GI01"){
                    $('#threfnum').html('Refrence Number');
                    $('#threfitm').html('Refrence Item');
                    $('#immvt').val('261');
                    $('.reservasi').hide();
                    $('.hideComponent').show();
                    $('.moveOther').show();
                }
            });

            $('#btn-sel-ref').on('click', function(){
                if($('#movement').val() === "GR01"){
                    loaddatapotogr();
                    $('#referenceGR01Modal').modal('show');
                }else if($('#movement').val() === "TF01"){
                    loaddatareservasitotf();
                    $('#referenceTF01Modal').modal('show');
                }
            })

            function readpoitem(ponum){
                $.ajax({
                    url: base_url+'/movement/getopenpoitem/data?ponum='+ponum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        // console.log(result)
                        if(result.length > 0){
                            append_data(result);
                            $('.hideComponent').show();
                        }else{
                            $('#txt-message').html('No PO Items!');
                            $('.txt-message').show();
                        }
                    }
                }); 
                // $.ajax({
                //     url: base_url+'/movement/checkporelstat/data?ponum='+ponum,
                //     type: 'GET',
                //     dataType: 'json',
                //     cache:false,
                //     success: function(result){
                //         console.log(result)
                //         if(result.approvestat == "1" || result.approvestat == "3"){
                //             $('#txt-message').html('PO Not Approved yet or Rejected!');
                //             $('.txt-message').show();
                //         }else if(result.approvestat == "2"){
                //         }
                //     }
                // }); 
                
            }

            function readreservationitem(rsnum){
                $.ajax({
                    url: base_url+'/movement/reservationitem/'+rsnum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        if(result.length > 0){
                            append_data(result);
                            $('.hideComponent').show();
                        }else{
                            $('#txt-message').html('No Reservation Items!');
                            $('.txt-message').show();
                        }
                    }
                }); 
            }

            function append_data(_data){
                $('#tbl-item-body').html('');
                var aMat = [];
                var aWhs = [];
                var aQty = [];
                for(var i=0;i<_data.length;i++){
                    var _refnum  = '';
                    var _refitem = '';

                    var quantity = 0;

                    if($('#movement').val() === "GR01"){
                        quantity = _data[i].quantity - _data[i].grqty;
                    }else{
                        quantity = _data[i].quantity;
                    }

                    selqty     = quantity.toString();
                    selqty     = selqty.replaceAll('.',',');

                    _refnum  = _data[i].refnum;
                    _refitem = _data[i].refitem;
                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ _data[i].material +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ _data[i].matdesc +`" readonly/>
                            </td>
                            
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="inputqty`+count+`"  class="form-control inputNumber inputQty" style="width:100px; text-align:right;" required="true" value="`+ formatRupiah(selqty,'') +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:100px;" required="true" value="`+ _data[i].unit +`" readonly/>
                            </td>
                            <td> 
                                <input type="hidden" id="_itm_whs`+count+`" />
                                <select name="itm_whs[]" counter="`+count+`" id="whs`+count+`" class="form-control whsCode checkWhsAuth" required style="width:200px;">
                                    <option value="">Pilih Warehouse</option>
                                </select>
                            </td>
                            <td class="reservasi"> 
                                
                                <input type="text" name="itm_whs2[]" class="form-control" style="width:200px;" counter="`+count+`" id="whs2`+count+`" required value="`+ _data[i].towhs +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_refnum[]" counter="`+count+`" id="ponum`+count+`" class="form-control" style="width:120px;" required="true" value="`+ _refnum +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_refitem[]" class="form-control" style="width:80px;" counter="`+count+`" id="poitem`+count+`" required value="`+ _refitem +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_remark[]" class="form-control" style="width:200px;" counter="`+count+`" id="remark`+count+`"/>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-item-body').append(html);
                    renumberRows();

                    if($('#movement').val() === "GR01"){                        
                        console.log(whslist)
                        $("#whs"+count).html('');
                        var listItems = '';
                        for (var x = 0; x < whslist.length; x++) {
                            listItems += "<option class='form-control' value='"+ whslist[x].gudang +"'>"+ whslist[x].gudang +" - "+ whslist[x].deskripsi +"</option>";
                        };
                        $("#whs"+count).html(listItems);
                        $('#_itm_whs'+count).val($('#whs'+count).val())
                        
                        
                    }else if($('#movement').val() === "TF01"){
                        var listItems;
                        listItems += "<option class='form-control' value='"+ _data[i].fromwhs +"'>"+ _data[i].fromwhs +" - "+ _data[i].whsname1 +"</option>";
                        $("#whs"+count).html(listItems);

                        $("#whs"+count).attr("readonly", true);
                        $("#whs2"+count).attr("readonly", true);
                    }

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
                    })


                    if($('#movement').val() === "GR01" || $('#movement').val() === "GI01"){
                        $('.reservasi').hide();
                        $('#whs2'+count).val('null')
                    }else if($('#movement').val() === "TF01"){
                        $('.reservasi').show();
                    }

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

                    $('#inputqty'+count).on('change', function(){
                        var inputqty = this.value;
                        var currentcounter = $(this).attr('counter');
                        // console.log('change qty')
                        
                        if($('#movement').val() === "GR01"){
                            if(inputqty > quantity){
                                showErrorMessage('Input Quantity Lebih Besar Dari Quantity PO');
                                this.value = quantity;
                            }
                        }
                    });

                    $('.checkWhsAuth').on('change', function(){
                        var _whsauth = '';
                        var inputWhs = this.value;
                        var selectedid = this.id;

                        checkauthwhs(this.value, function(_whsauth){
                            if(_whsauth === 0){
                                showErrorMessage('Tidak punya otorisasi di gudang ' + inputWhs);
                                $('#'+selectedid).val('')
                            }
                        });
                    })
                    
                }
            }

            function checkauthwhs(_whscode, callback){
                $.ajax({
                    url: base_url+'/movement/checkauthwhs/'+_whscode,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        callback(result);
                    }
                });                
            }

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
                    $('#satuan').val(selected_data.matunit);
                    // $('#barangModal').modal('hide');

                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="matnrCode" style="display:none;">
                                `+ selected_data.material +`
                            </td>
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ selected_data.material +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ selected_data.matdesc +`" readonly/>
                            </td>
                            
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="inputqty`+count+`"  class="form-control inputNumber" style="width:100px; text-align:right;" required="true" />
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ selected_data.matunit +`"/>
                            </td>
                            <td> 
                                <input type="hidden" id="_itm_whs`+count+`" />
                                <select name="itm_whs[]" counter="`+count+`" id="whs`+count+`" class="form-control whsCode" required style="width:150px;">
                                    
                                </select>
                            </td>
                            <td class="reservasi"> 
                                <select name="itm_whs2[]" counter="`+count+`" id="whs2`+count+`" class="form-control" required style="width:150px;">
                                </select>
                            </td>
                            <td> 
                                <input type="text" name="itm_refnum[]" counter="`+count+`" id="ponum`+count+`" class="form-control" style="width:120px;" />
                            </td>
                            <td> 
                                <input type="text" name="itm_refitem[]" class="form-control" style="width:80px;" counter="`+count+`" id="poitem`+count+`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_remark[]" class="form-control" style="width:200px;" counter="`+count+`" id="remark`+count+`"/>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-item-body').append(html);
                    renumberRows();

                    // warehouse/listwarehouse
                    
                    $.ajax({
                        url: base_url+'/warehouse/listwarehouse',
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){
                            console.log(result)
                            var listItems;
                            for (var i = 0; i < result.length; i++) {
                                listItems += "<option class='form-control' value='"+ result[i].gudang +"'>"+ result[i].gudang +" - "+ result[i].deskripsi +"</option>";
                            };
                            $("#whs"+count).html(listItems);
                            $("#whs2"+count).html(listItems);
                        }
                    }).done(function(){
                        $('#_itm_whs'+count).val($('#whs'+count).val())
                    });

                    $('#whs'+count).on('change', function(){
                        var xcounter = $(this).attr('counter');
                        $('#_itm_whs'+xcounter).val(this.value)
                    })

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
                    })

                    if($('#movement').val() === "GI01"){
                        $('.reservasi').hide();
                        $('#whs2'+count).val('null')
                    }

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

                    $('.checkWhsAuth').on('change', function(){
                        var _whsauth = '';
                        var inputWhs = this.value;
                        var selectedid = this.id;

                        checkauthwhs(this.value, function(_whsauth){
                            if(_whsauth === 0){
                                showErrorMessage('Tidak punya otorisasi di gudang ' + inputWhs);
                                $('#'+selectedid).val('')
                            }
                        });
                    });

                    $('#inputqty'+count).on('change', function(){
                        var inputqty = this.value;
                        var currentcounter = $(this).attr('counter');                        
                        
                        if($('#movement').val() === "TF02" || $('#movement').val() === "GI01"){
                            var stockResult = '';
                            $('#tbl-err-body').html('');
                            checkstock($('#material'+currentcounter).val(),$('#whs'+currentcounter).val(),inputqty,function(stockResult){
                                console.log(stockResult);
                                var irows = 0;
                                for(var x = 0; x < stockResult.length; x ++){
                                    if(stockResult[x].quantity < stockResult[x].inputqty){
                                        eind ='X';
                                        irows = irows + 1;
                                        html = '';
                                        html = `
                                            <tr counter="`+ irows +`">
                                                <td style="text-align:center"> 
                                                    `+ irows +`
                                                </td>
                                                <td style="color:red;">
                                                    Stock Material <b>`+ stockResult[x].material +`</b> di Warehouse <b>`+ stockResult[x].warehouse +`</b> Tidak mencukupi. <p>Stock saat ini <b>( `+ stockResult[x].quantity.replaceAll('.00','') +` )</b>
                                                </td>
                                            </tr>
                                            `;
                                        $('#tbl-err-body').append(html);
                                    }
                                }
                                if(eind === "X"){
                                    // $('#errorModal').modal('show')
                                } 
                            })
                        }
                    });
                } );
            }

            // listreservasitotf
            // loaddatapotogr();
            function loaddatapotogr(){
                $('#list-po-togr').dataTable({
                    "ajax": base_url+'/movement/listpotogr',
                    "columns": [
                        { "data": "ponum" },
                        { "data": "namavendor" },
                        { "data": "podat" },
                        { "data": "note" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-po-togr tbody').on( 'click', 'button', function () {
                    var table = $('#list-po-togr').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    $('#refnum').val(selected_data.ponum);   
                    $('#referenceGR01Modal').modal('hide');
                    readpoitem(selected_data.ponum);      
                });
            }

            // loaddatareservasitotf();
            function loaddatareservasitotf(){
                $('#list-reservasi-tf').dataTable({
                    "ajax": base_url+'/movement/listreservasitotf',
                    "columns": [
                        { "data": "resnum" },
                        { "data": "requestor" },
                        { "data": "resdate" },
                        { "data": "note" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-reservasi-tf tbody').on( 'click', 'button', function () {
                    var table = $('#list-reservasi-tf').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    $('#refnum').val(selected_data.resnum);
                    $('#referenceTF01Modal').modal('hide'); 
                    readreservationitem(selected_data.resnum);  
                });
            }

            function checkstock(_material, _whscode, _inpqty, callback){
                $.ajax({
                    url: base_url+'/movement/checkstock/'+_material+'/'+_whscode+'/'+_inpqty,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        // console.log(result)
                        callback(result);
                    }
                });                
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

            $('#form-post-data').on('submit', async function(event){
                event.preventDefault();
                $("#btn-post").attr("disabled", true);
                    var formData = new FormData(this);
                    $.ajax({
                        url:base_url+'/movement/post',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $("#btn-post").attr("disabled", true);
                        },
                        success:function(data)
                        {
                        	// console.log(data);
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                            console.log(err.responseText)     
                        }
                    }).done(function(result){
                        console.log(result)

                        if(result.msgtype === "1"){
                            showSuccessMessage('Inventory Movement Success '+ result.docnum);
                            $("#btn-post").attr("disabled", false);
                        }else if(result.msgtype === "2"){
                            // showSuccessMessage('Inventory Movement Success '+ data.docnum)
                            var irows = 0;
                            $('#tbl-err-body').html('');
                            for(var y = 0; y < result.data.length; y++){
                                irows=irows+1;
                                html = '';
                                html = `
                                    <tr counter="`+ irows +`">
                                        <td style="text-align:center"> 
                                            `+ irows +`
                                        </td>
                                        <td style="color:red;">
                                            `+ result.data[y].message +`
                                        </td>
                                    </tr>`;
                                $('#tbl-err-body').append(html);
                                $("#btn-post").attr("disabled", false);
                            }
                            $('#errorModal').modal('show');
                        }else{
                            showErrorMessage(JSON.stringify(result))   
                            console.log(result)                      
                            $("#btn-post").attr("disabled", false);   
                        }
                    })
            })

            // async function formvalidation(){
            //     var array = [];

            //     $('#tbl-move-item tr').each(function() {
            //         var values = [];
            //         $(this).find("input").each(function(){
            //             values.push(this.value);
            //         });
            //         array.push(values);
            //     });
            //     console.log(array)
            //     var irows = 0;
            //     var totaldata = array.length-1;
            //     console.log(totaldata);

            //     for(var i = 1; i < array.length; i++){
            //         var ck_material  = array[i][0];
            //         var ck_warehouse = array[i][4];
            //         var ck_quantity  = array[i][2].replaceAll(".","");
            //             if($('#movement').val() === "TF01" || $('#movement').val() === "TF02" || $('#movement').val() === "GI01"){
            //                 var stockResult = '';
            //                 $('#tbl-err-body').html('');
            //                 await checkstock(ck_material,ck_warehouse,ck_quantity,function(stockResult){
            //                     console.log(stockResult);
                                
            //                     for(var x = 0; x < stockResult.length; x ++){
            //                         if(stockResult[x].quantity < stockResult[x].inputqty){
            //                             eind ='X';
            //                             irows = irows + 1;
            //                             html = '';
            //                             html = `
            //                                 <tr counter="`+ irows +`">
            //                                     <td style="text-align:center"> 
            //                                         `+ irows +`
            //                                     </td>
            //                                     <td style="color:red;">
            //                                         Stock Material <b>`+ stockResult[x].material +`</b> di Warehouse <b>`+ stockResult[x].warehouse +`</b> Tidak mencukupi. <p>Stock saat ini (`+ stockResult[x].quantity.replaceAll('.00','') +`)
            //                                     </td>
            //                                 </tr>
            //                                 `;
            //                             $('#tbl-err-body').append(html);
            //                         }

            //                         if(i == totaldata ){
            //                             console.log('finish')
            //                             // $('#errorModal').modal('show');
            //                             postdata();
            //                         }else{
            //                             console.log('continue')
            //                         }
            //                         console.log(i);
            //                     }
                                
            //                 })
            //             }
                    
            //     }
            // }

            // async function postdata(){
            //     alert(eind)
            // }

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
                        window.location.href = base_url+'/movement';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "error");
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