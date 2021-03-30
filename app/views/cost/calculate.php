    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-cost-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">          
							    <a href="<?= BASEURL; ?>/cost" class="btn btn-primary waves-effect">BACK</a>
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
                                                <input type="text" name="partname" id="partname" class="form-control" placeholder="Part Name" value="<?= $data['bomhead']['partname']; ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="customer">Customer Name</label>
                                                <input type="text" name="customer" id="customer" class="form-control" placeholder="Customer" value="<?= $data['bomhead']['customer']; ?>" required readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="qtycct">Quantity CCT</label>
                                                <input type="number" name="qtycct" id="qtycct" class="form-control" value="<?= number_format($data['bomhead']['qtycct'], 0, ',', '.'); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="header">
                            <h2>
                                Cost Process
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;">No</th>
                                                <th>ID Process</th>
                                                <th>Process</th>
                                                <th style="width:80px;">Quantity</th>
                                                <th style="width:100px;">Cycle Time</th>
                                                <th style="width:130px;">Total Cycle Time</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">

                                        </tbody>
                                        <tfoot id="tbl-pr-footer">
                                            <tr>
                                                <td colspan="5" style="text-align:right;"> 
                                                    <h5>Total Waktu Process (detik)</h5>
                                                </td>
                                                <td style="text-align:right;"> 
                                                    <h5><?= number_format($data['totalwaktu'], 2, ',', '.'); ?></h5>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" style="text-align:right;"> 
                                                    <h5>Total Waktu Process (jam)</h5>
                                                </td>
                                                <td style="text-align:right;"> 
                                                    <h5><?= number_format($data['totalwaktu']/3600,4,',','.'); ?></h5>
                                                </td>
                                            </tr>
                                            <?php if($data['showcost']['rows'] > 0): ?>
                                            <tr>
                                                <td colspan="5" style="text-align:right;"> 
                                                    <h5>Upah Pekerja : <?= number_format($data['upah'],0,',','.'); ?></h5>
                                                </td>
                                                <td style="text-align:right;"> 
                                                    <h5><?= number_format($data['upah']/20/8,0,',','.'); ?></h5>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td colspan="5" style="text-align:right;"> 
                                                    <h5>Total Cost</h5>
                                                </td>
                                                <td style="text-align:right;"> 
                                                    <h5><?= number_format($data['totalcost'],2,',','.'); ?></h5>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <ul class="pull-right">    
                                        <!-- <button type="button" id="btn-dlg-add-item" class="btn bg-blue hideComponent">
                                            <i class="material-icons">playlist_add</i> <span>ADD PROCESS</span>
                                        </button>

                                        <button type="submit" class="btn bg-blue hideComponent" id="btn-post">
                                            <i class="material-icons">save</i> <span>SAVE</span>
                                        </button> -->
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
                            <h4 class="modal-title" id="barangModal">Pilih Process</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-activity" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Process</th>
                                            <th>Cycle Time</th>
                                            <th>Cycle Unit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
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
        
        $(function(){
            var kodebrg           = '';
            var namabrg           = '';
            var action            = '';
            var imgupload         = [];
            var count = 0;
            var bomid   = "<?= $data['bomid']; ?>";       
            var costdtl = <?= $data['costdtl']; ?>;    
            
            appendCostItem();
            function appendCostItem(){
                for(var i = 0; i < costdtl.length; i++){
                    addCostItem(costdtl[i].id,costdtl[i].activity,costdtl[i].quantity,costdtl[i].cycletime);
                }
            }

            loadactivity();
            function loadactivity(){
                $('#list-activity').dataTable({
                    "ajax": base_url+'/activity/getActivityList',
                    "columns": [
                        { "data": "id" },
                        { "data": "activity" },
                        { "data": "cycletime" },
                        { "data": "cycvleunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-activity tbody').on( 'click', 'button', function () {
                    var table = $('#list-activity').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    addCostItem(selected_data.id,selected_data.activity,0,selected_data.cycletime);
                } );
            }

            function addCostItem(activityid,activity,quantity,cycletime){
                var totaltime = (quantity*cycletime).toFixed(2);
                var stotaltime = '';
                var _inpqty    = '';
                _inpqty    = quantity.toString();
                stotaltime = totaltime.toString();
                stotaltime = stotaltime.replace('.',',');
                _inpqty    = _inpqty.replace('.00','');
                _inpqty    = _inpqty.replace('.',',');
                count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                            </td>
                            <td>
                                `+ activityid +`
                            </td>
                            <td> 
                                `+ activity +`
                            </td>
                            <td style="text-align:right;"> 
                                `+ _inpqty +`
                            </td>
                            <td style="text-align:right;"> 
                                `+ cycletime.replaceAll('.',',') +`
                            </td>
                            <td style="text-align:right;"> 
                                `+ stotaltime +`
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

                    $('.inputNumber').on('change', function(){
                        var selcounter = $(this).attr('counter');
                        this.value = formatRupiah(this.value, '');
                        var totalcycle = '0';
                        var inputqty = '';

                        inputqty = this.value.replaceAll(',','.');
                        var cylcevalue = $('#cycle'+selcounter).val();
                        cylcevalue = cylcevalue.replaceAll(',','.');

                        totalcycle = (inputqty*1) * (cylcevalue*1);

                        $('#totalcyle'+selcounter).val(totalcycle.toFixed(2));
                    })
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

            $('#form-cost-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/cost/save',
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
                        window.location.href = base_url+'/cost';
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