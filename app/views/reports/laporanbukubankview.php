
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Laporan Buku Bank
                            </h2>
                            
                            <ul class="header-dropdown m-r--5">                                
                            <a href="<?= BASEURL; ?>/reports/bukubank" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>

                        <?php $gtotal = 0; ?>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="tbl-data-setoran" class="table table-bordered table-hover">
                                    <thead>
                                        <th>No Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Deskripsi</th>
                                        <th style="display:none;">No Rekening</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo</th>
                                        <th>Post By</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['data'] as $pdata) : ?>
                                            <tr>
                                                <td><?= $pdata['transnum']; ?></td>
                                                <td><?= $pdata['transdate']; ?></td>
                                                <td><?= $pdata['note']; ?></td>
                                                <td style="display:none;"><?= $pdata['group']; ?></td>
                                                <td><?= number_format($pdata['debet'],2); ?></td>
                                                <td><?= number_format($pdata['kredit'],2); ?></td>
                                                <td><?= number_format($pdata['saldo'],2); ?></td>
                                                <td><?= $pdata['createdby']; ?></td>
                                                <td>
                                                    <button class="btn btn-success" onclick="showfile('<?= $pdata['transnum']; ?>')" data-docno="123">Lihat File</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
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
        var strdate = "<?= $data['strdate']; ?>";
        var enddate = "<?= $data['enddate']; ?>";

        function showfile(param){
            $.ajax({
                url: base_url+'/setoran/getfile/'+param,
                type: 'GET',
                dataType: 'json',
                cache:false,
                success: function(result){
                    console.log(result)
                    if(result.act == 'py'){
                        if(result.filename == ''){
                            showErrorMessage('Tidak ada file!');
                        }else{
                            window.open(base_url+"/images/grfile/"+result.filename, '_blank');
                        }
                    }else if(result.act == 'st'){
                        if(result.efile == ''){
                            showErrorMessage('Tidak ada file!');
                        }else{
                            window.open(base_url+"/images/setoran/"+result.efile, '_blank');
                        }
                    }
                }
            });
        }

        function showErrorMessage(message){
            swal("", message, "warning");
        }

        $(function(){

            $('#tbl-data-setoran').DataTable( {
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                order: [[3,0, 'asc']],
                rowGroup: {
                    endRender: function ( rows, group ) {
                        var data  = [];
                        var rdata = [];
                        rdata = rows.data()
                        data  = rows.data()[rdata.length-1];
                        
                        console.log(data[6]);
                        return $('<tr>')
                            .append( '<td colspan="5" align="right"><b>Saldo Akhir</b></td>' )
                            .append( '<td><b>'+ data[6] +'</b></td>' )
                            .append( '<td></td>')
                            .append( '<td></td></tr>' );                        
                    },
                    dataSrc: 3
                }
            } );
            // $('#tbl-data-setoran').DataTable( {
            //     ajax: base_url+'/reports/getMutasiReport/'+strdate+'/'+enddate,
            //     columns: [
            //         { data: 'transnum' },
            //         { data: 'transdate' },
            //         { data: 'note' },
            //         { data: 'frombankacc' },
            //         { data: 'debet' },
            //         { data: 'kredit' },
            //         { data: 'saldo' },
            //         { data: 'createdby' }
            //     ],
            //     order: [[7, 'asc']],
            //     rowGroup: {
            //         startRender: null,
            //         endRender: function ( rows, group ) {
            //             console.log(rows);
            //             return $('<tr/>')
            //                 .append( '<td colspan="3">'+group+'</td>' )
            //                 .append( '<td></td>' )
            //                 .append( '<td></td>' )
            //                 .append( '<td>Saldo Akhir</td>' )
            //                 .append( '<td>10000000</td>' )
            //                 .append( '<td></td>' );
            //         },
            //         dataSrc: 'createdby'
            //     }
            // } );

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