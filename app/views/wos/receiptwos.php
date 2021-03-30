    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>
                            </div>
                            <div class="body">
                                <div class="row">                                    
                                    <div class="col-lg-4" style="margin-bottom:0px;">
                                        <label for="reffid">SCAN / INPUT REFF ID</label>
                                        <input type="text" name="reffid" id="reffid" class="form-control" autocomplete="off" required/>

                                        <button type="button" class="btn btn-primary form-control" id="btn-scan-qr" style="margin-top:10px;">SCAN QR CODE</button>
                                    </div>     
                                    <div class="col-lg-4 hideComponent" style="margin-bottom:0px;">
                                        <br>
                                        <button type="button" id="btn-close-wos" class="btn bg-blue">
                                        <i class="material-icons">done</i> <span>INPUT QUANTITY NG</span>
                                        </button>
                                    </div>                        
                                </div>  
                                <hr class="hideComponent" style="margin-bottom:0px;">     
                                <div class="row hideComponent">
                                    <div class="col-lg-12" style="margin-bottom:0px;">
                                        <table class="table table-stripped">
                                            <thead>
                                                <th>PART NUMBER</th>
                                                <th>WP NUMBER</th>
                                                <th>LOT NUMBER</th>
                                                <th>QUANTITY</th>
                                                <th>START DATE</th>
                                                <th>END DATE</th>
                                            </thead>
                                            <tbody id="tbl-wos-data">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                        
                                <div class="row hideComponent">
                                    <div class="col-lg-12">
                                        <img alt="WOS-IMAGE" class="img-fluid wos-image" width="100%;">
                                    </div>
                                </div>
                                <hr class="hideComponent">     
                            </div>
                        </div>
                    </div>
                </div>
        </div>     

            <div class="modal fade" id="inspectionModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <form id="form-post-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Inspection Entry</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="jmlng">Jumlah NG</label>
                                                    <input type="number" name="jmlng" id="jmlng" class="form-control" value="0" required/>
                                                </div>
                                            </div>

                                            <div class="row hideNG">
                                                <div class="col-lg-6">
                                                    <label for="idate">Tanggal</label>
                                                    <input type="date" name="idate" id="idate" class="form-control ngRequired"   value="<?= date('Y-m-d'); ?>"/>
                                                    <input type="hidden" name="bomid" id="bomid">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="cusotmer">Customer</label>
                                                    <input type="text" name="cusotmer" id="cusotmer" class="form-control ngRequired"/>
                                                </div>                                    
                                                <div class="col-lg-6">
                                                    <label for="assyno">Assy No</label>
                                                    <input type="text" name="assyno" id="assyno" class="form-control ngRequired"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="inspector">Nama Inspector</label>
                                                    <input type="text" name="inspector" id="inspector" class="form-control ngRequired" value="<?= $_SESSION['usr']['user']; ?>"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="cctno">CCT No</label>
                                                    <input type="text" name="cctno" id="cctno" class="form-control ngRequired"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="operator">Nama Operator</label>
                                                    <input type="text" name="operator" id="operator" class="form-control ngRequired"/>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="jmlcheck">Jumlah Check</label>
                                                    <input type="text" name="jmlcheck" id="jmlcheck" class="form-control ngRequired"/>
                                                </div>
                                                
                                                <div class="col-lg-6">
                                                    <label for="lotng">LOT NG</label>
                                                    <input type="text" name="lotng" id="lotng" class="form-control ngRequired"/>
                                                </div>                                            
                                            </div>

                                            <div class="row hideNG">    
                                                <div class="col-lg-6">
                                                    <label for="nomeja">No Meja / Mesin</label>
                                                    <select name="nomeja" id="nomeja" class="form-control ngRequired">
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
                                            <div class="row hideNG">
                                                <div class="col-lg-12">
                                                    <label for="Section">Section</label>
                                                    <select name="section" id="section" class="form-control ngRequired">
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
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn bg-blue waves-effect">
                                <i class="material-icons">save</i> <span>SAVE</span>
                            </button>
                            <button type="button" class="btn bg-red waves-effect" data-dismiss="modal">
                                <i class="material-icons">close</i> <span>CLOSE</span>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>        

            <div class="modal fade" id="modalScanQRCode" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div id="reader" width="600px" height="600px"></div>
                </div>
                </div>
            </div>        
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?= BASEURL; ?>/js/html5-qrcode.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            var reffid = '';

            $('#btn-scan-qr').on('click', function(){
                $('#modalScanQRCode').modal('show');
                initialCamera()
            })

            async function initialCamera() {
                var devices = await Html5Qrcode.getCameras();
                const html5QrCode = new Html5Qrcode("reader");
                const qrCodeSuccessCallback = message => {
                    readWosData(message);
                    html5QrCode.stop().then(ignore => {
                        // document.getElementById("reffid").focus();
                        $('#modalScanQRCode').modal('hide');
                        html5QrCode.clear();
                        setTimeout(function() { 
                            $('#reffid').focus();
                        }, 1000);
                    }).catch(err => {});
                    
                }
                const qrErrorCallback = error => {}
                const config = {
                    fps: 10,
                    qrbox: 250
                };

                html5QrCode.start({
                    deviceId: {
                        exact: (devices.length > 1) ? devices[devices.length - 1].id : devices[0].id
                    }
                }, config, qrCodeSuccessCallback, qrErrorCallback);
            }

            function readWosData(_qrrefid){
                $('.hideComponent').hide();
                    $('#tbl-wos-data').html('');
                    reffid = _qrrefid;
                    $.ajax({
                        url: base_url+'/wos/getwosdata/'+reffid,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(result){
                        console.log(result)
                        if(result){
                            $('.hideComponent').show();
                            $('#tbl-wos-data').append(`
                                <tr>
                                    <td>`+ result.partnumber +`</td>
                                    <td>`+ result.wpnumber +`</td>
                                    <td>`+ result.lotng +`</td>
                                    <td style="text-align:center;">`+ result.quantity +`</td>
                                    <td>`+ result.stardate +`</td>
                                    <td>`+ result.enddate +`</td>
                                </tr>
                            `);

                            $('#cusotmer').val(result.customer);
                            $('#assyno').val(result.partnumber);
                            $('#cctno').val(result.circuitno);
                            $('#jmlcheck').val(result.quantity);
                            $('#lotng').val(result.lotng);

                            $(".wos-image").attr("src",result.imagelink);
                        }else{
                            showErrorMessage('Data not found')
                        }
                        $('#reffid').val('');
                    }); 
            }

            $('.hideComponent, .hideNG').hide();
            $('.ngRequired').attr('required',false);
            document.getElementById("reffid").focus();

            $('#jmlng').keydown(function(e){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    var ngValue = this.value;
                    $.ajax({
                        url: base_url+'/wos/getwoslastposition/'+reffid,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(result){
                        console.log(result)
                        if(result){
                            if(result.namameja.includes('CHECKER') || result.namameja.includes('checker')){
                                if(ngValue > 0){
                                    $('.hideNG').show();
                                    $('.ngRequired').attr('required',true);
                                }else{
                                    $('.hideNG').hide();
                                    $('.ngRequired').attr('required',false);
                                }
                            }else{
                                showErrorMessage('WOS Not processed yet in Checker Area');
                            }
                        }else{
                            showErrorMessage('WOS Not processed yet in Checker Area');
                        }
                    });                    
                }
            });

            $('#form-post-data').on('submit', function(event){
                event.preventDefault();
                var formData = new FormData(this);
                console.log($(this).serialize())
                
                $.ajax({
                    url: base_url+'/wos/getwoslastposition/'+reffid,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){

                    }
                }).done(function(result){
                    console.log(result)
                    if(result){
                        if(result.namameja.includes('CHECKER') || result.namameja.includes('checker')){
                            console.log(true)
                                $.ajax({
                                    url:base_url+'/wos/closewos/'+reffid,
                                    method:'post',
                                    data:formData,
                                    dataType:'JSON',
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    beforeSend:function(){
                                        // $('#btn-save').attr('disabled','disabled');
                                    },
                                    success:function(data)
                                    {
                                        console.log(data);
                                    },
                                    error:function(err){
                                        showErrorMessage(JSON.stringify(err))
                                    }
                                }).done(function(data){
                                    showSuccessMessage('WOS Closed');
                                })
                        }else{
                            showErrorMessage('WOS Not processed yet in Checker Area');
                        }
                    }else{
                        showErrorMessage('WOS Not processed yet in Checker Area');
                    }
                })
                
                
            })

            $('#btn-close-wos').on('click', function(){
                $('#inspectionModal').modal('show');
            });

            $('#reffid').keydown(function(e){
                if(event.keyCode == 13) {
                    $('.hideComponent').hide();
                    $('#tbl-wos-data').html('');
                    reffid = this.value;
                    $.ajax({
                        url: base_url+'/wos/getwosdata/'+reffid,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(result){
                        console.log(result)
                        if(result){
                            $('.hideComponent').show();
                            $('#tbl-wos-data').append(`
                                <tr>
                                    <td>`+ result.partnumber +`</td>
                                    <td>`+ result.wpnumber +`</td>
                                    <td>`+ result.lotng +`</td>
                                    <td style="text-align:center;">`+ result.quantity +`</td>
                                    <td>`+ result.stardate +`</td>
                                    <td>`+ result.enddate +`</td>
                                </tr>
                            `);

                            $('#cusotmer').val(result.customer);
                            $('#assyno').val(result.partnumber);
                            $('#cctno').val(result.circuitno);
                            $('#jmlcheck').val(result.quantity);
                            $('#lotng').val(result.lotng);

                            $(".wos-image").attr("src",result.imagelink);
                        }else{
                            showErrorMessage('Data not found')
                        }
                        $('#reffid').val('');
                    }); 
                }
            });

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

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/wos/receiptwos';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })
    </script>