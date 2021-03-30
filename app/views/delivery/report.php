<section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">     
                                    <a href="<?= BASEURL; ?>/delivery" class="btn bg-green waves-effect">
                                        <i class="material-icons">keyboard_arrow_left</i> <span>BACK</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">                                    
                                    <div class="col-lg-8 col-md-12 col-sm-12">
                                        <label for="partnumber">Part Number</label>
                                        <input type="text" name="partnumber" id="partnumber" class="form-control"  readonly="true" required/>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-search-part">
                                            <i class="material-icons">format_list_bulleted</i> <span>PILIH PART</span>
                                        </button>
                                    </div>       
                                    <div class="col-lg-2 col-md-6 col-sm-12">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-reset-part">
                                            <i class="material-icons">cached</i> <span>RESET</span>
                                        </button>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="idate1">Periode</label>
                                        <input type="date" name="idate1" id="idate1" class="form-control" value="<?php echo date('Y-m-d'); ?>" required/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="idate2">Periode</label>
                                        <input type="date" name="idate2" id="idate2" class="form-control" value="<?php echo date('Y-m-d'); ?>" required/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-show-data">
                                            <i class="material-icons">search</i> <span>TAMPILKAN DATA</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12 table-responsive">                                
                                        <table class="table table-bordered table-striped table-hover" id="delivery-list">
                                            <thead>
                                                <th>No.</th>
                                                <th>Part Number</th>
                                                <th>Periode</th>
                                                <!-- <th>Std Pack</th> -->
                                                <th>Quantity Request</th>
                                                <th>Quantity Delivery</th>
                                                <th>Balance</th>
                                            </thead>
                                        </table>
                                        <tbody id="tbl-content">
                                        
                                        </tbody>
                                        <button class="btn bg-blue form-control" type="button" id="btn-export-data">
                                            <i class="material-icons">file_download</i> <span>EXPORT DATA</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        $(document).ready(function(){
            var bomid = '*';

            $('#btn-export-data').hide();

            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            $('#btn-search-part').on('click', function(){
                $('#partModal').modal('show');
            });

            $('#btn-reset-part').on('click', function(){
                bomid = '*';
                $('#partnumber').val('')
            });

            $('#btn-export-data').on('click', function(){
                var strdate = $('#idate1').val();
                var enddate = $('#idate2').val();
                window.open(base_url+'/delivery/exportdata/'+strdate+'/'+enddate+'/'+bomid, '_blank');
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
                    // $('#bomid').val(selected_data.bomid);
                    bomid = selected_data.bomid;
                    $('#partnumber').val(selected_data.partnumber);
                    $('#partModal').modal('hide');
                    
                } );
            }

            $('#btn-show-data').on('click', function(){
                var strdate = $('#idate1').val();
                var enddate = $('#idate2').val();
                $('#btn-export-data').show();
                $('#delivery-list').dataTable({
                    "dom": 'lBfrtip',
                    "responsive": true,
                    "buttons": [
                        'copy', 'csv', 'pdf', 'print'
                    ],
                    "ajax": base_url+'/delivery/getdelivery/'+strdate+'/'+enddate+'/'+bomid,
                    "columns": [
                        { "data": "partnumber",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "partnumber" },
                        { "data": "deliverydate" },
                        // { "data": "stdpack", className: "text-right", 
                        //     render: $.fn.dataTable.render.number('.', ',', 0, '')
                        // },
                        { "data": "reqqty", className: "text-right", 
                            render: $.fn.dataTable.render.number('.', ',', 0, '')
                        },
                        { "data": "delqty", className: "text-right", 
                            render: $.fn.dataTable.render.number('.', ',', 0, '')
                        },
                        { "data": "balance", className: "text-right", 
                            render: $.fn.dataTable.render.number('.', ',', 0, '')
                        }
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true,
                    "pageLength": 50,
                    "lengthMenu": [50, 100, 200, 500]
                });
                // $('#tbl-content').html('');
            
                // $.ajax({
                //     url: base_url+'/delivery/getdelivery/'+strdate+'/'+enddate,
                //     type: 'GET',
                //     dataType: 'json',
                //     cache:false,
                //     success: function(result){    
                //         console.log(result)
                //     }
                // })
            })
            
            // function loaddatapart(){
            //     $('#list-part').dataTable({
            //         "ajax": base_url+'/quotation/partlist',
            //         "columns": [
            //             { "data": "partnumber" },
            //             { "data": "partname" },
            //             { "data": "customer" },
            //             {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
            //         ],
            //         "bDestroy": true,
            //         "paging":   true,
            //         "searching":   true
            //     });

            //     $('#list-part tbody').on( 'click', 'button', function () {
            //         var table = $('#list-part').DataTable();
            //         selected_data = [];
            //         selected_data = table.row($(this).closest('tr')).data();
                    
            //         console.log(selected_data);
            //         $('#bomid').val(selected_data.bomid);
            //         $('#partnumber').val(selected_data.partnumber);
            //         $('#partModal').modal('hide');
            //     } );
            // }
        })
    </script>