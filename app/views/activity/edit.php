<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
            <form id="form-post-data" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">    
                                <a href="<?= BASEURL; ?>/activity" class="btn bg-red">
                                    <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                </a>
                                <button type="submit" class="btn bg-blue" id="btn-post">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>
                            </ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="process">Process</label>
                                                <input type="text" name="process" class="form-control" placeholder="Process" required value="<?= $data['activity']['activity']; ?>">
                                                <input type="hidden" name="activityid" value="<?= $data['activity']['id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="cycletime">Cycle Time</label>
                                                <input type="text" name="cycletime" id="cycletime" class="form-control" placeholder="Cycle Time" required value="<?= number_format($data['activity']['cycletime'],2,',','.'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="cycleunit">Cycle Unit</label>
                                                <input type="text" name="cycleunit" id="cycleunit" class="form-control" placeholder="Cycle Unit" required value="<?= $data['activity']['cycvleunit']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            $("#cycletime").keydown(function(event){
                if(event.keyCode == 190) {
                    event.preventDefault();
                    showErrorMessage("Untuk decimal separator gunakan ( , )")
                    return false;
                }
            });

            var cycletime  = document.getElementById('cycletime');

            cycletime.addEventListener('keyup', function(e){
                cycletime.value = formatRupiah(this.value, '');
            });

            $('#form-post-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/activity/update',
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
                    }).done(function(result){
                        if(result.msgtype === "1"){
                            showSuccessMessage(result.message);
                            $("#btn-post").attr("disabled", false);
                        }else if(result.msgtype === "2"){
                            showErrorMessage(JSON.stringify(result))            
                            $("#btn-post").attr("disabled", false);  
                        }
                    })
            })

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
                // swal("Success", message, "success");
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/activity';
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "error");
            }
        });
    </script>