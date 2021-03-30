    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="msg-alert">
                        <?php
                            Flasher::msgInfo();
                        ?>
                    </div>
                    <div class="card">
                        <?php if($data['showcost']['rows'] == "1") : ?>
                            <div class="header">
                                <div class="table-responsive">
                                    <table >
                                        <tr>
                                            <td style="width:150px;">UPAH KERJA</td>
                                            <td style="width:200px;">
                                                <input type="text" class="form-class" id="upahkerja" value="<?= number_format($data['upah']['value'], 0, ',', '.'); ?>">
                                            </td>
                                            <td style="width:150px;">
                                                <button type="button" class="btn btn-primary" id="btn-update-upah">UPDATE UPAH</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php else : ?>
                            <input type="hidden" class="form-class" id="upahkerja">
                        <?php endif; ?>
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<!-- <a href="<?= BASEURL; ?>/bom/create" class="btn btn-success waves-effect pull-right">Create BOM</a> -->
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="prlist"></table>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Part Number</th>
                                            <th>Part Name</th>
                                            <th>Customer</th>
                                            <th style="text-align:right;">Qty CCT</th>
                                            <th>Reference</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['partlist'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['partnumber']; ?></td>
                                                <td><?= $out['partname']; ?></td>
                                                <td><?= $out['customer']; ?></td>
                                                <td style="text-align:right;">
                                                    <?php if (strpos($out['qtycct'], '.00') !== false) {
                                                        echo number_format($out['qtycct'], 0, ',', '.');
                                                    }else{
                                                        echo number_format($out['qtycct'], 2, ',', '.');
                                                    } ?>   
                                                </td>
                                                <td><?= $out['reference']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/cost/detail/<?= $out['bomid']; ?>" type="button" class="btn btn-success">Cost Process</a>

                                                    <a href="<?= BASEURL; ?>/cost/calculate/<?= $out['bomid']; ?>" type="button" class="btn btn-primary">Cost Calculation</a>
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
        $(function(){
            $('#btn-update-upah').on('click', function(){
                var newkurs = $('#upahkerja').val();
                $.ajax({
                    url: base_url+'/cost/updateupah/'+newkurs,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        showSuccessMessage("Upah Kerja Berhasil di Update");
                    }
                });  
            });

            var harga  = document.getElementById('upahkerja');

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
            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/cost';
                    }
                );
            }
        })
    </script>