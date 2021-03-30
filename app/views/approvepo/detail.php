    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                            Display Purchase Order <?= $data['pohead']['ponum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">  

							<a href="<?= BASEURL; ?>/approvepo" class="btn bg-teal waves-effect">
                                <i class="material-icons">backspace</i> <span>BACK</span>
                            </a>
							</ul>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="vendor">Vendor</label>
                                                <input type="text" name="vendor" id="vendor" class="form-control readOnly" placeholder="Vendor" value="<?= $data['pohead']['namavendor']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="potype">Type PO</label>
                                                <select class="form-control show-tick" name="potype" id="potype" disabled>
                                                    <?php if($data['pohead']['potype'] === "PO01") : ?>
                                                        <option value="PO01">PO Stock</option>
                                                        <option value="PO02">PO Lokal</option>
                                                    <?php else: ?>
                                                        <option value="PO02">PO Lokal</option>
                                                        <option value="PO01">PO Stock</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick readOnly" name="warehouse" id="warehouse" disabled>
                                                    <option value="<?= $data['_whs']['gudang']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">PO Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['pohead']['podat']; ?>" readonly>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['pohead']['note']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <!-- PR Item -->
                        <div class="header">
                            <h2>
                                Purchase Order Item
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
                                                <th>PO Item</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Kategori</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Tax</th>
                                                <th>Discount</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['poitem'] as $pr) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td>
                                                        <?php if($pr['approvestat'] === $data['approvelevel']['level']) : ?>
                                                            <input class="filled-in checkbox" type="checkbox" id="<?= $pr['poitem']; ?>" name="ID[]">
                                                            <label for="<?= $pr['poitem']; ?>"></label>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $pr['poitem']; ?></td>
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
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['price'], '.00') !== false) {
                                                            echo number_format($pr['price'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['price'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    <td style="text-align:right;"><?= $pr['ppn']; ?>%</td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['discount'], '.00') !== false) {
                                                            echo number_format($pr['discount'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['discount'], 2, ',', '.');
                                                        } ?>
                                                    </td>
                                                    <td style="text-align:right;">
                                                        <?php if (strpos($pr['subtot'], '.00') !== false) {
                                                            echo number_format($pr['subtot'], 0, ',', '.');
                                                        }else{
                                                            echo number_format($pr['subtot'], 2, ',', '.');
                                                        } ?>
                                                    </td>
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

            var sel_ponum = "<?= $data['pohead']['ponum']; ?>";
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
                        "poitem" : _splchecked
                    }
                    $.ajax({
                        url:base_url+'/approvepo/approvepoitem/'+sel_ponum,
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
                        showSuccessMessage('Selected PO Item Approved');                        
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
                        "poitem" : _splchecked
                    }
                    $.ajax({
                        url:base_url+'/approvepo/rejectpritem/'+sel_ponum,
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
                        showSuccessMessage('Selected PO Item Rejected');                        
                    });
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
                        window.location.href = base_url+'/approvepo';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        });    
    </script>