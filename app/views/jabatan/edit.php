<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Barang
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/jabatan/update" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" name="id" id="id" value="<?= $data['jabatan']['id']; ?>">
                                                <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Nama jabatan" value="<?= $data['jabatan']['jabatan']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Simpan</button>

                                            <a href="<?= BASEURL; ?>/jabatan" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>