<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-pr-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 id="title">
                            Display Purchase Request <?= $data['prhead']['prnum']; ?>
                            </h2> 

                            <ul class="header-dropdown m-r--5">        
                            <button type="button" id="btn-change" class="btn btn-success waves-effect">Change</button>                        
							<a href="<?= BASEURL; ?>/pr" class="btn btn-danger waves-effect">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
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

                                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="prtype">Type PR</label>
                                                <select class="form-control show-tick readOnly" name="prtype" id="prtype">
                                                    <?php if($data['prhead']['typepr'] === "PR01") : ?>
                                                        <option value="PR01">PR Stock</option>
                                                        <option value="PR02">PR Lokal</option>
                                                    <?php else: ?>
                                                        <option value="PR02">PR Lokal</option>
                                                        <option value="PR01">PR Stock</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="warehouse">Warehouse</label>
                                                <select class="form-control show-tick readOnly" name="warehouse" id="warehouse">
                                                    <option value="<?= $data['_whs']['gudang']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
                                                    <?php foreach($data['whs'] as $whs): ?>
                                                        <?php if($data['_whs']['gudang'] !== $whs['gudang']) :?>
                                                            <option value="<?= $whs['gudang']; ?>"><?= $whs['deskripsi']; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>   

                                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="requestor">Requestor</label>
                                                <input type="text" class="form-control readOnly" name="requestor" id="requestor" value="<?= $data['prhead']['requestby']; ?>">
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Request Item
                            </h2>
                                    
                            <ul class="header-dropdown m-r--5">                                
                                
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Material</th>
                                                    <th>Material Description</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Remark</th>
                                                    <th class="hideComponent">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl-pr-body" class="mainbodynpo">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row hideComponent">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <ul class="pull-right">  
                                        <button type="button" id="btn-dlg-add-item" class="btn bg-blue hideComponent">
                                            <i class="material-icons">playlist_add</i> <span>ADD ITEM</span>
                                        </button>

                                        <button type="submit" class="btn bg-blue hideComponent">
                                            <i class="material-icons">save</i> <span>SAVE</span>
                                        </button>  
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
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
            var count = 0;

            var sel_prnum = "<?= $data['prhead']['prnum']; ?>";

            function materialExists(material) {
                return detail_order_beli.some(function(el) {
                    return el.material === material;
                }); 
            }

            loaddatabarang();
            function loaddatabarang(){
                $('#list-barang').dataTable({
                    "ajax": base_url+'/barang/listbarang',
                    "columns": [
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "matunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    // "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-barang tbody').on( 'click', 'button', function () {
                    var table = $('#list-barang').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    if(materialExists(selected_data.material)){

                    }else{
                        detail_order_beli.push(selected_data);
                        count = count+1;
                        html = '';
                        html = `
                            <tr counter="`+ count +`" id="tr`+ count +`">
                                <td class="nurut"> 
                                    `+ count +`
                                    <input type="hidden" name="itm_no[]" value="`+ count +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ selected_data.material +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ selected_data.matdesc +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber" style="width:100px; text-align:right;" required="true" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px;" required="true" value="`+ selected_data.matunit +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_remark[]" class="form-control" style="width:200px;" counter="`+count+`" id="poprice`+count+`"/>
                                </td>
                                <td class="hideComponent">
                                    <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`" id="btnRemove`+count+`">Remove</button>
                                </td>
                            </tr>
                        `;
                        $('#tbl-pr-body').append(html);
                        renumberRows();

                        $('#btnRemove'+count).on('click', function(e){
                            e.preventDefault();
                            var row_index = $(this).closest("tr").index();
                            removeitem(row_index);                        
                            $(this).closest("tr").remove();
                            renumberRows();
                            console.log(detail_order_beli)
                        })

                        // $('.removePO').on('click', function(e){
                        //     e.preventDefault();
                        //     $(this).closest("tr").remove();
                        //     renumberRows();
                        // })

                        $('.materialCode').on('change', function(){
                            var xcounter = $(this).attr('counter');
                            var kodebrg  = $('#material'+xcounter).val();

                            getMaterialbyKode(kodebrg, function(d){
                                console.log(d)
                                $('#matdesc'+xcounter).val(d.matdesc);
                                $('#unit'+xcounter).val(d.matunit);
                            });
                        })

                        $('.inputNumber').on('change', function(){
                            this.value = formatRupiah(this.value, '');
                        });
                    }
                    
                } );
            }

            function getnamabarang(_kodebrg){
                $.ajax({
                    url: base_url+'/barang/caribarangbykode/'+_kodebrg,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        namabrg = result.namabrg
                    }
                });                
            }

            $.ajax({
                url: base_url+'/pr/getpritem/'+sel_prnum,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    // console.log(result)
                    
                    for(var i=0; i<result.length; i++){
                        detail_order_beli.push(result[i]);
                        count = count+1;
                        html = '';
                        html = `
                            <tr counter="`+ count +`" id="tr`+ count +`">
                                <td class="nurut"> 
                                    `+ count +`
                                    <input type="hidden" name="itm_no[]" value="`+ count +`" />
                                </td>
                                <td> 
                                    <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ result[i].material +`" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:300px;" value="`+ result[i].matdesc +`" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_qty[]" counter="`+count+`" id="poqty`+count+`"  class="form-control inputNumber readOnly" style="width:100px; text-align:right;" required="true" value="`+ result[i].quantity.replaceAll('.00','') +`"/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:80px; readOnly" required="true" value="`+ result[i].unit +`" readonly/>
                                </td>
                                <td> 
                                    <input type="text" name="itm_remark[]" class="form-control readOnly" style="width:200px;" counter="`+count+`" id="poprice`+count+`" value="`+ result[i].remark +`"/>
                                </td>
                                <td class="hideComponent">
                                    <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`" id="btnRemove`+count+`">Remove</button>
                                </td>
                            </tr>
                        `;
                        $('#tbl-pr-body').append(html);
                        renumberRows();

                        // $('.removePO').on('click', function(e){
                        //     e.preventDefault();
                        //     $(this).closest("tr").remove();
                        //     renumberRows();
                        // })
                        $('#btnRemove'+count).on('click', function(e){
                            e.preventDefault();
                            var row_index = $(this).closest("tr").index();
                            removeitem(row_index);                        
                            $(this).closest("tr").remove();
                            renumberRows();
                            console.log(detail_order_beli)
                        })

                        $('.materialCode').on('change', function(){
                            var xcounter = $(this).attr('counter');
                            var kodebrg  = $('#material'+xcounter).val();

                            getMaterialbyKode(kodebrg, function(d){
                                console.log(d)
                                $('#matdesc'+xcounter).val(d.matdesc);
                                $('#unit'+xcounter).val(d.matunit);
                            });
                        })

                        $('.inputNumber').on('change', function(){
                            this.value = formatRupiah(this.value, '');
                        });

                        $('.hideComponent').hide();
                        $('.readOnly').attr("readonly", true);
                    }
                },error: function(err){
                }
            }).done(function(){
                console.log(detail_order_beli);
            });

            function removeitem(index){
                detail_order_beli.splice(index, 1);
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }

            $('#form-pr-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/pr/updatepr/'+sel_prnum,
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            // $('#btn-save').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	console.log(data);
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(data){
                        showSuccessMessage('PR ' + sel_prnum + ' Updated!')
                    })
            })

            $('.readOnly').attr("readonly", true);
            $('.hideComponent').hide();

            $('#btn-change').on('click', function(){
                if(this.innerText === "Change"){
                    document.getElementById("btn-change").innerText = 'Display';
                    $('.readOnly').attr("readonly", false);
                    // $('._disable').attr("disabled", false);
                    $('._disable').removeAttr("disabled");
                    $('.hideComponent').show();
                    $('#title').html("Edit Purchase Request <?= $data['prhead']['prnum']; ?>");
                }else{
                    document.getElementById("btn-change").innerText = 'Change';
                    $('.readOnly').attr("readonly", true);
                    $('._disable').attr("disabled", true);
                    $('.hideComponent').hide();
                    $('#title').html("Display Purchase Request <?= $data['prhead']['prnum']; ?>");
                }                
            })

            $('#btn-dlg-add-item').on('click', function(){
                $('#barangModal').modal('show')
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

            function showBasicMessage() {
                swal({title:"Loading...", text:"Mohon Menunggu", showConfirmButton: false});
            }

            function showSuccessMessage(message) {
                // swal("Success", message, "success");
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/pr';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
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