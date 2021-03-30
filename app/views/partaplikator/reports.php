<section class="content">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <!-- action="<?= BASEURL; ?>/delivery/save" -->
            <form id="form-input-data" method="POST">         
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>
                                    <?= $data['menu']; ?>
                                </h2>

                                <ul class="header-dropdown m-r--5">          
                                    <!-- <button type="submit" class="btn bg-green waves-effect" id="btn-save">
                                        <i class="material-icons">save</i> <span>EXPORT</span>
                                    </button> -->
                                    <a href="<?= BASEURL; ?>/partaplikator" class="btn bg-green waves-effect">
                                        <i class="material-icons">keyboard_arrow_left</i> <span>BACK</span>
                                    </a>
                                </ul>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-responsive table-bordered table-striped" id="list-part" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NAMA PART</th>
                                                <th>SPARE PART NO</th>
                                                <th>NAMA APLIKATOR</th>
                                                <th>LOKASI PART</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <br><br><br>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>   
    </section>

    <script>
        $(document).ready(function(){
            var _apiurl = "http://localhost:8181/aws-eproc/aplikator/";

            loaddatapart();
            function loaddatapart(){
                $('#list-part').dataTable({
                    "dom": 'lBfrtip',
                    "responsive": true,
                    "buttons": [
                        'copy', 'csv', 'pdf', 'print', 'excel'
                    ],
                    "ajax": _apiurl+'partlist',
                    "columns": [
                        { "data": "id", 
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        { "data": "partname" },
                        { "data": "partnumber" },
                        { "data": "idaplikator" },
                        { "data": "lokasi" }
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true,
                    "pageLength": 50,
                    "lengthMenu": [50, 100, 200, 500]
                });
            }
        })
    </script>