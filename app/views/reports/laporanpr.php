    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Report Purchase Request Selection
                            </h2>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">PR Date</label>
                                                <input type="date" name="reqdate1" id="strdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">-</label>
                                                <input type="date" name="reqdate1" id="enddate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>                                    
                                </div>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">Status</label>
                                                <select name="prstatus" id="prstatus" class="form-control">
                                                    <option value="All">All</option>
                                                    <option value="O">Open</option>
                                                    <option value="A">Approved</option>
                                                    <option value="R">Rejected</option>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>
                                </div>

                                <div class="row clearfix">
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
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            $('#btn-process').on('click', function(){
                window.location.href = base_url+'/reports/reportprview/'+$('#strdate').val()+'/'+$('#enddate').val()+'/'+$('#prstatus').val()
            })
        })
    </script>