<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create Bank Account
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/bank/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick" name="bankey" data-live-search="true">
                                            <option value="">Bank ID</option>
                                            <?php foreach($data['banklist'] as $bank) : ?>
                                                <option value="<?= $bank['bankey']; ?>"><?= $bank['bankey']; ?> - <?= $bank['deskripsi']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="bankacc">Bank Account</label>
                                                <input type="text" name="bankacc" id="bankacc" class="form-control" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="bankaccname">Bank Account Name</label>
                                                <input type="text" name="bankaccname" id="bankaccname" class="form-control" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="npwp">NPWP</label>
                                                <input type="text" name="npwp" id="npwp" class="form-control" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="balance">Opening Balance</label>
                                                <input type="text" name="balance" id="balance" class="form-control" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick" name="userid">
                                            <option value="">User ID</option>
                                            <?php foreach($data['user'] as $user) : ?>
                                                <option value="<?= $user['username']; ?>"><?= $user['username']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/barang" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>