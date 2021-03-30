    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">    
                                <button type="button" id="btn-calculate" class="btn bg-blue">
                                    <i class="material-icons">chrome_reader_mode</i> <span>CALCULATE BOM</span>
                                </button>
                                <a href="<?= BASEURL; ?>/bom" class="btn bg-red">
                                    <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                </a>
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
                                                <input type="text" name="partname" id="partname" class="form-control" placeholder="Part Name" readonly value="<?= $data['bomhead']['partname']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="customer">Customer Name</label>
                                                <input type="text" name="customer" id="customer" class="form-control" readonly placeholder="Customer" value="<?= $data['bomhead']['customer']; ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="qtycct">Quantity CCT</label>
                                                <input type="number" name="qtycct" id="qtycct" class="form-control"  readonly value="<?= number_format($data['bomhead']['qtycct'], 0, ',', '.'); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="inpqty">Quantity Planning</label>
                                                <input type="number" name="inpqty" id="inpqty" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="strdate">Tanggal</label>
                                                <input type="date" name="strdate" id="strdate" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="enddate">-</label>
                                                <input type="date" name="enddate" id="enddate" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="card hideComponent">
                        <div class="header">
                            <h2>
                                Components
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <!-- <div>
                                    Kurs Info : 
                                    <p> <b> 1 USD = <?= number_format($data['kursusdidr']['kurs2'], 0, ',', '.'); ?> IDR </b></p>
                                </div> -->
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Component</th>
                                                <th style="text-align:right;">Quantity</th>
                                                <th>Unit</th>
                                                <?php if($data['showprice']['rows'] > 0): ?>
                                                <th>Unit Price</th>
                                                <th>Total Price (IDR)</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl-pr-body" class="mainbodynpo">

                                        </tbody>
                                        <tfoot id="tbl-pr-footer">
                                        </tfoot>
                                    </table>
                                    <ul class="pull-right">    
                                        <button type="button" id="btn-convert-bom" class="btn bg-blue">
                                            <i class="material-icons">add_shopping_cart</i> <span>CONVERT BOM TO PR</span>
                                        </button>
                                        <button type="button" id="btn-export" class="btn bg-blue">
                                            <i class="material-icons">cloud_download</i> <span>EXPORT DATA</span>
                                        </button>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {

            var bomid = "<?= $data['bomid']; ?>";
            var kurs  = <?= $data['kurs']; ?>;

            var showprice = <?= $data['showprice']['rows']; ?>;
            // alert(showprice)
            console.log(kurs)
            $('.hideComponent').hide();

            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            $('#btn-calculate').on('click', function(){
                var strdate = $('#strdate').val();
                var enddate = $('#enddate').val();
                if($('#inpqty').val() === ""){
                    showErrorMessage("Masukkan Quantity Planning");
                }else if(strdate === "" || enddate === ""){
                    showErrorMessage("Masukkan Periode Planning");
                }else{
                    calculatebom();
                    $('.hideComponent').show();
                }
            });

            $('#btn-export').on('click', function(){
                var strdate = $('#strdate').val();
                var enddate = $('#enddate').val();
                var qtycct  = $('#qtycct').val();
                window.open(base_url+"/bom/exportbom/"+bomid+'/'+$('#inpqty').val()+'/'+strdate+'/'+enddate+'/'+qtycct, '_blank');
            });

            $('#btn-convert-bom').on('click', function(){
                $.ajax({
                    url: base_url+'/bom/convertbomtopr/'+bomid+'/'+$('#inpqty').val(),
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result);
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message + ' ' + result.prnum);
                    }else{
                        showErrorMessage(result.message);
                    }
                });                 
            })

            function showErrorMessage(message){
                swal("", message, "warning");
            };

            function showSuccessMessage(message){
                swal("", message, "success");
            };

            function calculatebom(){
                var count = 0;
                var kursusdidr = kurs['kurs2'];

                $('#tbl-pr-body').html('');
                $.ajax({
                    url: base_url+'/bom/bomcalculation/'+bomid+'/'+$('#inpqty').val(),
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        var totalprice = 0;
                        for(var i = 0; i < result.length; i++){
                            var bomqty   = '0';
                            var totalidr = '0';
                            var stprice  = '0';

                            bomqty = result[i].quantity.replaceAll('.00','');
                            bomqty = bomqty.replaceAll('.',',');
                            
                            stdprice = result[i].stdprice;

                            if(result[i].stdpriceusd > 0){
                                totalidr = (result[i].stdpriceusd*kursusdidr)*result[i].quantity;
                                stdprice = result[i].stdpriceusd*kursusdidr;
                            }else{
                                totalidr = result[i].stdprice*result[i].quantity;
                                stdprice = result[i].stdprice.replaceAll('.00','')
                            }

                            totalprice = totalprice + totalidr;

                            if(stdprice == null || stdprice == "null"){
                                stdprice = 0;
                            }

                            console.log(stdprice)

                            count=count+1;
                            html = '';

                            if(showprice > 0){
                                html = `
                                    <tr counter="`+ count +`" id="tr`+ count +`">
                                        <td> 
                                            `+ count +`
                                        </td>
                                        <td> 
                                            `+ result[i].component +`
                                        </td>
                                        <td style="text-align:right;"> 
                                            `+ bomqty +`
                                        </td>
                                        <td>
                                            `+ result[i].unit +`
                                        </td>
                                        <td style="text-align:right;">
                                            `+ formatRupiah(stdprice,'') +`
                                        </td>
                                        <td style="text-align:right;"> 
                                            `+ formatRupiah(totalidr.toFixed(0),'') +`
                                        </td>
                                    </tr>
                                `;
                            }else{
                                html = `
                                    <tr counter="`+ count +`" id="tr`+ count +`">
                                        <td> 
                                            `+ count +`
                                        </td>
                                        <td> 
                                            `+ result[i].component +`
                                        </td>
                                        <td style="text-align:right;"> 
                                            `+ bomqty +`
                                        </td>
                                        <td>
                                            `+ result[i].unit +`
                                        </td>
                                    </tr>
                                `;
                            }
                            
                            
                            $('#tbl-pr-body').append(html);
                        }

                        if(showprice > 0){
                            html = '';
                            html = `
                                    <tr>
                                        <td colspan="5" style="text-align:right;"> 
                                            Total Price
                                        </td>
                                        <td style="text-align:right;"> 
                                            `+ formatRupiah(totalprice,'') +`
                                        </td>
                                    </tr>
                                `;
                            $('#tbl-pr-footer').append(html);
                        }
                    }
                }); 

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
        });
    </script>