    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <!-- action="<?= BASEURL; ?>/delivery/save" -->
            <form id="form-input-data" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <button type="submit" class="btn bg-green waves-effect" id="btn-save">
                                        <i class="material-icons">save</i> <span>SAVE</span>
                                    </button>
                                    <a href="<?= BASEURL; ?>/partaplikator/display" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>Display</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">                                    
                                    <div class="col-lg-4">
                                        <label for="partname">Nama Part</label>
                                        <input type="text" name="partname" id="partname" class="form-control"  readonly="true" required/>
                                        <input type="hidden" name="bomid" id="bomid">
                                    </div>
                                    <div class="col-lg-3">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-search-part">
                                            <i class="material-icons">format_list_bulleted</i> <span>PILIH PART</span>
                                        </button>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="partnumber">Kode Barang</label>
                                        <input type="text" name="partnumber" id="partnumber" class="form-control"  required/>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="idaplikator">Nama Aplikator</label>
                                        <input type="text" name="idaplikator" id="idaplikator" class="form-control"  required/>
                                    </div>  
                                    <div class="col-lg-3">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-search-aplikator">
                                            <i class="material-icons">format_list_bulleted</i> <span>PILIH APLIKATOR</span>
                                        </button>
                                    </div>  
                                </div>
                                <div class="row">
                                    <hr>
                                    <h4 style="margin:15px;">Lokasi Penyimpanan</h4>
                                    <div class="col-lg-4">
                                        <label for="rak">Rak</label>
                                        <div id="listrak"></div>
                                        <!-- <select name="rak" id="rak" class="form-control">
                                            
                                        </select> -->
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="deltype">Laci</label>
                                        <div id="listlaci"></div>
                                        <!-- <select name="laci" id="deltype" class="form-control">
                                            <option value="REQ">Laci 1</option>
                                            <option value="DEL">Laci 2</option>
                                        </select> -->
                                    </div> 
                                    <div class="col-lg-4">
                                        <label for="deltype">Nomor</label>
                                        <div id="listsnum"></div>
                                        <!-- <select name="snum" id="deltype" class="form-control">
                                            <option value="REQ">S1</option>
                                            <option value="DEL">S2</option>
                                            <option value="DEL">S3</option>
                                            <option value="DEL">S4</option>
                                        </select> -->
                                    </div>  
                                </div>
                                <br><br><br>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

            <div class="modal fade" id="partModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="vendorModalLabel">Pilih Partnumber</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive table-bordered table-striped" id="list-part" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Part Number</th>
                                            <th>Part Name</th>
                                            <th>Customer</th>
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

            <div class="modal fade" id="aplikatorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="aplikatorModalLabel">Pilih Aplikator</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive table-bordered table-striped" id="list-aplikator" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID Aplikator</th>
                                            <th>Nama</th>
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
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            var _apiurl = "http://localhost:8181/aws-eproc/aplikator/";

            $('#btn-search-part').on('click', function(){
                $('#partModal').modal('show');
            });

            $('#btn-search-aplikator').on('click', function(){
                loadaplikator();
                $('#aplikatorModal').modal('show');
            });

            // partMaster
            loaddatapart();
            function loaddatapart(){
                $('#list-part').dataTable({
                    "ajax": _apiurl+'partMaster',
                    "columns": [
                        { "data": "kodebrg" },
                        { "data": "namabrg" },
                        { "data": "satuan" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-part tbody').on( 'click', 'button', function () {
                    var table = $('#list-part').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    $('#partnumber').val(selected_data.kodebrg);
                    $('#partname').val(selected_data.namabrg);
                    $('#partModal').modal('hide');
                } );
            }

            function loadaplikator(){
                $('#list-aplikator').dataTable({
                    "ajax": _apiurl+'aplikatorMaster',
                    "columns": [
                        { "data": "idaplikator" },
                        { "data": "nama" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-aplikator tbody').on( 'click', 'button', function () {
                    var table = $('#list-aplikator').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    $('#idaplikator').val(selected_data.idaplikator);
                    $('#aplikatorModal').modal('hide');
                } );
            }

            loadmasterlokasi();
            function loadmasterlokasi(){
                $.ajax({
                    url: _apiurl+'rakMaster',
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                    }
                }).done(function(result){
                    var listitem = '';
                    listitem += `<select name="rak" id="rak" class="form-control" required>`;
                    for (var i = 0; i < result['data'].length; i++) {
                        listitem += `<option value="`+ result['data'][i].rak +`">`+ result['data'][i].deskripsi +`</option>`;
                    };
                    listitem += `</select>`;
                    $("#listrak").append(listitem);             
                });  

                $.ajax({
                    url: _apiurl+'laciMaster',
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                    }
                }).done(function(result){
                    var listlaci = '';
                    listlaci += `<select name="laci" id="laci" class="form-control" required>`;
                    for (var i = 0; i < result['data'].length; i++) {
                        listlaci += `<option value="`+ result['data'][i].laci +`">`+ result['data'][i].deskripsi +`</option>`;
                    };
                    listlaci += `</select>`;
                    $("#listlaci").append(listlaci);             
                });  

                $.ajax({
                    url: _apiurl+'snumMaster',
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                    }
                }).done(function(result){
                    var listsnum = '';
                    listsnum += `<select name="snum" id="snum" class="form-control" required>`;
                    for (var i = 0; i < result['data'].length; i++) {
                        listsnum += `<option value="`+ result['data'][i].snum +`">`+ result['data'][i].snum +`</option>`;
                    };
                    listsnum += `</select>`;
                    $("#listsnum").append(listsnum);             
                });                   
            }

            $('#form-input-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                
                    $.ajax({
                        url:_apiurl+'createpartlocation',
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
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(result){
                        if(result.msgtype === "1"){
                            showSuccessMessage(result.message);
                            $("#btn-save").attr("disabled", false);
                        }else if(result.msgtype === "2"){
                            showErrorMessage(JSON.stringify(result))            
                            $("#btn-save").attr("disabled", false);  
                        }
                    })
            })

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/partaplikator';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })
    </script>