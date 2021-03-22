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
                        <div class="row clearfix">
                            <form action="<?= BASEURL; ?>/vendor/save" method="POST">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="namavendor">Nama Vendor</label>
                                            <input type="text" name="namavendor" id="namavendor" class="form-control" placeholder="Nama Vendor" required="true">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="telp">Telepon/HP</label>
                                            <input type="text" name="telp" id="telp" class="form-control" placeholder="Telepon / HP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" style="padding:10dp;">
                                        <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Simpan</button>

                                        <a href="<?= BASEURL; ?>/vendor" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>