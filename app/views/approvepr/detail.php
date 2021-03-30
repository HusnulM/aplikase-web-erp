    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                            Display Purchase Request <?= $data['prhead']['prnum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">        
                            <a href="<?= BASEURL; ?>/approvepr/approve/<?= $data['prnum']; ?>" id="btn-approve" class="btn btn-success waves-effect">Approve</a>  

                            <a href="<?= BASEURL; ?>/approvepr/reject/<?= $data['prnum']; ?>" id="btn-approve" class="btn btn-danger waves-effect">Reject</a>  

							<a href="<?= BASEURL; ?>/approvepr" class="btn btn-default waves-effect">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['prhead']['note']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Request Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['prhead']['prdate']; ?>">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick readOnly" name="warehouse" id="warehouse">
                                                    <option value="<?= $data['prhead']['warehouse']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
                                                    <?php foreach($data['whs'] as $out) : ?>
                                                    <option value="<?= $out['gudang']; ?>"><?= $out['deskripsi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="requestor">Requestor</label>
                                                <input type="text" class="form-control readOnly" name="requestor" id="requestor" value="<?= $data['prhead']['requestby']; ?>">
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
                                Purchase Request Item
                            </h2>
                                    
                            <ul class="header-dropdown m-r--5">                                
                                <button type="button" id="btn-save" class="btn btn-primary waves-effect pull-right hideComponent">SAVE</button>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table id="dg" class="easyui-datagrid" style="width:98%;height:200px" toolbar="#toolbar" fitColumns="true" singleSelect="true">
                                        <thead>
                                            <tr>
                                                <th field="kodebrg"  width="150">Material</th>
                                                <th field="namabrg"  width="300">Material Desc</th>
                                                <th field="quantity" width="120" align="right">Quantity</th>
                                                <th field="unit"     width="80">Unit</th>
                                                <th field="remark"   width="350">Remark</th> 
                                            </tr>
                                        </thead>
                                    </table>
                                    <div id="toolbar">
                                        <button class="easyui-linkbutton hideComponent" iconCls="icon-add" plain="true" id="add-new-item">Add New Item</button>
                                        <button class="easyui-linkbutton hideComponent" iconCls="icon-edit" plain="true" id="edit-pr-item">Change PR Item</button>
                                        <button class="easyui-linkbutton hideComponent" iconCls="icon-remove" plain="true" id="delete-pr-item">Delete PR Item</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="largeModalLabel">Add Purchase Request Item</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="namabrg">Item Name</label>
                                            <input type="text" name="namabrg" id="namabrg" class="form-control" placeholder="Item Name" autocomplete="false" > 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">-</label>
                                            <button id="btn-pilih-barang" class="form-control btn btn-primary">Pilih Barang</button> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="btn btn-primary btn-sm float-left" style="width:100%;">
                                            <span>Upload Photo Barang</span>
                                            <input type="file" id="ifile" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <button class="form-control btn btn-primary" id="btn-clear-file">Clear File</button>
                                    </div>
                                </div>  
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="podate">Quantity</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Quantity" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="satuan">Unit</label>
                                            <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Unit" style="text-transform:uppercase">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="hidden" name="harga" id="harga" class="form-control" placeholder="Price">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="remark" class="form-control" id="remark" cols="30" rows="3" placeholder="Remark"></textarea>
                                        </div>
                                    </div>
                                </div>                                                                     
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-add-item" class="btn btn-primary">Add Item</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="barangModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModal">Pilih Barang</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-barang" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Item Name</th>
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
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>

        $(function(){
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];

            var sel_prnum = "<?= $data['prhead']['prnum']; ?>";
            

            $.ajax({
                url: base_url+'/pr/getpritem/'+sel_prnum,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    console.log(result)
                    for(var i=0; i<result.length; i++){
                        let object = new Object();
                        object["kodebrg"]  = result[i].material;
                        object["namabrg"]  = result[i].matdesc;
                        object["jmlPesan"] = result[i].quantity;
                        object["satuan"]     = result[i].unit;
                        object["remark"]   = result[i].remark;

                        detail_order_beli.push(object);		
                        var count = $('#dg').datagrid('getRows');
                        $('#dg').datagrid('appendRow',{
                            item        : count.length + 1,
                            kodebrg     : result[i].material,
                            namabrg     : result[i].matdesc,
                            quantity	: result[i].quantity,
                            unit        : result[i].unit,
                            remark      : result[i].remark
                        });

                        $('#dg').datagrid('reload');
                    }
                },error: function(err){
                }
            });

            $('.readOnly').attr("readonly", true);
            $('.hideComponent').hide();
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