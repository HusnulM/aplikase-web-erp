    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                            Approve Purchase Request <?= $data['prhead']['prnum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">   
							<a href="<?= BASEURL; ?>/approvepr" class="btn bg-teal waves-effect">
                                <i class="material-icons">backspace</i> <span>BACK</span>
                            </a>
							</ul>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['prhead']['note']; ?>" readonly disabled>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Request Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['prhead']['prdate']; ?>" disabled>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="prtype">Type PR</label>
                                                <select class="form-control show-tick readOnly" name="prtype" id="prtype" disabled>
                                                    <?php if($data['prhead']['typepr'] === "PR01") : ?>
                                                        <option value="PR01">PR Stock</option>
                                                    <?php else: ?>
                                                        <option value="PR02">PR Lokal</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick" name="warehouse" id="warehouse" disabled>
                                                <option value="<?= $data['_whs']['gudang']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>   

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="requestor">Requestor</label>
                                                <input type="text" class="form-control readOnly" name="requestor" id="requestor" value="<?= $data['prhead']['requestby']; ?>" readonly disabled>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Request Item
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-responsive table-bordered table-striped" id="tbl-pr-item">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="checkAll" class="filled-in" />
                                                    <label for="checkAll"></label>
                                                </th>
                                                <th>PR Item</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['prdata'] as $pr) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td>
                                                        <?php if($pr['approvestat'] === $data['approvelevel']['level']) : ?>
                                                            <input class="filled-in checkbox" type="checkbox" id="<?= $pr['pritem']; ?>" name="ID[]">
                                                            <label for="<?= $pr['pritem']; ?>"></label>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $pr['pritem']; ?></td>
                                                    <td><?= $pr['material']; ?></td>
                                                    <td><?= $pr['matdesc']; ?></td>
                                                    <td><?= $pr['mattypedesc']; ?></td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['quantity'], '.00') !== false) {
                                                            echo number_format($pr['quantity'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['quantity'], 2, ',', '.');
                                                        } ?>  
                                                    </td>
                                                    <td><?= $pr['unit']; ?></td>
                                                    <td>Open</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <ul class="pull-right">                                           
                                        <button type="button" class="btn bg-red" id="btn-reject">
                                            <i class="material-icons">highlight_off</i> <span>REJECT</span>
                                        </button>
                                        <button type="button" class="btn bg-green" id="btn-approve">
                                            <i class="material-icons">done_all</i> <span>APPROVE</span>
                                        </button>
                                    </ul>
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

        $(function(){
            

            var sel_prnum = "<?= $data['prhead']['prnum']; ?>";
            $('#checkAll').click(function(){
                if(this.checked){
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });   
                }else{
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                } 
            });

            $('#btn-approve').on('click', function(){
                var tableControl= document.getElementById('tbl-pr-item');
                var _splchecked = [];
                $('input[name="ID[]"]:checkbox:checked', tableControl).each(function() {
                    _splchecked.push($(this).parent().next().text())
                }).get();
                if(_splchecked.length > 0){
                    console.log(_splchecked)
                    var prtemchecked = {
                        "pritem" : _splchecked
                    }
                    $.ajax({
                        url:base_url+'/approvepr/approvepritem/'+sel_prnum,
                        method:'post',
                        data:prtemchecked,
                        dataType:'JSON',
                        beforeSend:function(){
                            $('#btn-approve').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(data){
                        console.log(data);
                        $('#btn-approve').attr('disabled',false);
                        showSuccessMessage('Selected PR Item Approved');                        
                    })   
                }else{
                    alert('No record selected ');
                }
            });

            $('#btn-reject').on('click', function(){
                var tableControl= document.getElementById('tbl-pr-item');
                var _splchecked = [];
                $('input[name="ID[]"]:checkbox:checked', tableControl).each(function() {
                    _splchecked.push($(this).parent().next().text())
                }).get();
                if(_splchecked.length > 0){
                    console.log(_splchecked)
                    var prtemchecked = {
                        "pritem" : _splchecked
                    }
                    $.ajax({
                        url:base_url+'/approvepr/rejectpritem/'+sel_prnum,
                        method:'post',
                        data:prtemchecked,
                        dataType:'JSON',
                        beforeSend:function(){
                            $('#btn-approve').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(data){
                        console.log(data);
                        $('#btn-approve').attr('disabled',false);
                        showSuccessMessage('Selected PR Item Rejected');                        
                    })   
                }else{
                    alert('No record selected ');
                }
            });

            function showBasicMessage() {
                swal({title:"Loading...", text:"Mohon Menunggu", showConfirmButton: false});
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/approvepr';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        });    
    </script>