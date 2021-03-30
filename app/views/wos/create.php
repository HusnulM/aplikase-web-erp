    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <!-- id="form-input-data" -->
            <!-- action="<?= BASEURL; ?>/wos/savewos" -->
            <form id="form-input-data" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <a href="<?= BASEURL; ?>/wos/report" class="btn bg-green waves-effect">
                                        <i class="material-icons">view_headline</i> <span>WOS Reports</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="row">                                    
                                    <!-- <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="reffid">SCAN / INPUT REFF ID</label>
                                        <input type="text" name="reffid" id="reffid" class="form-control" autocomplete="off" required/>
                                    </div>                                -->
                                    <div class="col-lg-8 col-md-12 col-sm-12 col-xm-12">
                                        <label for="partnumber">PART NUMBER</label>
                                        <input type="text" name="partnumber" id="partnumber" class="form-control"  readonly="true" required/>
                                        <input type="hidden" name="bomid" id="bomid">
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 col-xm-12">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-search-part">
                                            <i class="material-icons">format_list_bulleted</i> <span>PILIH PART</span>
                                        </button>
                                    </div>                                  
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="wpnumber">WP NUMBER</label>
                                        <input type="number" name="wpnumber" list="wpnumber" max="100" class="form-control"  required/>
                                        <datalist id="wpnumber">
                                            <?php for($i = 1; $i<=100;$i++){ ?>
                                                <option value="<?= $i; ?>">
                                            <?php }?>
                                        </datalist>
                                    </div> 
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="circuitno">CIRCUIT No.</label>
                                        <input type="number" name="circuitno" list="circuitno" max="100" class="form-control"  required/>
                                        <datalist id="circuitno">
                                            <?php for($i = 1; $i<=100;$i++){ ?>
                                                <option value="<?= $i; ?>">
                                            <?php }?>
                                        </datalist>
                                    </div>  
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="qtytotal">TOTAL QUANTITY</label>
                                        <input type="number" name="qtytotal" id="qtytotal" class="form-control" required/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="quantity">QUANTITY WOS</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" required/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="strdate">PERIODE</label>
                                        <input type="date" name="strdate" id="strdate" class="form-control"  required value="<?= date('Y-m-d'); ?>"/>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xm-12">
                                        <label for="enddate">-</label>
                                        <input type="date" name="enddate" id="enddate" class="form-control"  required value="<?= date('Y-m-d'); ?>"/>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-12 col-xm-12">
                                        <br>
                                        <button class="btn bg-blue form-control" type="button" id="btn-generate-wos">
                                            <i class="material-icons">content_paste</i> <span>GENERATE</span>
                                        </button>
                                    </div>  
                                </div>

                                <div class="row wosItem">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                        <table class="table" id="tbl-wos-item">
                                            <thead>
                                                <th>REFF ID</th>
                                                <th style="width:30%;">QUANTITY</th>
                                                <th>LOT NUMBER</th>
                                            </thead>
                                            <tbody id="wos-item">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row wosItem">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                        <button type="submit" class="btn bg-green waves-effect pull-right" id="btn-save">
                                            <i class="material-icons">save</i> <span>SAVE</span>
                                        </button>
                                    </div>
                                </div>
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

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            $('.wosItem').hide();

            // document.getElementById("reffid").focus();

            defauldatetime();
            function defauldatetime(){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                if(dd<10){
                        dd='0'+dd
                } 
                if(mm<10){
                    mm='0'+mm
                } 
                
                today = yyyy+'-'+mm+'-'+dd;
                $('#strdate,#enddate').attr("min", today);

            }

            $('#btn-generate-wos').on('click', function(){

                $('#wos-item').html('');
                var qtotal = 0;
                var qtywos = 0;
                var jmlwos = 0;
                var count  = 1;

                qtotal = $('#qtytotal').val();
                qtywos = $('#quantity').val();

                if(qtotal === ''){
                    qtotal = 0;
                }
                if(qtywos === ''){
                    qtywos = 0;
                }

                jmlwos = qtotal / qtywos;
                // alert(jmlwos);
                var _alphabet = '';
                for(var i = 0; i < jmlwos; i++){
                    _alphabet = String.fromCharCode(97 + i);
                    $('#wos-item').append(`
                        <tr counter="`+ count +`" id="output_newrow_`+ count +`">
                            <td>
                                <input type="text" name="_reffid[]" id="_refid`+ count +`" class="form-control reffid TextInput" required autocomplete="off" counter="`+ count +`"/>
                            </td>
                            <td>
                                <input type="number" name="_wosqty[]" class="form-control" value="`+ qtywos +`" required  counter="`+ count +`"/>
                            </td>
                            <td>
                                <input type="text" name="_lotng[]" class="form-control" value="`+ _alphabet.toUpperCase() +`" required  counter="`+ count +`" readonly/>
                            </td>
                        </tr>
                    `);

                    $('#_refid'+count).keydown(function(e){
                        if(e.keyCode == 13) {
                            var xcounter = $(this).attr('counter');
                            var xreffid  = $('#_refid'+xcounter).val();
                            $.ajax({
                                url: base_url+'/wos/checkreffiduse/'+this.value,
                                type: 'GET',
                                dataType: 'json',
                                cache:false,
                                success: function(result){
                                }
                            }).done(function(result){
                                console.log(result)
                                if(result.rows === "1"){
                                    showErrorMessage('REFFID '+ xreffid + ' already used in another WOS');
                                    $('#_refid'+xcounter).val('');
                                }else{
                                    var selid = (xcounter*1) + (1*1);
                                    document.getElementById("_refid"+selid).focus();
                                }
                            });
                        }
                    });
                    count = count + 1;                 
                }

                setTimeout(function() { 
                    $('#_refid1').focus();
                }, 1000);
                // document.getElementById("_refid"+1).focus();

                $('.wosItem').show();
            });

            function isExist(newEntry){
                return Array.from($('tr[id*=output_newrow]'))
                        .some(element => ($('td:nth(0) input[type="text"]',$(element)).html()===newEntry));
            }

            $('#btn-search-part').on('click', function(){
                $('#partModal').modal('show');
            });

            loaddatapart();
            function loaddatapart(){
                $('#list-part').dataTable({
                    "ajax": base_url+'/quotation/partlist',
                    "columns": [
                        { "data": "partnumber" },
                        { "data": "partname" },
                        { "data": "customer" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Pilih</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-part tbody').on( 'click', 'button', function () {
                    var table = $('#list-part').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();
                    
                    console.log(selected_data);
                    $('#bomid').val(selected_data.bomid);
                    $('#partnumber').val(selected_data.partnumber);
                    $('#partModal').modal('hide');
                } );
            }

            $('#form-input-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/wos/savewos',
                        method:'post',
                        data:formData,
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('#btn-save').attr('disabled','disabled');
                        },
                        success:function(data)
                        {
                        	console.log(data);
                        },
                        error:function(err){
                            showErrorMessage(JSON.stringify(err))
                        }
                    }).done(function(result){
                        if(result.msgtype === "1"){
                            showSuccessMessage(result.message);
                            $("#btn-save").attr("disabled", false);
                            $('#wos-item').html('');
                            $('.wosItem').hide();
                        }else if(result.msgtype === "2"){
                            showErrorMessage(result.message)            
                            $("#btn-save").attr("disabled", false);  
                        }
                    })
            })

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        // window.location.href = base_url+'/wos';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }

            function showErrorMessage2(message, id){
                // swal("", message, "warning");
                swal({title: "", text: message, type: "warning"},
                    function(){ 
                        // alert($('#'+id).val())
                    }
                );
            }
        })
    </script>