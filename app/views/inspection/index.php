    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <form action="<?= BASEURL ?>/inspection/save" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <button type="submit" class="btn bg-green waves-effect">
                                        <i class="material-icons">save</i> <span>SAVE</span>
                                    </button>
                                    <a href="<?= BASEURL; ?>/inspection/report" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>Data Inspection</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="idate">Tanggal</label>
                                        <input type="date" name="idate" id="idate" class="form-control"  required/>
                                        <input type="hidden" name="bomid" id="bomid">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="cusotmer">Customer</label>
                                        <input type="text" name="cusotmer" id="cusotmer" class="form-control"  required/>
                                    </div>                                    
                                    <div class="col-lg-6">
                                        <label for="assyno">Assy No</label>
                                        <input type="text" name="assyno" id="assyno" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="inspector">Nama Inspector</label>
                                        <select name="inspector" id="inspector" class="form-control">
                                            <?php foreach($data['userlist'] as $usr): ?>
                                                <option value="<?= $usr['username']; ?>"><?= $usr['username']; ?> - <?= $usr['nama']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="cctno">CCT No</label>
                                        <input type="text" name="cctno" id="cctno" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="operator">Nama Operator</label>
                                        <input type="text" name="operator" id="operator" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="jmlcheck">Jumlah Check</label>
                                        <input type="text" name="jmlcheck" id="jmlcheck" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="jmlng">Jumlah NG</label>
                                        <input type="text" name="jmlng" id="jmlng" class="form-control"  required/>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="lotng">LOT NG</label>
                                        <input type="text" name="lotng" id="lotng" class="form-control"  required/>
                                    </div>
                                </div>

                                <div class="row">    
                                    <div class="col-lg-6">
                                        <label for="nomeja">No Meja / Mesin</label>
                                        <select name="nomeja" id="nomeja" class="form-control" required>
                                            <option value="">Pilih No Meja / Menis</option>
                                            <option value="other">Lainnya...</option>
                                            <?php foreach($data['meja'] as $meja): ?>
                                                <option value="<?= $meja['deskripsi']; ?>"><?= $meja['deskripsi']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>    
                                    <div class="col-lg-6 mesinother">
                                        <label for="mesinother">-</label>
                                        <input type="text" name="mesinother" id="mesinother" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="Section">Section</label>
                                        <select name="section" id="section" class="form-control" required>
                                            <option value="">Pilih Section</option>
                                            <?php foreach($data['section'] as $act): ?>
                                                <option value="<?= $act['id']; ?>"><?= $act['section']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="process">Process</label>
                                        <div id="idprocess">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="jdefect">Jenis Defect</label>
                                        <div id="idjdefect">
                                        </div>
                                    </div>
                                </div>
                                <br><br><br>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

            <div class="modal fade" id="partModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="vendorModalLabel">Pilih Partnumber</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-part" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Part Number</th>
                                            <th>Part Name</th>
                                            <th>Customer</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>        
    </section>

    <script>
        $(function(){
            $("#mesinother").attr("required", false);
            $('.mesinother').hide();
            $('#nomeja').on('change', function(){
                if(this.value === "other"){
                    $('.mesinother').show();
                    $("#mesinother").attr("required", true);
                }else{
                    $('.mesinother').hide();
                    $("#mesinother").attr("required", false);
                }
            })
            $('#section').on('change',function(){
                var idsection = this.value;
                $('#idprocess').html('');
                $('#idjdefect').html('');
                $.ajax({
                    url: base_url+'/inspection/defectprocess/'+idsection,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        
                    }
                }).done(function(result){
                    var listitem = '';
                    listitem += `<select name="process" id="process" class="form-control" required>`;
                    for (var i = 0; i < result.length; i++) {
                        listitem += `<option class="form-control" value="`+ result[i].idprocess +`">`+ result[i].proses +`</option>`;
                    };
                    listitem += `</select>`;
                    $("#idprocess").append(listitem);

                    $('#process').on('change', function(){
                        // alert(this.value)
                    })   

                    appendDefect(idsection)                 
                });                
            });

            function appendDefect(idsection){
                
                $.ajax({
                    url: base_url+'/inspection/defectlist/'+idsection,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        
                    }
                }).done(function(result){
                    var listitem = '';
                    listitem += `<select name="jdefect" id="jdefect" class="form-control" required>`;
                    for (var i = 0; i < result.length; i++) {
                        listitem += `<option value="`+ result[i].idjenis +`">`+ result[i].alfabet +` - `+ result[i].jenisdefect +`</option>`;
                    };
                    listitem += `</select>`;
                    $("#idjdefect").append(listitem);

                    $('#jdefect').on('change', function(){
                        // alert(this.value)
                    })                    
                });  
            }
        })
    </script>