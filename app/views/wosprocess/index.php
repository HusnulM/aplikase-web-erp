<div class="content" style="margin-top:60px;">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div class="row">   
                                    <div class="col-lg-3">
                                        <div class="col-lg-12">
                                            <label for="reffid">SCAN / INPUT WOS REFF ID</label>
                                            <input type="text" name="reffid" id="reffid" class="form-control" autocomplete="off" required/>
                                        </div>
                                        <div class="col-lg-12 hideComponent" id="idprocess">
                                        </div>                                        
                                        <!-- <hr> -->
                                        <button type="button" class="btn btn-primary form-control hideComponent" id="btn-process-wos" style="margin-top:10px;">PROCESS WOS</button>
                                        <button type="button" class="btn btn-primary form-control" id="btn-scan-qr-wos" style="margin-top:10px; margin-bottom:10px;">
                                            SCAN QR WOS
                                        </button>
                                        <button type="button" class="btn btn-primary form-control" id="btn-scan-mesin">
                                            SCAN REFFID MESIN
                                        </button style="margin-top:10px; margin-bottom:10px;">
                                    </div>                               
                                    <div class="col-lg-9">
                                        <div class="col-lg-12 text-center mb-0" style="margin-bottom:0px;">
                                            <h4 style="margin-bottom:0px;" id="areaName"></h4>
                                            <hr style="margin-bottom:0px;">
                                        </div>
                                        <div class="col-lg-12 mb-0" style="margin-bottom:0px;">
                                        <table class="table table-stripped hideComponent" style="margin-bottom:0px;">
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
                                </div>  
                                <div class="row hideComponent">
                                    <div class="col-lg-12">
                                        <img alt="WOS-IMAGE" class="img-fluid wos-image" width="100%;">
                                        <img alt="PART-IMAGE" class="img-fluid part-image" width="100%;">
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
        </div>     
    </div>

    <div class="modal fade" id="modalScanReffidMesin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">SCAN REFFID / QR ( MESIN / MEJA )</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <input type="text" name="reffidmesin" id="reffidmesin" class="form-control">
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-primary" id="btn-scan-qr" style="margin-top:10px;">SCAN QR CODE</button>
                    <button type="button" class="btn btn-primary" id="btn-stop-scan-qr" style="margin-top:10px;">STOP SCAN QR CODE</button>
                </div>
                <hr>
                <div>
                    <div id="reader" width="600px" height="600px"></div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modalScanQRCodeWOS" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <!-- <div class="modal-content">
                <div id="qrwosval" width="600px" height="600px"></div>
            </div> -->
            <div id="qrwosval" width="600px" height="600px"></div>
        </div>
    </div>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?= BASEURL; ?>/js/html5-qrcode.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            var selectedReffidMesin;

            selectedReffidMesin = localStorage.getItem("reffidmesin");
            var selectedWOS = '';

            var wosdata = [];
            console.log(selectedReffidMesin)
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });            

            scannReffidMesin();

            $('#btn-scan-mesin').on('click', function(){
                scannReffidMesin();
            });

            $('#btn-scan-qr').on('click', function(){
                initialCamera();
            });

            $('#btn-scan-qr-wos').on('click', function(){
                $('#modalScanQRCodeWOS').modal('show');
                startScanWosQR();
            });

            $('#btn-stop-scan-qr').on('click', function(){
                const html5QrCode = new Html5Qrcode("reader");
                html5QrCode.stop();
                html5QrCode.clear();
            });

            async function initialCamera() {
                var devices = await Html5Qrcode.getCameras();
                const html5QrCode = new Html5Qrcode("reader");
                const qrCodeSuccessCallback = message => {
                    readIdMesinQR(message);
                    html5QrCode.stop().then(ignore => {
                        html5QrCode.clear();
                        html5QrCode.stop();
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

            async function startScanWosQR() {
                var devices = await Html5Qrcode.getCameras();
                const html5QrCode = new Html5Qrcode("qrwosval");
                const qrCodeSuccessCallback = message => {
                    readWosByQR(message);
                    html5QrCode.stop().then(ignore => {
                        // document.getElementById("reffid").focus();
                        $('#modalScanQRCodeWOS').modal('hide');
                        html5QrCode.clear();
                        html5QrCode.stop();
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

            function readIdMesinQR(qrReffid){
                $('.hideComponent').hide();
                    $.ajax({
                        url: base_url+'/meja/getmejabyreffid/'+qrReffid,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(data){
                        console.log(data)
                        if(data){
                            localStorage.setItem("reffidmesin", JSON.stringify(data)); 
                            $('#modalScanReffidMesin').modal('hide');  
                            readProcessMesin(data.reffid);
                            document.getElementById("reffid").focus();    
                            $('#areaName').html(data.deskripsi);   
                            $('#reffidmesin').val('');         
                        }else{
                            showErrorMessage2('QR not found');
                            $('#reffidmesin').val('');                            
                        }
                    });
            }

            function readWosByQR(_wosQrVal){
                $('.hideComponent').hide();
                    var reffid = _wosQrVal;
                    wosdata = [];
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
                                selectedReffidMesin = localStorage.getItem("reffidmesin");
                                var currentMesin    = JSON.parse(selectedReffidMesin);
                                currentMesin.deskripsi.toUpperCase();
                                if(currentMesin.deskripsi.includes('PACKING')){
                                    readwosdata(reffid)
                                }else{
                                    showErrorMessage('WOS already processed in Checker Area');
                                    $('#reffid').val('');
                                    document.getElementById("reffid").focus();    
                                }
                            }else{
                                readwosdata(reffid)
                            }
                        }else{
                            readwosdata(reffid)
                        }
                    });  
            }

            function scannReffidMesin(){
                $("#modalScanReffidMesin").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                setTimeout(function() { 
                    $('#reffidmesin').focus();
                }, 1000);
                wosdata = [];
                $('.hideComponent').hide();
            };

            $('#reffidmesin').keydown(function(event){
                if(event.keyCode == 13) {
                    $('.hideComponent').hide();
                    $.ajax({
                        url: base_url+'/meja/getmejabyreffid/'+this.value,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(data){
                        console.log(data)
                        if(data){
                            localStorage.setItem("reffidmesin", JSON.stringify(data)); 
                            $('#modalScanReffidMesin').modal('hide');  
                            readProcessMesin(data.reffid);
                            document.getElementById("reffid").focus();    
                            $('#areaName').html(data.deskripsi);   
                            $('#reffidmesin').val('');         
                        }else{
                            showErrorMessage2('REFF ID not found');
                            $('#reffidmesin').val('');                            
                        }
                    });
                }
            });

            function readProcessMesin(_reffidmesin){
                $('#idprocess').html('');
                $.ajax({
                    url: base_url+'/meja/listmejaprocesbyreffid/'+_reffidmesin,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        
                    }
                }).done(function(result){
                    console.log(result)
                    var listitem = '';
                    listitem += `<label for="process">Process</label>`;
                    listitem += `<select name="process" id="selectedprocess" class="form-control selProc" value="" required>`;
                    listitem += `<option class="form-control" value="0">---Pilih Proses---</option>`;
                    for (var i = 0; i < result.length; i++) {
                        listitem += `<option class="form-control" value="`+ result[i].idproses +`">`+ result[i].proses +`</option>`;
                    };
                    listitem += `</select>`;
                    $("#idprocess").append(listitem);    
                }); 
            }
            

            $('.hideComponent, .sidebar').hide();
            document.getElementById("reffid").focus();

            $('#reffid').keydown(function(e){
                if(e.keyCode == 13) {
                    $('.hideComponent').hide();
                    var reffid = this.value;
                    wosdata = [];
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
                                selectedReffidMesin = localStorage.getItem("reffidmesin");
                                var currentMesin    = JSON.parse(selectedReffidMesin);
                                currentMesin.deskripsi.toUpperCase();
                                if(currentMesin.deskripsi.includes('PACKING')){
                                    readwosdata(reffid)
                                }else{
                                    showErrorMessage('WOS already processed in Checker Area');
                                    $('#reffid').val('');
                                    document.getElementById("reffid").focus();    
                                }
                            }else{
                                readwosdata(reffid)
                            }
                        }else{
                            readwosdata(reffid)
                        }
                    });  
                }
            });

            function readwosdata(reffid){
                $('.hideComponent').hide();
                    $('#tbl-wos-data').html('');
                    
                    selectedReffidMesin = localStorage.getItem("reffidmesin");
                    wosdata = [];
                    $.ajax({
                        url: base_url+'/wos/getwosdata/'+reffid,
                        type: 'GET',
                        dataType: 'json',
                        cache:false,
                        success: function(result){

                        }
                    }).done(function(result){
                        // console.log(result)
                        if(result){
                            $('.hideComponent').show();
                            $('#tbl-wos-data').append(`
                                <tr>
                                    <td>`+ result.partnumber +`</td>
                                    <td>`+ result.wpnumber +`</td>
                                    <td>`+ result.lotng +`</td>
                                    <td><b>`+ result.quantity +`</b></td>
                                    <td>`+ result.stardate +`</td>
                                    <td>`+ result.enddate +`</td>
                                </tr>
                            `);

                            $(".wos-image").attr("src",result.imagelink);
                            loadpartimage(result.partnumber);
                            selectedWOS = reffid;

                            selectedReffidMesin = localStorage.getItem("reffidmesin");
                            console.log(selectedReffidMesin)
                            var currentMesin    = JSON.parse(selectedReffidMesin);

                            var wosinput = {};
                            wosinput.wosid       = result.id;
                            wosinput.wosrfid     = selectedWOS;
                            wosinput.reffidmesin = currentMesin.reffid;
                            wosinput.area        = currentMesin.nomeja;
                            wosdata.push(wosinput);
                            // console.log(wosdata)
                        }else{
                            showErrorMessage('WOS not found');
                        }
                        $('#reffid').val('');
                        document.getElementById("reffid").focus();    
                    }); 
            }

            $('#btn-process-wos').on('click', function(){
                processWos();
            })

            function loadpartimage(partnumber){
                $.ajax({
                    url: base_url+'/wosimage/partimage/data?partnumber='+partnumber,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){

                    }
                }).done(function(res){
                    // console.log(res)
                    $(".part-image").attr("src",res.imagelink);
                })
            }

            function processWos(){
                var wosinput = {};
                wosinput.process     = $('#selectedprocess').val();
                wosdata.push(wosinput);
                console.log(wosinput);
                var postdata = {
                    'items'  : wosdata
                }
                console.log(postdata);
                $.ajax({
                    url:base_url+'/wosprocess/processwos',
                    method:'post',
                    data:postdata,
                    dataType:'JSON',
                    cache: false,
                    beforeSend:function(){
                        $('#btn-save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {
                        console.log(data);
                    },
                    error:function(err){
                        showErrorMessage(JSON.stringify(err))
                        console.log(err)
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                        $("#btn-save").attr("disabled", false);
                    }else if(result.msgtype === "2"){
                        showErrorMessage(result.message)            
                        $("#btn-save").attr("disabled", false);  
                    }
                });                
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/wosprocess';
                    }
                );
            }
            // document.getElementById("reffid").focus();    
            function showErrorMessage(message){
                // swal("", message, "warning");
                swal({title: "", text: message, type: "warning"},
                    function(){  
                        setTimeout(function() { 
                            $('#reffid').focus();
                        }, 1000);
                    }
                );
            }

            function showErrorMessage2(message){
                // swal("", message, "warning");
                swal({title: "", text: message, type: "warning"},
                    function(){  
                        setTimeout(function() { 
                            document.getElementById("reffidmesin").focus();
                        }, 1000);
                    }
                );
            }
        })
    </script>