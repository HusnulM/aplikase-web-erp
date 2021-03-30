
    <section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Bank Account
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/bank/update" method="POST">
                                <div class="row clearfix">
                                    <input type="hidden" name="id" value="<?= $data['bankdata']['id']; ?>">
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick" name="bankey">
                                            <option value="<?= $data['bankdata']['bankid']; ?>"><?= $data['bankdata']['bankid']; ?> - <?= $data['bankdata']['deskripsi']; ?></option>
                                            <?php foreach($data['banklist'] as $bank) : ?>
                                                <option value="<?= $bank['bankey']; ?>"><?= $bank['bankey']; ?> - <?= $bank['deskripsi']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="bankacc">Bank Account</label>
                                                <input type="text" name="bankacc" id="bankacc" class="form-control" required="true" value="<?= $data['bankdata']['bankno']; ?>" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="bankaccname">Bank Account Name</label>
                                                <input type="text" name="bankaccname" id="bankaccname" class="form-control" required="true" value="<?= $data['bankdata']['bankacc']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="npwp">NPWP</label>
                                                <input type="text" name="npwp" id="npwp" class="form-control" required="true" value="<?= $data['bankdata']['npwp']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/bank" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>