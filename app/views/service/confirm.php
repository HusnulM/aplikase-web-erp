    <section class="content">
        <div class="container-fluid">
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <div class="row clearfix">
            <form id="form-conf-service" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">  
                                <a href="<?= BASEURL; ?>/service/postconfirmservice" class="btn bg-teal waves-effect">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="servicenum">Service Number</label>
                                            <input type="text" name="servicenum" id="servicenum" class="form-control" placeholder="Note" value="<?= $data['services']['servicenum']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="servicedate">Service Date</label>
                                            <input type="date" name="servicedate" id="servicedate" class="datepicker form-control" value="<?= $data['services']['servicedate']; ?>" readonly>
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="confdate">Confirmation Date</label>
                                            <input type="date" name="confdate" id="confdate" class="datepicker form-control" value="<?= date('Y-m-d'); ?>">
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="mekanik">Nama Mekanik</label>
                                            <input type="text" class="form-control" name="mekanik" value="<?= $data['services']['mekanik']; ?>" readonly>
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="warehouse">Warehouse</label>
                                            <select class="form-control show-tick" name="warehouse" id="warehouse" readonly>
                                                <option value="<?= $data['_whs']['gudang']; ?>"><?= $data['_whs']['deskripsi']; ?></option>
                                            </select>
                                        </div>
                                    </div>    
                                </div>  

                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="nopol">No. Polisi Kendaraan</label>
                                            <input type="text" class="form-control" name="nopol" value="<?= $data['services']['nopol']; ?>" readonly>
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="note">Note</label>
                                            <input type="text" class="form-control" name="note" placeholder="Note" value="<?= $data['services']['note']; ?>">
                                        </div>
                                    </div>    
                                </div>
                            </div>    
                            <div class="row">                                         
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th style="width:200px;">Kode Material</th>
                                                    <th>Material Description</th>
                                                    <th style="width:150px;">Quantity</th>
                                                    <th style="width:150px;">Unit</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl-pr-body" class="mainbodynpo">
                                                <?php $no = 0; ?>
                                                <?php foreach($data['servicesitem'] as $out) : ?>
                                                    <?php $no++; ?>
                                                    <tr>
                                                        <td class="nurut"> 
                                                            <?= $no; ?>
                                                            <input type="hidden" name="itm_no[]" value="<?= $out['serviceitem']; ?>" />
                                                        </td>
                                                        <td> 
                                                            <input type="text" name="itm_material[]" class="form-control materialCode" style="width:100%;" required="true" value="<?= $out['material']; ?>" readonly/>
                                                        </td>
                                                        <td> 
                                                            <input type="text" name="itm_matdesc[]" class="form-control" style="width:100%;" value="<?= $out['matdesc']; ?>" readonly/>
                                                        </td>
                                                        <td> 
                                                            <input type="text" name="itm_qty[]" class="form-control inputNumber" style="width:100%; text-align:right;" required="true" autocomplete="off" value="<?= number_format($out['quantity'],0); ?>"/>
                                                        </td>
                                                        <td> 
                                                            <input type="text" name="itm_unit[]"  class="form-control" style="width:100%;" required="true" value="<?= $out['unit']; ?>" readonly/>
                                                        </td>
                                                        <td> 
                                                            <a href="<?= BASEURL; ?>/service/deleteitem/<?= $out['servicenum']; ?>/<?= $out['serviceitem']; ?>" class="btn btn-danger">Remove</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button type="submit" class="btn bg-blue pull-right" id="btn-post" style="margin-left:5px;">
                                        <i class="material-icons">done_all</i> <span>CONFIRM</span>
                                    </button>
                                    <!-- <button type="button" id="btn-dlg-add-item" class="btn bg-blue pull-right">
                                        <i class="material-icons">playlist_add</i> <span>ADD COMPONENT</span>
                                    </button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            let detail_order_beli = [];
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;

            var servicenumber = "<?= $data['services']['servicenum']; ?>";


            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }
            

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
            });            

            $('#form-conf-service').on('submit', function(event){
                event.preventDefault();
                $("#btn-post").attr("disabled", true);
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/service/postconfirmservice',
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
                            showErrorMessage(JSON.stringify(err));
                            $("#btn-post").attr("disabled", false);
                        }
                    }).done(function(data){
                        // showSuccessMessage('Reservation Created '+ data)
                        if(data.msgtype === "1"){
                            showSuccessMessage('Service ' + servicenumber + ' Confirmed With Document Number '+ data.docnum)
                        }else if(data.msgtype === "3"){
                            showErrorMessage(data.data[0].message);
                            $("#btn-post").attr("disabled", false);
                        }else{
                            showErrorMessage(JSON.stringify(data.message));
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
                        window.location.href = base_url+'/service/confirm';
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