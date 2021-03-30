    <section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <button type="submit" id="btn-save" class="btn bg-blue"  data-type="success">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>

                                <!-- <a href="<?= BASEURL; ?>/material" type="button" id="btn-back" class="btn bg-red"  data-type="success">
                                    <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                </a> -->
                            </ul>
                        </div>
                        <div class="body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#basic_data_view" data-toggle="tab">
                                        <i class="material-icons">line_weight</i> Master RAK
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#alt_uom_view" data-toggle="tab">
                                        <i class="material-icons">line_weight</i> Master Laci
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#purchasing_view" data-toggle="tab">
                                        <i class="material-icons">line_weight</i> Master NO
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="basic_data_view">
                                    <div class="row clearfix">
                                        <br>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="rak" id="rak" class="form-control" placeholder="RAK">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="btn-add-rak">TAMBAH RAK</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-responsive table-bordered table-striped" id="list-rak" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>RAK</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="alt_uom_view">
                                    <div class="row clearfix">
                                        <br>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="kodelaci" id="kodelaci" class="form-control" placeholder="Kode Laci">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="laci" id="laci" class="form-control" placeholder="Laci">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="btn-add-laci">TAMBAH LACI</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-responsive table-bordered table-striped" id="list-laci" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Laci</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="purchasing_view">
                                    <div class="row clearfix">
                                        <br>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="snum" id="snum" class="form-control" placeholder="Nomor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="btn-add-snum">TAMBAH NOMOR</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table class="table table-responsive" id="list-snum" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>NOMOR</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                        
                                    </div>                                    
                                </div>
                            </div>
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

            $('#btn-add-rak').on('click', function(){
                var postdata = {
                    'rak' : $('#rak').val()
                }
                console.log(postdata)
                $.ajax({
                    url: _apiurl+'addrak',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        showErrorMessage(JSON.stringify(err))        
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        loadrak();
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }     
                    $('#rak').val('')                   
                }); 
            });

            $('#btn-add-laci').on('click', function(){
                var postdata = {
                    'laci' : $('#kodelaci').val(),
                    'deskripsi': $('#laci').val()
                }
                console.log(postdata)
                $.ajax({
                    url: _apiurl+'addlaci',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        showErrorMessage(JSON.stringify(err))        
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        loadlaci();
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }   
                    $('#kodelaci').val('');
                    $('#laci').val('');                        
                }); 
            });

            $('#btn-add-snum').on('click', function(){
                var postdata = {
                    'snum' : $('#snum').val()
                }
                console.log(postdata)
                $.ajax({
                    url: _apiurl+'addsnum',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        showErrorMessage(JSON.stringify(err))        
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        loadsnum();
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }     
                    $('#snum').val('')                        
                }); 
            });

            loadrak();
            function loadrak(){
                $('#list-rak').dataTable({
                    "ajax": _apiurl+'rakMaster',
                    "columns": [
                        { "data": "rak", 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "rak" },
                        {"defaultContent": "<button class='btn btn-danger btn-xs'>Hapus</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-rak tbody').on( 'click', 'button', function () {
                    var table = $('#list-rak').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    deleteRak(selected_data.rak)
                } );
            }

            loadlaci();
            function loadlaci(){
                $('#list-laci').dataTable({
                    "ajax": _apiurl+'laciMaster',
                    "columns": [
                        { "data": "laci", 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "deskripsi" },
                        {"defaultContent": "<button class='btn btn-danger btn-xs'>Hapus</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-laci tbody').on( 'click', 'button', function () {
                    var table = $('#list-laci').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    deleteLaci(selected_data.laci)
                } );
            }

            loadsnum();
            function loadsnum(){
                $('#list-snum').dataTable({
                    "ajax": _apiurl+'snumMaster',
                    "columns": [
                        { "data": "snum", 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "snum" },
                        {"defaultContent": "<button class='btn btn-danger btn-xs'>Hapus</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-snum tbody').on( 'click', 'button', function () {
                    var table = $('#list-snum').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    deleteSnum(selected_data.snum)
                } );
            }

            function deleteRak(rak){
                var postdata = {
                    'rak' : rak
                }
                $.ajax({
                    url: _apiurl+'deleterak',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        // showErrorMessage(JSON.stringify(err))   
                        showSuccessMessage('Rak dihapus');
                        loadrak();                          
                    }
                }).done(function(result){
                    showSuccessMessage('Rak dihapus');
                    loadrak();                         
                }); 
            }

            function deleteLaci(id){
                var postdata = {
                    'laci' : id
                }
                $.ajax({
                    url: _apiurl+'deletelaci',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        showErrorMessage(JSON.stringify(err))      
                        loadlaci();  
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        loadlaci();
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }                             
                }); 
            }

            function deleteSnum(id){
                var postdata = {
                    'snum' : id
                }
                $.ajax({
                    url: _apiurl+'deletesnum',
                    type: 'POST',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    success: function(result){
                        console.log(result)
                    },
                    error: function(err){
                        showErrorMessage(JSON.stringify(err))     
                        loadsnum();   
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        loadsnum();
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }                             
                }); 
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        // window.location.href = base_url+'/partaplikator';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })
    </script>