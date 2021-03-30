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
                                    <a href="<?= BASEURL; ?>/delivery/report" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>Delivery Reports</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">                                    
                                    <div class="col-lg-10">
                                        <label for="partnumber">Part Number</label>
                                        <input type="text" name="partnumber" id="partnumber" class="form-control"  readonly="true" required/>
                                        <input type="hidden" name="bomid" id="bomid">
                                    </div>
                                    <div class="col-lg-2">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-search-part">
                                            <i class="material-icons">format_list_bulleted</i> <span>PILIH PART</span>
                                        </button>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="stdpack">Std Pack</label>
                                        <input type="number" name="stdpack" id="stdpack" class="form-control"  required/>
                                    </div>  
                                    <div class="col-lg-4">
                                        <label for="idate">Tanggal Delivery</label>
                                        <input type="date" name="idate" id="idate" class="form-control"  required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="deltype">Delivery Type</label>
                                        <select name="deltype" id="deltype" class="form-control">
                                            <option value="REQ">Quantity Request</option>
                                            <option value="DEL">Quantity Delivery</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control"  required/>
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
                                <table class="table table-responsive" id="list-part" style="width:100%;">
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

            $('#btn-search-part').on('click', function(){
                $('#partModal').modal('show');
            });

            loaddatapart();
            function loaddatapart(){
                $('#list-part').dataTable({
                    "ajax": base_url+'/quotation/partlist',
                    "columns": [
                        { "data": "partnumber" },
                        { "data": "partname" },
                        { "data": "customer" },
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
                    $('#bomid').val(selected_data.bomid);
                    $('#partnumber').val(selected_data.partnumber);
                    $('#partModal').modal('hide');
                } );
            }

            $('#form-input-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/delivery/save',
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
                        window.location.href = base_url+'/delivery';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })
    </script>