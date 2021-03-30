    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-pr-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">        
                            <button type="button" id="btn-change" class="btn btn-success waves-effect">Change</button>                        
							<a href="<?= BASEURL; ?>/bom" class="btn btn-danger waves-effect">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" name="bomid" value="<?= $data['bomhead']['bomid']; ?>">
                                                <label for="partnumb">Part Number</label>
                                                <input type="text" name="partnumb" id="partnumb" class="form-control" readonly placeholder="Part Number" value="<?= $data['bomhead']['partnumber']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="partname">Part Name</label>
                                                <input type="text" name="partname" id="partname" class="form-control readOnly" placeholder="Part Name" value="<?= $data['bomhead']['partname']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 divCustomer">
                                        <div class="form-group">
                                            <label for="custid">Customer</label>
                                            <select name="custid" class="form-control readOnly" id="custid" required>
                                                <option value="<?= $data['_cust']['cust_id']; ?>"><?= $data['_cust']['cust_name']; ?></option>
                                                <?php foreach($data['cust'] as $cust) : ?>
                                                    <option value="<?= $cust['cust_id']; ?>"><?= $cust['cust_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="customer">Customer Name</label>
                                                <input type="text" name="customer" id="customer" class="form-control readOnly" placeholder="Customer" value="<?= $data['bomhead']['customer']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="qtycct">Quantity CCT</label>
                                                <input type="number" name="qtycct" id="qtycct" class="form-control readOnly" value="<?= number_format($data['bomhead']['qtycct'], 0, ',', '.'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reference">Reference</label>
                                                <input type="text" name="reference" id="reference" class="form-control readOnly" value="<?= $data['bomhead']['reference']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>
                                Components
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-responsive table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;">No</th>
                                                <th>Component</th>
                                                <th>Description</th>
                                                <th style="width:50px;">Quantity</th>
                                                <th style="width:50px;">Unit</th>
                                                <th class="hideComponent">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">

                                        </tbody>
                                    </table>
                                    <ul class="pull-right">    
                                        <button type="button" id="btn-dlg-add-item" class="btn bg-blue hideComponent">
                                            <i class="material-icons">playlist_add</i> <span>ADD COMPONENT</span>
                                        </button>

                                        <button type="submit" class="btn bg-blue hideComponent" id="btn-post">
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
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModal">Pilih Material</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-barang" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
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
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });

        $('#custid').on('change', function(){
            var custid = $('#custid option:selected').text();
            $('#customer').val(custid);
        })
        
        $(function(){
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;
            var bomid   = "<?= $data['bomid']; ?>";
            var bomdata = <?= $data['bomdtl']; ?>;
            
            loadbomitem();
            function loadbomitem(){
                        for(var i=0; i<bomdata.length; i++){
                            var bomqty = '0';
                            bomqty = bomdata[i].quantity.replaceAll('.00','');
                            bomqty = bomqty.replaceAll('.',',');
                            count = count+1;
                            html = '';
                            html = `
                                <tr counter="`+ count +`" id="tr`+ count +`">
                                    <td class="nurut"> 
                                        `+ count +`
                                        <input type="hidden" name="itm_no[]" value="`+ count +`" />
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" readonly style="width:100%;" required="true" value="`+ bomdata[i].component +`" />
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" readonly style="width:100%;" value="`+ bomdata[i].matdesc +`"/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_qty[]" counter="`+count+`" id="compqty`+count+`"  class="form-control inputNumber readOnly" style="width:65px; text-align:right;" required="true" value="`+ bomqty +`"/>
                                    </td>
                                    <td> 
                                        <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" readonly style="width:60px; readOnly" required="true" value="`+ bomdata[i].unit +`"/>
                                    </td>
                                    <td class="hideComponent">
                                        <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                                    </td>
                                </tr>
                            `;
                            $('#tbl-pr-body').append(html);
                            renumberRows();

                            $("#compqty"+count).keydown(function(event){
                                if(event.keyCode == 190) {
                                    event.preventDefault();
                                    showErrorMessage("Untuk decimal separator gunakan ( , )")
                                    return false;
                                }
                            });

                            $('.removePO').on('click', function(e){
                                e.preventDefault();
                                $(this).closest("tr").remove();
                                renumberRows();
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
                
            }

            loaddatabarang();
            function loaddatabarang(){
                $('#list-barang').dataTable({
                    "ajax": base_url+'/barang/listbarang',
                    "columns": [
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "partname" },
                        { "data": "partnumber" },
                        { "data": "matunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-barang tbody').on( 'click', 'button', function () {
                    var table = $('#list-barang').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_material[]" counter="`+count+`" id="material`+count+`" class="form-control materialCode" style="width:100%;" required="true" value="`+ selected_data.material +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_matdesc[]" counter="`+count+`" id="matdesc`+count+`" class="form-control" style="width:100%;" value="`+ selected_data.matdesc +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_qty[]" counter="`+count+`" id="compqty`+count+`"  class="form-control inputNumber" style="width:65px; text-align:right;" required="true" autocomplete="off"/>
                            </td>
                            <td> 
                                <input type="text" name="itm_unit[]" counter="`+count+`" id="unit`+count+`" class="form-control" style="width:60px;" required="true" value="`+ selected_data.matunit +`" readonly/>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-pr-body').append(html);
                    renumberRows();

                    $("#compqty"+count).keydown(function(event){
                                if(event.keyCode == 190) {
                                    event.preventDefault();
                                    showErrorMessage("Untuk decimal separator gunakan ( , )")
                                    return false;
                                }
                            });

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
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
                    })
                } );
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }

            $('#btn-change').on('click', function(){
                if(this.innerText === "Change"){
                    document.getElementById("btn-change").innerText = 'Display';
                    $('.readOnly').attr("readonly", false);
                    $('.hideComponent').show();
                    $('#title').html("Edit Bom <?= $data['bomhead']['partnumber']; ?>");
                }else{
                    document.getElementById("btn-change").innerText = 'Change';
                    $('.readOnly').attr("readonly", true);
                    $('.hideComponent').hide();
                    $('#title').html("Display Detail <?= $data['bomhead']['partnumber']; ?>");
                }                
            })

            $('#btn-dlg-add-item').on('click', function(){
                $('#barangModal').modal('show')
            })

            $('#btn-pilih-barang').on('click', function(){
                $('#barangModal').modal('show')
            });

            $('#add-new-item').on('click', function(){
                $('#largeModalLabel').html('Add New Item')
                $('#largeModal').modal('show');
                $('#btn-add-item').html('Add Item');
                action = 'add';
            })

            $('#form-pr-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/bom/update',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('#btn-post').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	console.log(data);
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(result){
                        console.log(result)
                        if(result.msgtype === "1"){
                            showSuccessMessage(result.message);
                            $("#btn-post").attr("disabled", false);
                        }else if(result.msgtype === "2"){
                            showErrorMessage(JSON.stringify(result))            
                            $("#btn-post").attr("disabled", false);  
                        }
                    })
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
                        window.location.href = base_url+'/bom';
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