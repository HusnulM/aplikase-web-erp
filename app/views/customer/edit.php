<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/customer/update" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="custname">Nama Customer</label>
                                                <input type="text" name="custname" id="custname" class="form-control" required="true" value="<?= $data['cust']['cust_name']; ?>">
                                                <input type="hidden" name="cust_id" value="<?= $data['cust']['cust_id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="custaddr">Alamat</label>
                                                <input type="text" name="custaddr" id="custaddr" class="form-control" value="<?= $data['cust']['cust_address']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="custemail">Email</label>
                                                <input type="email" name="custemail" id="custemail" class="form-control" value="<?= $data['cust']['cust_email']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="custtelp">Telephone</label>
                                                <input type="text" name="custtelp" id="custtelp" class="form-control" value="<?= $data['cust']['cust_telp']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/customer" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>