    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <form action="<?= BASEURL ?>/meja/save" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="nomeja">Nomor Mesin / Meja</label>
                                        <input type="text" name="nomeja" class="form-control"  required/>
                                        <input type="hidden" name="nomejaid">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="reffid">REFF ID</label>
                                        <input type="text" name="reffid" class="form-control" />
                                    </div>
                                    <div class="col-lg-2">
                                        <br>
                                        <button type="submit" class="btn bg-green waves-effect">
                                            <i class="material-icons">save</i> <span>ADD</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>No Mesin / Meja</th>
                                                    <th>REFFID</th>
                                                    <th style="width:250px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 0; ?>
                                                <?php foreach($data['meja'] as $meja): ?>
                                                    <?php $no++; ?>
                                                    <tr>
                                                        <td><?= $meja['deskripsi']; ?></td>
                                                        <td><?= $meja['reffid']; ?></td>
                                                        <td>
                                                            <a href="<?= BASEURL; ?>/meja/delete/<?= $meja['nomeja']; ?>" class="btn btn-danger">DELETE</a> 

                                                            <button type="button" class="btn btn-primary btnEditMeja" data-id="<?= $meja['nomeja']; ?>" data-desc="<?= $meja['deskripsi']; ?>" data-reffid="<?= $meja['reffid']; ?>">
                                                                EDIT
                                                            </button>
                                                            <button type="button" class="btn btn-success btnAddMesinProcess" data-idmesin="<?= $meja['nomeja']; ?>" data-nmmesin="<?= $meja['deskripsi']; ?>">
                                                                ADD PROCESS
                                                            </button>   
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>        
    </section>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data No Meja/Mesin</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                    <form action="<?= BASEURL ?>/meja/update" method="POST"> 
                        <div class="col-lg-12">
                            <label for="nomeja">Nomor Mesin / Meja</label>
                            <input type="text" name="nomeja" id="nomeja" class="form-control"  required/>
                            <input type="hidden" name="nomejaid" id="nomejaid">
                        </div>
                        <div class="col-lg-12">
                            <label for="reffid">REFF ID</label>
                            <input type="text" name="reffid" id="reffid" class="form-control" />
                        </div>
                        <div class="col-lg-2">
                            <br>
                            <button type="submit" class="btn bg-green waves-effect">
                                <i class="material-icons">save</i> <span>SAVE</span>
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mejaProcessModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Process Meja / Mesin : <b id="_nmMeja"></b></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <form id="form-add-procses" method="POST"> 
                            <div class="col-lg-6">
                                <label for="nmmeja">Mesin / Meja</label>
                                <input type="text" name="nmmeja" id="nmmeja" class="form-control"  readonly/>
                                <input type="hidden" name="_nomejaid" id="_nomejaid">
                            </div>
                            <div class="col-lg-6">
                                <label for="proses">Nama Proses</label>
                                <input type="text" name="proses" id="proses" class="form-control" required/>
                            </div>
                            <div class="col-lg-2">
                                <br>
                                <button type="submit" class="btn bg-green waves-effect">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Meja / Mesin</th>
                                    <th>Proses</th>
                                    <th></th>
                                </thead>
                                <tbody id="tbl-meja-proses">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>                                                    
    <script>
        $(function(){
            var selMesin = '';
            $('.btnEditMeja').on('click', function(){
                console.log($(this).data())
                $('#nomejaid').val($(this).data('id'));
                $('#nomeja').val($(this).data('desc'));
                $('#reffid').val($(this).data('reffid'));
                $('#editModal').modal('show');
            });

            $('.btnAddMesinProcess').on('click', function(){
                selMesin = $(this).data('idmesin');
                var nmMesin  = $(this).data('nmmesin');
                $('#_nmMeja').html('');
                $('#_nmMeja').html(nmMesin);
                $('#nmmeja').val(nmMesin)
                $('#_nomejaid').val(selMesin);
                $('#mejaProcessModal').modal('show');

                readProcess(selMesin);
            });

            $('#form-add-procses').on('submit', function(event){
                event.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url:base_url+'/meja/saveprocess',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){

                        },
                        success:function(data)
                        {

                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                            console.log(err.responseText)     
                        }
                    }).done(function(result){
                        console.log(result)
                        if(result.msgtype === "1"){
                            showSuccessMessage(result.message);
                            readProcess(selMesin);
                        }else if(result.msgtype === "2"){
                            showErrorMessage(JSON.stringify(result))   
                        }
                    })
            })

            function readProcess(idmesin){
                $('#tbl-meja-proses').html('');
                $.ajax({
                    url: base_url+'/meja/listmejaproces/'+idmesin,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                    }
                }).done(function(result){
                    $('#proses').val('')
                    var count = 0;
                    for(var i = 0; i < result.length; i++){
                        count++;
                        $('#tbl-meja-proses').append(`
                            <tr>
                                <td>`+ count +`</td>
                                <td>`+ result[i].mesin +`</td>
                                <td>`+ result[i].proses +`</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" id="btnDelProc`+count+`" data-idmesin="`+ result[i].nomeja +`" data-idproses="`+ result[i].idproses +`" style="width:100%;">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        `);

                        $('#btnDelProc'+count).on('click', function(){
                            var delselMesin = $(this).data('idmesin');
                            var delselProcs = $(this).data('idproses');
                            $.ajax({
                                url: base_url+'/meja/deletemejaproces/'+delselMesin+'/'+delselProcs,
                                type: 'GET',
                                dataType: 'json',
                                cache:false,
                                success: function(result){
                                    
                                }
                            }).done(function(result){
                                
                                if(result.msgtype === "1"){
                                    showSuccessMessage(result.message);
                                    readProcess(selMesin);
                                }else if(result.msgtype === "2"){
                                    showErrorMessage(JSON.stringify(result))   
                                }
                            });
                        });
                    }
                });  
            }

            

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "error");
            }
        })
    </script>