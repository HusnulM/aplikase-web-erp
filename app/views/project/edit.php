<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Project
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/project/update" method="POST">
                                <div class="row clearfix">
                                    <input type="hidden" name="idproject" value="<?= $data['rdata']['idproject']; ?>">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
												<label for="projectname">Project Name</label>
												<input type="text" name="projectname" id="username" class="form-control" placeholder="Input Project Name" required="true" value="<?= $data['rdata']['namaproject']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
											<label for="status">Project Status</label>
											<select name="status" class="form-control">
												<?php if ($data['rdata']['status'] === "Open") : ?>
													<option value="Open">Open</option>
													<option value="Close">Close</option>
												<?php else : ?>
													<option value="Close">Close</option>
													<option value="Open">Open</option>
												<?php endif; ?>
											</select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/project" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>