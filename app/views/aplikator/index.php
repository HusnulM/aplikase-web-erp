    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>

            <!-- <form id="form-input-data" method="POST">          -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <!-- <button type="submit" class="btn bg-green waves-effect" id="btn-save">
                                        <i class="material-icons">save</i> <span>SAVE</span>
                                    </button> -->
                                    <button type="button" class="btn bg-green waves-effect" id="btn-add">
                                        <i class="material-icons">add</i> <span>TAMBAH APLIKATOR</span>
                                    </button>
                                </ul>
                            </div>
                            <div class="body">
                                <!-- <div class="row">                                    
                                    <div class="col-lg-12">
                                        <label for="idaplikator">Nama Aplikator</label>
                                        <input type="text" name="idaplikator" id="idaplikator" class="form-control"  required/>
                                    </div>                             
                                </div>
                                <br>
                                <hr> -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-responsive" id="list-aplikator" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA APLIKATOR</th>
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
            <!-- </form> -->
        </div> 
            
            <!-- Modal Add Applikator -->
            <div class="modal fade" id="aplikatorModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <form id="form-input-data" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="aplikatorModalLabel">Tambah Aplikator</h4>
                        </div>
                        <div class="modal-body">
                            <!-- <div class="col-lg-12"> -->
                                <!-- <label for="idaplikator">Nama Aplikator</label> -->
                                <input type="text" name="idaplikator" id="idaplikator" class="form-control"  required placeholder="Nama Aplikator"/>
                            <!-- </div>   -->
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                                <button type="submit" class="btn btn-success waves-effect">SIMPAN</button>
                            </div>
                        </div>
                    </div>
                    </form>
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

            $('#btn-add').on('click', function(){
                $('#aplikatorModal').modal('show')
            })

            loadaplikator();
            function loadaplikator(){
                $('#list-aplikator').dataTable({
                    "ajax": _apiurl+'aplikatorMaster',
                    "columns": [
                        { "data": "idaplikator", 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "nama" },
                        {"defaultContent": "<button class='btn btn-danger btn-xs'>Hapus</button>"}
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
                    deleteAplikator(selected_data.idaplikator);
                    // $('#idaplikator').val(selected_data.idaplikator);
                    // $('#aplikatorModal').modal('hide');
                } );
            }

            function deleteAplikator($id){
                $.ajax({
                    url:_apiurl+'deleteaplikator/data?idaplikator='+$id,
                    method:'get',
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
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
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result))            
                    }
                })
            }

            $('#form-input-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                
                    $.ajax({
                        url:_apiurl+'createaplikator',
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
                        window.location.href = base_url+'/aplikator';
                        // loadaplikator();
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })
    </script>