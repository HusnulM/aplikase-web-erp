    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <!-- PO Item -->
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
                                <a href="<?= BASEURL; ?>/exportdata/exportservice/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>" target="_blank" class="btn bg-blue">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a>

                                <a href="<?= BASEURL; ?>/reports/rservice" class="btn bg-blue">
                                   <i class="material-icons">backspace</i> BACK
                                </a>
                            </ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover" style="width:100%;font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>NO. Service</th>
                                            <th>Note</th>
                                            <th>Tanggal Service</th>
                                            <th>Mekanik</th>
                                            <th>No. Polisi</th>
                                            <th>Warehouse</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        
                                    </tfoot>
                                </table>
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
            var strdate = "<?= $data['strdate']; ?>";
            var enddate = "<?= $data['enddate']; ?>";
            var whs     = "<?= $data['whs']; ?>";

            function format ( d, results ) {
                console.log(results)
                var html = '';
                html = `<table class="table table-bordered table-striped" style="padding-left:50px;width:100%;">
                       
                       <tbody>`;
                for(var i = 0; i < results.length; i++){
                    var qty = '';
                    qty = results[i].quantity;
                    qty = qty.replaceAll('.00','');
                    qty = qty.replaceAll('.',',');
                    html +=`
                       <tr>
                            <td style="text-align:right;"> `+ results[i].serviceitem +` </td> 
                            <td> `+ results[i].material +` </td>                            
                            <td> `+ results[i].matdesc +` </td>
                            <td style="text-align:right;"> `+ formatRupiah(qty,'') +` </td>
                            <td> `+ results[i].unit +` </td>
                       </tr>
                       `;
                }

                html +=`</tbody>
                        </table>`;
                return html;
            }   

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

            var table = $('#example').DataTable( {
                "ajax": base_url+"/reports/rserviceheader/"+strdate+"/"+enddate+"/"+whs,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {"defaultContent": "<button class='btn btn-primary btn-xs'>Print</button>"},
                    { "data": "servicenum" },
                    { "data": "note" },
                    { "data": "servicedate" },
                    { "data": "mekanik" },
                    { "data": "nopol" },
                    { "data": "whsname" },
                    { "data": "servicestatus" }
                ],
                "order": [[1, 'asc']],
                "pageLength": 50,
                "lengthMenu": [50, 100, 200, 500]
            } );

            $('#example tbody').on( 'click', 'button', function () {
                var table = $('#example').DataTable();
                selected_data = [];
                selected_data = table.row($(this).closest('tr')).data();
                console.log(selected_data);

                window.open(base_url+"/service/printservice/"+selected_data.servicenum, '_blank');
            } ); 
            
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                
                // console.log(row.data())
                var d = row.data();
                $.ajax({
                    url: base_url+'/reports/rservicedetail/'+d.servicenum,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                    }
                }).done(function(data){
                    // return html;
                    // console.log(data)
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data(), data) ).show();
                        tr.addClass('shown');
                    }
                });
            } );
        })
    </script>