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
							<a href="<?= BASEURL; ?>/wosimage" class="btn btn-success waves-effect pull-right">BACK</a>
							</ul>
                        </div>
                        <div class="body">
                            <form id="form-input-data">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="partnumber">PART NUMBER</label>
                                        <input type="text" name="partnumber" id="partnumber" class="form-control" required value="<?= $data['partdata']['partnumber']; ?>" readonly/>
                                        <input type="hidden" name="bomid" value="<?= $data['partdata']['bomid']; ?>">
                                    </div>  
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-12">
                                        <label for="reffid">IMAGE LINK</label>
                                        <Textarea name="imagelink" cols="12" rows="5" class="form-control" required></Textarea>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary waves-effect pull-right">SAVE</button>
                                    </div>  
                                </div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Part Number</th>
                                                <th>Circuit No</th>
                                                <th>Image Link</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['wosimage'] as $out) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $out['partnumber']; ?></td>
                                                    <td><?= $out['circuitno']; ?></td>
                                                    <td><?= $out['imagelink']; ?></td>
                                                    
                                                    <td>
                                                        <a href="<?= BASEURL; ?>/wosimage/deleteimage/<?= $out['bomid']; ?>/<?= $out['circuitno']; ?>" type="button" class="btn btn-danger">Delete</a>
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

            var bomid = "<?= $data['bomid']; ?>";

            $('#form-input-data').on('submit', function(event){
                event.preventDefault();
                
                var formData = new FormData(this);
                console.log($(this).serialize())
                    $.ajax({
                        url:base_url+'/wosimage/save',
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
            });

            function showBasicMessage() {
                swal({title:"Loading...", text:"Mohon Menunggu", showConfirmButton: false});
            }

            function showSuccessMessage(message) {
                // swal("Success", message, "success");
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/wosimage/maintainimage/'+bomid;
                    }
                );
            }

            function showErrorMessage(message){
                swal("", message, "error");
            }
        })
    </script>