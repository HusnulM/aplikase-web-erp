
<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Total Payment Report
                            </h2>
                            
                            <ul class="header-dropdown m-r--5">                                
                            <a href="<?= BASEURL; ?>/reports/totalpayment" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>

                        <?php $gtotal = 0; ?>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="tbl-report" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>PR Number</th>
                                            <th>PO Number</th>
                                            <th>Vendor</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Receipt Num</th>
                                            <th>Receipt Date</th>
                                            <th>Project</th>
                                            <th>Akun Bank</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['pdata'] as $pdata) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $pdata['prnum']; ?></td>
                                                <td><?= $pdata['ponum']; ?></td>
                                                <td><?= $pdata['nmsup']; ?></td>
                                                <td><?= $pdata['namabrg']; ?></td>
                                                <td><?= $pdata['quantity']; ?></td>
                                                <td><?= $pdata['unit']; ?></td>
                                                <td><?= number_format($pdata['price']); ?></td>
                                                <td><?= number_format($pdata['totalprice']); ?></td>
                                                <td><?= $pdata['refdoc']; ?></td>
                                                <td><?= $pdata['tglterima']; ?></td>
                                                <td><?= $pdata['project']; ?></td>
                                                <td><?= $pdata['bankacc']; ?></td>
                                            </tr>

                                            <?php $gtotal = $gtotal + $pdata['totalprice']; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Grand Total</th>
                                            <th id='gtotal'><?= number_format($gtotal); ?></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    <script>
        $(function(){
            jQuery.fn.dataTable.Api.register( 'sum()', function () {
                return this.flatten().reduce( function ( a, b ) {
                    
                    var ival1 = a.toString();
                    var ival2 = b.toString();

                    var val1 = ival1.split(',');  
                    var oval1 = 0;
                    for(var x=0; x < val1.length; x++){
                        oval1 = oval1+''+val1[x];
                    }

                    var val2 = ival2.split(',');  
                    var oval2 = 0;
                    for(var y=0; y < val2.length; y++){
                        oval2 = oval2+''+val2[y];
                    }
                    
                    return (oval1*1) + (oval2*1); 
                });
            });

            var table = $("#tbl-report").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $("#tbl-report").on('search.dt', function() {
                console.log(table.column( 8, {page:'current'} ).data().sum() );
                $('#gtotal').html(formatRupiah(table.column( 8, {page:'current'} ).data().sum(),''))
            });

            function formatRupiah(angka, prefix){
                var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                split   		  = number_string.split(','),
                sisa     		  = split[0].length % 3,
                rupiah     		  = split[0].substr(0, sisa),
                ribuan     		  = split[0].substr(sisa).match(/\d{3}/gi);
            
                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if(ribuan){
                    separator = sisa ? ',' : '';
                    rupiah += separator + ribuan.join(',');
                }
            
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }
        })
    </script>