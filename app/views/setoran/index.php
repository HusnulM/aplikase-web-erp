    <section class="content">
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
                                Setoran
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/setoran/save" method="POST" enctype="multipart/form-data">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="tglsetor">Tanggal Setor</label>
                                                <input type="date" name="tglsetor" id="tglsetor" class="form-control"  required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="fromakun">Setoran Dari Akun Bank</label>
                                                <select class="form-control show-tick" name="fromakun">
                                                    <?php foreach($data['bank'] as $bank) : ?>
                                                    <option value="<?= $bank['bankno']; ?>"> <?= $bank['deskripsi']; ?> | <?= $bank['bankno']; ?> <?= $bank['bankacc']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="toakun">Setoran Ke Akun Bank</label>
                                                <select class="form-control show-tick" name="toakun">
                                                    <?php foreach($data['bank'] as $bank) : ?>
                                                    <option value="<?= $bank['bankno']; ?>"> <?= $bank['deskripsi']; ?> | <?= $bank['bankno']; ?> <?= $bank['bankacc']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="tglsetor">Jumlah Setor</label>
                                                <input type="text" name="jmlsetor" id="jmlsetor" class="form-control"  required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                                <div class="btn btn-primary btn-sm float-left">
                                                    <label for="efile">Upload Bukti Setoran</label>
                                                    <input type="file" name="efile" id="efile" class="form-control"  required="true">
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Simpan</button>

                                            <a href="<?= BASEURL; ?>/barang" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>