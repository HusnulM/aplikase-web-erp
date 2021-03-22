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
                                <a href="<?= BASEURL; ?>/reports/rservice" class="btn bg-blue">
                                   <i class="material-icons">backspace</i> BACK
                                </a>
                            </ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover" style="width:100%;font-size: 12px; font-weight:bold;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Invoice</th>
                                            <th>Tanggal Invoice</th>
                                            <th>Ketrangan</th>
                                            <th>Vendor</th>
                                            <th>No. Rekening</th>
                                            <th>Total Invoice</th>
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

            function format ( d, results ) {
                console.log(results)
                var html = '';
                html = `<table class="table table-bordered table-striped" style="padding-left:50px;width:100%;">
                       <thead>
                            <th>Item</th>
                            <th>PO. Num</th>
                            <th>PO Item</th>
                            <th>Material</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total Price</th>
                       </thead>
                       <tbody>`;
                for(var i = 0; i < results.length; i++){
                    var qty   = '';
                    var price = '';
                    var disc  = '';
                    var totalprice = '';
                    
                    qty        = results[i].quantity;
                    price      = results[i].price;
                    disc       = results[i].discount;
                    totalprice = results[i].totalprice;

                    qty = qty.replace('.00','');
                    qty = qty.replace('.',',');
                    qty = qty.replace('.',',');

                    price = price.replace('.00','');
                    price = price.replace('.',',');
                    price = price.replace('.',',');
                    price = price.replace('.',',');

                    disc = disc.replace('.00','');
                    disc = disc.replace('.',',');
                    disc = disc.replace('.',',');
                    disc = disc.replace('.',',');
                    
                    totalprice = totalprice.replace('.00','');
                    totalprice = totalprice.replace('.',',');
                    totalprice = totalprice.replace('.',',');
                    totalprice = totalprice.replace('.',',');
                    totalprice = totalprice.replace('.',',');

                    html +=`
                       <tr>
                            <td style="text-align:right;"> `+ results[i].ivitem +` </td> 
                            <td> `+ results[i].ponum +` </td>                     
                            <td> `+ results[i].poitem +` </td>                     
                            <td> `+ results[i].material +` </td>                            
                            <td> `+ results[i].matdesc +` </td>
                            <td style="text-align:right;"> `+ formatRupiah(qty,'') +` </td>
                            <td> `+ results[i].unit +` </td>
                            <td style="text-align:right;"> `+ formatRupiah(price,'') +` </td>
                            <td style="text-align:right;"> `+ formatRupiah(disc,'') +` </td>
                            <td style="text-align:right;"> `+ results[i].ppn +`% </td>
                            <td style="text-align:right;"> `+ formatRupiah(totalprice,'') +` </td>
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
                "ajax": base_url+"/reports/rpaymentheader/"+strdate+"/"+enddate,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "ivnum" },
                    { "data": "ivdate" },
                    { "data": "note" },
                    { "data": "namavendor" },
                    { "data": "bankacc" },
                    { "data": "total_invoice", "className": 'text-right', 
                        render: function(data, type, row){
                            data = data.replace('.00','');
                            data = data.replace('.',',');
                            data = data.replace('.',',');
                            data = data.replace('.',',');
                            
                            return formatRupiah(data,'');
                        }
                    },
                    { "data": "ivstat" }
                ],
                "order": [[1, 'asc']],
                "pageLength": 50,
                "lengthMenu": [50, 100, 200, 500]
            } );
            
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                
                // console.log(row.data())
                var d = row.data();
                $.ajax({
                    url: base_url+'/reports/rpaymentdetail/'+d.ivnum,
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