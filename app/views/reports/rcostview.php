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

                                <a href="<?= BASEURL; ?>/exportdata/exportcostreport/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>" target="_blank" class="btn bg-blue">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a>

                                <a href="<?= BASEURL; ?>/reports/rcost" class="btn bg-blue">
                                   <i class="material-icons">backspace</i> BACK
                                </a>
                            </ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped table-hover" style="width:100%;font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>NO. Service</th>
                                            <th>Note</th>
                                            <th>Tanggal Service</th>
                                            <th>Mekanik</th>
                                            <th>No. Polisi</th>
                                            <th>Warehouse</th>
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
                var grandtotal = 0;
                html = `<table class="table table-bordered table-striped" style="padding-left:50px;width:100%;">
                        <thead>
                            <th>Item</th>
                            <th>Material</th>
                            <th>Description</th>
                            <th>Batch Number</th>
                            <th style="text-align:right;">Quantity</th>
                            <th>Unit</th>
                            <th style="text-align:right;">Unit Price</th>
                            <th style="text-align:right;">Total Price</th>
                        </thead>
                        <tbody>`;
                        for(var i = 0; i < results.length; i++){
                            var qty = '';
                            var price = '';
                            var _totalprice = 0;
                            var _unitprice = 0;
                            qty   = results[i].quantity;
                            price = results[i].price;
                            qty   = qty.replace('.00','');
                            qty   = qty.replace('.',',');
                            qty   = qty.replace('.',',');
                            qty   = qty.replace('.',',');
                            qty   = qty.replace('.',',');
                            price = price.replace('.00','');
                            price = price.replace('.',',');
                            price = price.replace('.',',');
                            price = price.replace('.',',');
                            price = price.replace('.',',');
                            price = price.replace('.',',');

                            price = price.replace(',','.');

                            _unitprice  = price;
                            _totalprice = price*qty;
                            _totalprice = _totalprice.toString().replace('.',',');
                            _unitprice  = _unitprice.toString().replace('.',',');
                            html +=`
                            <tr>
                                    <td style="text-align:right;"> `+ results[i].resitem +` </td> 
                                    <td> `+ results[i].material +` </td>                            
                                    <td> `+ results[i].matdesc +` </td>
                                    <td> `+ results[i].batchnumber +` </td>
                                    <td style="text-align:right;"> `+ formatRupiah(qty,'') +` </td>
                                    <td> `+ results[i].unit +` </td>
                                    <td style="text-align:right;"> `+ formatRupiah(_unitprice,'') +` </td>
                                    <td style="text-align:right;"> `+ formatRupiah(_totalprice,'') +` </td>
                            </tr>
                            `;

                            grandtotal = grandtotal + (price*1)*(qty*1);
                        }

                        grandtotal = grandtotal.toFixed(2);

                        grandtotal = grandtotal.toString().replace('.',',');

                html +=`</tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7" style="text-align:right;"><b>Grand Total</b></td>
                                <td style="text-align:right;"><b>`+ formatRupiah(grandtotal,'') +`</b></td>
                            </tr>
                        </tfoot>
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
                "ajax": base_url+"/reports/rcostheader/"+strdate+"/"+enddate,
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { "data": "servicenum" },
                    { "data": "note" },
                    { "data": "servicedate" },
                    { "data": "mekanik" },
                    { "data": "nopol" },
                    { "data": "whsname" }
                ],
                "order": [[1, 'asc']],
                "pageLength": 50,
                "lengthMenu": [50, 100, 200, 500]
            } );
            
            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                
                console.log(row.data())
                var d = row.data();
                $.ajax({
                    url: base_url+'/reports/rcostdetail/'+d.servicenum,
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