    <section class="content">
        <div class="container-fluid">
            <!-- <form id="form-po-data" action="<?= BASEURL; ?>/quotation/save" method="POST" enctype="multipart/form-data"> -->
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <button type="button" id="btn-generate" class="btn bg-green waves-effect">
                                        <i class="material-icons">save</i> <span>GENERATE QUOTATION</span>
                                    </button>

                                    <a href="<?= BASEURL ?>/quotation" type="button" id="btn-cancel" class="btn bg-red">
                                        <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <!-- <div class="form-group"> -->
                                        <div class="col-lg-10">
                                            <label for="partnumber">Part Number</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control"  readonly="true" required/>
                                            <input type="hidden" name="bomid" id="bomid">
                                        </div>
                                        <div class="col-lg-2">
                                            <br>
                                            <button class="btn bg-blue form-control" type="button" id="btn-search-part">
                                                <i class="material-icons">format_list_bulleted</i> <span>PILIH PART</span>
                                            </button>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="partname">Part Name</label>
                                            <input type="text" name="partname" id="partname" class="form-control"  readonly="true" required/>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="customer">Customer</label>
                                            <input type="text" name="customer" id="customer" class="form-control"  readonly="true" required/>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="qtycct">Qty CCT</label>
                                            <input type="text" name="qtycct" id="qtycct" class="form-control"  readonly="true" required/>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="qdate">Quotation Date</label>
                                            <input type="date" name="qdate" id="qdate" class="form-control" required value="<?= date('m-d-Y'); ?>"/>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="profit">Profit & Overhead</label>
                                            <input type="text" name="profit" id="profit" class="form-control" required value="0"/>
                                        </div>
                                        <div class="col-lg-2">
                                            <br>
                                            <input type="checkbox" id="basic_checkbox_2" class="filled-in form-control"/>
                                            <label for="basic_checkbox_2">Persentage</label>
                                        </div>
                                        
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </form> -->
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
        var vendor            = '';
        var namavendor        = '';
        

        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });

        $(document).ready(function(){
            var count = 0;            
            var _ppnchecked =     'N';
            $('#basic_checkbox_2').on('change', function(){
                if(_ppnchecked === 'N'){
                    _ppnchecked = 'Y'
                }else{
                    _ppnchecked = 'N'
                }
                // alert(_ppnchecked)
            });

            $('#btn-search-part').on('click', function(){
                $('#partModal').modal('show');
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
                    $('#partname').val(selected_data.partname);
                    $('#customer').val(selected_data.customer);
                    $('#qtycct').val(selected_data.qtycct.replaceAll('.00',''));
                    $('#partModal').modal('hide');
                } );
            }

            $('#btn-generate').on('click', function(){
                var bomid  = $('#bomid').val();
                var qdate  = $('#qdate').val();
                var profit = $('#profit').val();
                window.open(base_url+"/quotation/generatequotation/"+bomid+"/"+qdate+"/"+profit+"/"+_ppnchecked, '_blank');
            });

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/quotation';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }

            $("#profit"+count).keydown(function(event){
                if(event.keyCode == 190) {
                    event.preventDefault();
                        showErrorMessage("Untuk decimal separator gunakan ( , )")
                        return false;
                }
            });

            var harga  = document.getElementById('profit');

            harga.addEventListener('keyup', function(e){
                harga.value = formatRupiah(this.value, '');
            });

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
        })
    </script>