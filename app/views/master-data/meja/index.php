    <section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <form action="<?= BASEURL ?>/meja/save" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <!-- <ul class="header-dropdown m-r--5">          
                                    <button type="submit" class="btn bg-green waves-effect">
                                        <i class="material-icons">save</i> <span>SAVE</span>
                                    </button>
                                </ul> -->
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="nomeja">Nomor Mesin / Meja</label>
                                        <input type="text" name="nomeja" id="nomeja" class="form-control"  required/>
                                        <input type="hidden" name="nomejaid" id="nomejaid">
                                    </div>
                                    <div class="col-lg-6">
                                        <br>
                                        <button type="submit" class="btn bg-green waves-effect">
                                            <i class="material-icons">save</i> <span>ADD</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="list-group">
                                        <a href="javascript:void(0);" class="list-group-item active">
                                            No Mesin / Meja
                                        </a>
                                        <?php foreach($data['meja'] as $meja): ?>
                                            <li class="list-group-item"><?= $meja['deskripsi']; ?> 
                                                <span class="badge bg-red">
                                                    <a href="<?= BASEURL; ?>/meja/delete/<?= $meja['nomeja']; ?>" class="btn btn-danger">DELETE</a>    
                                                </span>
                                            </li>
                                            <!-- <a href="javascript:void(0);" class="list-group-item"><?= $meja['nomeja']; ?></a><span class="badge bg-pink">14 new</span> -->
                                        <?php endforeach; ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>        
    </section>