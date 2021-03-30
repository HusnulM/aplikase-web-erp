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
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
							
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/material/create" class="btn btn-success waves-effect pull-right">Create Material</a>
							</ul>
                        </div>
                        <?php if($data['showprice']['rows'] == "1") : ?>
                            <div class="header">
                                <div class="table-responsive">
                                    <table >
                                        <tr>
                                            <td style="width:150px;">Kurs USD - IDR</td>
                                            <td style="width:200px;">
                                                <input type="text" class="form-class" id="kursvalue" value="<?= number_format($data['kurs']['kurs'], 0, ',', '.'); ?>">
                                            </td>
                                            <td style="width:150px;">
                                                <button type="button" class="btn btn-primary" id="btn-update-kurs">UPDATE KURS</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php else : ?>
                            <input type="hidden" class="form-class" id="kursvalue">
                        <?php endif; ?>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Material</th>
                                            <th>Deskripsi</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <?php if($data['showprice']['rows'] == "1") : ?>
                                            <th>Unit Price</th>
                                            <th>Unit Price (USD)</th>
                                            <?php endif; ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['material'] as $barang) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $barang['material']; ?></td>
                                                <td><?= $barang['matdesc']; ?></td>
                                                <td><?= $barang['partname']; ?></td>
                                                <td><?= $barang['partnumber']; ?></td>
                                                <?php if($data['showprice']['rows'] == "1") : ?>

                                                    <?php if($barang['stdpriceusd'] > 0) : ?>
                                                        <td>
                                                            <?= number_format($barang['stdpriceusd']*$barang['curs'], 0, ',', '.'); ?>
                                                        </td>

                                                        <td>
                                                            <?= number_format($barang['stdpriceusd'], 4, ',', '.'); ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td>
                                                            <?= number_format($barang['stdprice'], 0, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                            <?= number_format($barang['stdpriceusd'], 4, ',', '.'); ?>
                                                        </td>
                                                    <?php endif; ?>
                                                    
                                                <?php endif; ?>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/material/edit/data?material=<?= $barang['material']; ?>" type="button" class="btn btn-success">Edit</a>
                                                    <a href="<?= BASEURL; ?>/material/delete/data?material=<?= $barang['material']; ?>" type="button" class="btn btn-danger">Hapus</a>
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
            $('#btn-update-kurs').on('click', function(){
                var newkurs = $('#kursvalue').val();
                $.ajax({
                    url: base_url+'/material/updatekursusdidr/'+newkurs,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        showSuccessMessage("Kurs Berhasil di Update");
                    }
                });  
            });

            var harga  = document.getElementById('kursvalue');

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
                        window.location.href = base_url+'/material';
                    }
                );
            }
        })
    </script>