    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/reports/wostracking" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>WOS ID</th>
                                                <th>Customer</th>
                                                <th>Part Number</th>
                                                <th>Quantity</th>
                                                <th>WP Number</th>
                                                <th>Circuit</th>
                                                <th>Lot Number</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['wosdata'] as $prdata) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $prdata['id']; ?></td>
                                                    <td><?= $prdata['customer']; ?></td>
                                                    <td><?= $prdata['partnumber']; ?></td>
                                                    <td style="text-align:right;"><?= $prdata['quantity']; ?></td>
                                                    <td><?= $prdata['wpnumber']; ?></td>
                                                    <td><?= $prdata['circuitno']; ?></td>
                                                    <td><?= $prdata['lotng']; ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btnViewTracking" data-wosid="<?= $prdata['id']; ?>" data-bomid="<?= $prdata['bomid']; ?>">View Tracking</button>
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
        </div>

        <div class="modal fade" id="wosTrackingModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">WOS Process History</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table table-bordered table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Process ID</th>
                                        <th>Part Number</th>
                                        <th>Area</th>
                                        <th>Process</th>
                                        <th>Operator</th>
                                        <th>Tanggal Process</th>
                                        <th>Customer</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-wos-tracking">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function(){
            $('.btnViewTracking').on('click', function(){
                var data = $(this).data();
                console.log(data)
                $('#tbl-wos-tracking').html('');

                $.ajax({
                    url: base_url+'/reports/getwostracking/'+data.wosid+'/'+data.bomid,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        
                    }
                }).done(function(result){
                    console.log(result)
                    $('#wosTrackingModal').modal('show');
                    var icount = 0;
                    for(var i = 0; i < result.length; i++){
                        icount = icount + 1;
                        $('#tbl-wos-tracking').append(`
                            <tr>
                                <td style="text-align:right;">`+result[i].processid+`</td>
                                <td>`+result[i].partnumber+`</td>
                                <td>`+result[i].nmmeja+`</td>
                                <td>`+result[i].process+`</td>
                                <td>`+result[i].operator+`</td>
                                <td>`+result[i].createdon+`</td>
                                <td>`+result[i].customer+`</td>
                            </tr>
                        `);
                    }
                });
            });
        })
    </script>