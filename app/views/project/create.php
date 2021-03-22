	<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Tambah Project
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/project/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" name="kodebrg" id="kodebrg">
                                                <input type="text" name="namaproject" id="namaproject" class="form-control" placeholder="Nama Project" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <select class="form-control show-tick" name="status">
                                            <option value="">Pilih Status</option>
                                            <option value="Open">Open</option>
											<option value="Close">Close</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Simpan</button>

                                            <a href="<?= BASEURL; ?>/project" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>