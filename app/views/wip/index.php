    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <!--  action="<?= BASEURL ?>/wip/save" method="POST" -->
            <form id="form-save-wip">         
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
                                    <a href="<?= BASEURL; ?>/wip/reportsummary" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>Report Summary WIP</span>
                                    </a>
                                    <a href="<?= BASEURL; ?>/wip/reportdetail" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>Report Detail WIP</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="area1">Area / Bagian</label>
                                        <select name="area1" id="area1" class="form-control">
                                            <?php foreach($data['meja'] as $meja): ?>
                                                <option value="<?= $meja['nomeja']; ?>"><?= $meja['deskripsi']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="process">IN / OUT</label>
                                        <select name="wiptype" id="wiptype" class="form-control" required>
                                            <?php foreach($data['wipauth'] as $wipauth) : ?>
                                                <?php if($wipauth['ob_value'] === "*") : ?>
                                                    <option value="IN">IN</option>
                                                    <option value="OUT">OUT</option>
                                                <?php else: ?>
                                                    <option value="<?= $wipauth['ob_value']; ?>"><?= $wipauth['ob_value']; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="area2">Tujuan Area / Bagian</label>
                                        <select name="area2" id="area2" class="form-control">
                                            <option value="0"></option>
                                            <?php foreach($data['meja'] as $meja): ?>
                                                <option value="<?= $meja['nomeja']; ?>"><?= $meja['deskripsi']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">      
                                        
                                        <label for="">Part Number</label>  
                                        <input type="text" name="partnumber" id="partnumber" class="form-control"  required readonly/>
                                        <input type="hidden" name="bomid" id="bomid">
                                    </div> 
                                    <div class="col-lg-2">
                                        <label for="">-</label>
                                        <button type="button" class="btn bg-blue form-control" id="btn-partlist">
                                        <i class="material-icons">list</i> Pilih Part
                                        </button>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="customer">Customer</label>
                                        <input type="text" name="customer" id="customer" class="form-control"  readonly/>
                                    </div>                              
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="quantity">QTY / Jumlah</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control"  required/>
                                    </div> 
                                    <div class="col-lg-6">
                                        <label for="idate">Periode</label>
                                        <input type="date" name="idate" id="idate" class="form-control"  required/>
                                    </div>
                                </dive>
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
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        $(function(){
            $('#btn-partlist').on('click', function(){
                $('#partModal').modal('show')
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
                    $('#customer').val(selected_data.customer);
                    $('#partModal').modal('hide');
                } );
            }

            $('#form-save-wip').on('submit', function(event){
                event.preventDefault();

                if($('#wiptype').val() === "OUT" && $('#area2').val() === "0"){
                    showErrorMessage("Pilih area tujuan");
                }else if($('#partnumber').val() ===""){
                    showErrorMessage("Pilih partnumber");
                }else{
                    var formData = new FormData(this);
                    console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/wip/save',
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
                        showSuccessMessage("WIP Created")
                    })
                }

            });

            function showSuccessMessage(message) {
                // swal("Success", message, "success");
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/wip';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "error");
            }
        })
    </script>