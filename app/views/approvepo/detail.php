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
                            <a href="<?= BASEURL; ?>/approvepo/approve/data?ponum=<?= $data['ponum']; ?>" id="btn-approve" class="btn btn-success waves-effect">Approve</a>  

                            <a href="<?= BASEURL; ?>/approvepo/reject/data?ponum<?= $data['ponum']; ?>" id="btn-approve" class="btn btn-danger waves-effect">Reject</a>  

							<a href="<?= BASEURL; ?>/approvepo" class="btn btn-default waves-effect">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="vendor">Vendor</label>
                                                <input type="text" name="vendor" id="vendor" class="form-control readOnly" placeholder="Vendor" value="<?= $data['pohead']['namavendor']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-9">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="note">Note</label>
                                                <input type="text" name="note" id="note" class="form-control readOnly" placeholder="Note" value="<?= $data['pohead']['note']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="regdate">Request Date</label>
                                                <input type="date" name="reqdate" id="reqdate" class="datepicker form-control readOnly" value="<?= $data['pohead']['podat']; ?>">
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
                                    <table id="dg" class="easyui-datagrid" style="width:98%;height:200px" toolbar="#toolbar" fitColumns="true" singleSelect="true">
                                        <thead>
                                            <tr>
                                                <th field="item"     width="50">PO Item</th>
                                                <th field="kodebrg"  width="150">Material</th>
                                                <th field="namabrg"  width="300">Material Desc</th>
                                                <th field="quantity" width="100" align="right">Quantity</th>
                                                <th field="unit"     width="80">Unit</th>
                                                <th field="price"    width="100" align="right">Price</th>
                                                <th field="subtot"   width="100" align="right">Sub Total</th>
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
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>

        $(function(){
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];

            var sel_ponum = "<?= $data['pohead']['ponum']; ?>";
            

            $.ajax({
                url: base_url+'/po/getpoitem/data?ponum='+sel_ponum,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    console.log(result)
                    for(var i=0; i<result.length; i++){	
                        var count = $('#dg').datagrid('getRows');
                        $('#dg').datagrid('appendRow',{
                            item        : count.length + 1,
                            kodebrg     : result[i].material,
                            namabrg     : result[i].matdesc,
                            quantity	: formatRupiah(result[i].quantity.replaceAll('.00',''),''),
                            unit        : result[i].unit,
                            price       : formatRupiah(result[i].price.replaceAll('.00',''),''),
                            subtot      : formatRupiah(result[i].price.replaceAll('.00','')*result[i].quantity.replaceAll('.00',''),''),
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

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }        
    </script>