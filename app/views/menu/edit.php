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
                            <form action="<?= BASEURL; ?>/menu/update" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" name="idmenu" id="idmenu" value="<?= $data['menus']['id']; ?>">
                                                <input type="text" name="menu" class="form-control" placeholder="Application Menu" required="true" value="<?= $data['menus']['menu']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="route" class="form-control" placeholder="Route" required="true" value="<?= $data['menus']['route']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="type">
                                                    <option value="<?= $data['menus']['type']; ?>"><?= $data['menus']['type']; ?></option>
                                                    <option value="parent">Parent</option>
                                                    <option value="child">Child</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="group">
                                                    <option value="<?= $data['menus']['grouping']; ?>"><?= $data['menus']['grouping']; ?></option>
                                                    <option value="master">Master</option>
                                                    <option value="transaction">Transaction</option>
                                                    <option value="report">Report</option>
                                                    <option value="setting">Setting</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/menu" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>