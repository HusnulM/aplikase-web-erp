<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Report Stock Material
                            </h2>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">Material</label>
                                                <input type="text" name="material" id="material" class="form-control">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">-</label>
                                                <button type="button" class="btn btn-primary form-control" id="btn-sel-material">Select Material</button>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">Select Warehouse</label>
                                                <select name="warehouse" id="warehouse" class="form-control">
                                                    <option value="">ALL</option>
                                                    <?php foreach($data['whs'] as $out) : ?>
                                                    <option value="<?= $out['gudang']; ?>"><?= $out['gudang']; ?> - <?= $out['deskripsi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <button type="button" id="btn-process" class="btn btn-primary"  data-type="success">Show Data</button>
                                        </div>    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="barangModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="barangModal">Select Material</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-barang" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Description</th>
                                            <th>Part Name</th>
                                            <th>Part Number</th>
                                            <th>Unit</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            
            loaddatabarang();
            function loaddatabarang(){
                $('#list-barang').dataTable({
                    "ajax": base_url+'/barang/listbarang',
                    "columns": [
                        { "data": "material" },
                        { "data": "matdesc" },
                        { "data": "partname" },
                        { "data": "partnumber" },
                        { "data": "matunit" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-barang tbody').on( 'click', 'button', function () {
                    var table = $('#list-barang').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    $('#material').val(selected_data.material);
                    $('#barangModal').modal('hide');
                } );
            }

            $('#btn-sel-material').on('click', function(){
                $('#barangModal').modal('show');
            })

            $('#btn-process').on('click', function(){
                if($('#material').val() === "" && $('#warehouse').val() === ""){
                    window.location.href = base_url+'/reports/stockview';    
                }else if($('#material').val() != "" && $('#warehouse').val() === ""){
                    window.location.href = base_url+'/reports/stockview/'+$('#material').val()
                }else if($('#material').val() === "" && $('#warehouse').val() != ""){
                    window.location.href = base_url+'/reports/stockview/null/'+$('#warehouse').val();
                }
                else{
                    window.location.href = base_url+'/reports/stockview/'+$('#material').val()+'/'+$('#warehouse').val();
                }
                // window.location.href = base_url+'/reports/stockview/null/'+$('#warehouse').val();    
            })
        })
    </script>