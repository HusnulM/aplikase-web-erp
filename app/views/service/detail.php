    <section class="content">
        <div class="container-fluid">
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <div class="row clearfix">
            <form action="<?= BASEURL; ?>/service/update" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">  

                                <a href="<?= BASEURL; ?>/service" class="btn bg-teal waves-effect">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                     
                            <div class="row" style="margin-bottom:0px;">
                                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" class="form-control" placeholder="Note" value="<?= $data['srvheader']['note']; ?>">
                                            <input type="hidden" name="servicenum" value="<?= $data['srvheader']['servicenum']; ?>">
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="servicedate">Service Date</label>
                                            <input type="date" name="servicedate" id="servicedate" class="datepicker form-control" value="<?= $data['srvheader']['servicedate']; ?>">
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="mekanik">Nama Mekanik</label>
                                            <input type="text" class="form-control" name="mekanik" id="mekanik" required value="<?= $data['srvheader']['mekanik']; ?>">
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="warehouse">Warehouse</label>
                                            <select class="form-control show-tick" name="warehouse" id="warehouse">
                                                <option value="<?= $data['srvheader']['warehouse']; ?>"><?= $data['srvheader']['whsname']; ?></option>
                                                <?php foreach($data['whs'] as $whs): ?>
                                                    <option value="<?= $whs['gudang']; ?>"><?= $whs['deskripsi']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>    
                                </div>   

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="nopol">No. Polisi Kendaraan</label>
                                            <input type="text" class="form-control" name="nopol" id="nopol" required value="<?= $data['srvheader']['nopol']; ?>">
                                        </div>
                                    </div>    
                                </div>
                            </div>
                            <hr style="margin-bottom:0px;">
                            <div class="row">   
                                <div class="header">                                      
                                    <h2>Service Component</h2>
                                </div>
                                <div class="body">  
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Material</th>
                                                        <th>Material Description</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-pr-body" class="mainbodynpo">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn bg-blue pull-right" id="btn-post" style="margin-left:5px;">
                                            <i class="material-icons">save</i> <span>UPDATE</span>
                                        </button>
                                        <button type="button" id="btn-dlg-add-item" class="btn bg-blue pull-right" style="margin-left:5px;">
                                            <i class="material-icons">playlist_add</i> <span>ADD COMPONENT</span>
                                        </button>

                                        <!-- <button type="button" id="btn-dlg-reservasi" class="btn bg-blue pull-right">
                                            <i class="material-icons">playlist_add</i> <span>ADD FROM RESERVATION</span>
                                        </button> -->
                                    </div>
                                </body>
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
                        <h4 class="modal-title">Select Material</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-responsive" id="list-barang" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Description</th>
                                        <th>Warehouse</th>
                                        <th>Quantity</th>
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

        <div class="modal fade" id="reservationModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Select Service Item From Reservation</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-responsive" id="list-reservasi" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Reservation</th>
                                        <th>Requstor</th>
                                        <th>Reservation Date</th>
                                        <th>Note</th>
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

            var serviceitem       = [];

            serviceitem = <?= json_encode($data['srvdetail']); ?>;
            // console.log(serviceitem);
            
            function loaddatabarang(_warehouse){
                $('#list-barang').dataTable({
                    "ajax": base_url+'/service/listmaterial/'+_warehouse,
                    "columns": [
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "warehouse" },
                        { "data": "quantity" },
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

                    console.log(selected_data)
                    
                    kodebrg = selected_data.material;
                    $('#namabrg').val(selected_data.matdesc);
                    $('#satuan').val(selected_data.matunit);

                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
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
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:110px; text-align:right;" required="true" autocomplete="off"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ selected_data.matunit +`" readonly/>
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
                    });

                    $('.inputNumber').on('change', function(){
                        this.value = formatRupiah(this.value, '');
                    });
                } );
            }

            loadServiceItem();
            function loadServiceItem(){
                
                for(var i = 0; i < serviceitem.length; i++){
                    var serviceqty = '';
                    serviceqty = serviceitem[i].quantity;
                    serviceqty = serviceqty.replace('.00','');
                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ serviceitem[i].material +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ serviceitem[i].matdesc +`" readonly/>
                            </td>
                            
                            
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:110px; text-align:right;" required="true" autocomplete="off" value="`+ serviceqty +`"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ serviceitem[i].unit +`" readonly/>
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
                    });

                    $('.inputNumber').on('change', function(){
                        this.value = formatRupiah(this.value, '');
                    });
                }
            }

            function loaddatareservasi(){
                $('#list-reservasi').dataTable({
                    "ajax": base_url+'/movement/listreservasitotf',
                    "columns": [
                        { "data": "resnum" },
                        { "data": "requestor" },
                        { "data": "resdate" },
                        { "data": "note" },
                        { "data": "whsname" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-reservasi tbody').on( 'click', 'button', function () {
                    $('#tbl-pr-body').html('');
                    var table = $('#list-reservasi').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    $('#reservationModal').modal('hide');
                    console.log(selected_data)
                    $('#whsreq').val(selected_data.towhs);
                    $('#whsservice').val(selected_data.whsname);
                    $('#mekanik').val(selected_data.requestor);
                    readreservationitem(selected_data.resnum);  
                });
            }

            function readreservationitem(rsnum){
                // $('#tbl-pr-body').html('');
                $.ajax({
                    url: base_url+'/movement/reservationitem/'+rsnum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        $('#tbl-pr-body').html('');
                        if(result.length > 0){
                           for(var i = 0; i < result.length; i++){
                            count = count+1;
                            html = '';
                            html = `
                                <tr counter="`+ count +`" id="tr`+ count +`">
                                    <td class="nurut"> 
                                        `+ count +`
                                        <input type="hidden" name="itm_no[]" value="`+ count +`" />
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ result[i].material +`" readonly/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ result[i].matdesc +`" readonly/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_whs[]" counter="`+count+`" id="whs`+count+`" class="form-control" style="width:100px;" value="`+ result[i].fromwhs +`" readonly/>
                                    </td>
                                    
                                    <td> 
                                        <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:110px; text-align:right;" required="true" autocomplete="off" value="`+ result[i].quantity +`"/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ result[i].unit +`" readonly/>
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
                            });

                            $('.inputNumber').on('change', function(){
                                this.value = formatRupiah(this.value, '');
                            });
                           }
                        }else{
                            $('#txt-message').html('No Reservation Items!');
                            $('.txt-message').show();
                        }
                    }
                }); 
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }            

            $('#btn-dlg-add-item').on('click', function(){
                $('#barangModal').modal('show');
                var seletedWhs = $('#warehouse').val();
                loaddatabarang(seletedWhs);
            });

            $('#btn-dlg-reservasi').on('click', function(){
                loaddatareservasi();
                $('#reservationModal').modal('show');
            });

            $('#btn-pilih-barang').on('click', function(){
                $('#barangModal').modal('show')
            });

            $('#add-new-item').on('click', function(){
                $('#largeModalLabel').html('Add New Item')
                $('#largeModal').modal('show');
                $('#btn-add-item').html('Add Item');
                action = 'add';
            });            

            $('#form-conf-service').on('submit', function(event){
                event.preventDefault();
                $("#btn-post").attr("disabled", true);
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/service/postconfirmservice',
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
                        if(data.msgtype === "1"){
                            showSuccessMessage('Service ' + servicenumber + ' Confirmed With Document Number'+ data.docnum)
                        }else{
                            showErrorMessage(JSON.stringify(data.message))                            
                        }
                    })
            })

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
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/service/confirm';
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
