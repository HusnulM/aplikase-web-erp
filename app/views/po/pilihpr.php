    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Purchase Request List
                            </h2>
							
                            <ul class="header-dropdown m-r--5">                  
                            <button id="btn-show-pr" class="btn btn-primary">Display PR</button>              
							<button id="btn-convert-to-po" class="btn btn-success">Convert to PO</button>
							</ul>
                        </div>
                        <div class="body">
                            <!-- <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="project">Project</label>
                                            <select class="form-control show-tick" name="project" id="project">
                                                <option value="">Select Project</option>
                                                <?php foreach($data['project'] as $proj) : ?>
                                                <option value="<?= $proj['idproject']; ?>"><?= $proj['namaproject']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                            </div> -->
                            <div class="table-responsive">
                                <table id="prlist"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>                                                    
    <script>
        let usertype = "<?= $_SESSION['usr']['userlevel']; ?>";
        localStorage.clear();
        $(function(){
            $('#btn-convert-to-po').on('click',function(){
                localStorage.clear();
                var data = $('#prlist').datagrid('getSelections');
                console.log(JSON.stringify(data))
                if(data.length > 0){
                    sessionStorage.setItem("prtopo", JSON.stringify(data));
                    // sessionStorage.setItem("project", $('#project').val());
                    window.location.href = base_url+"/po/create";
                }else{
                    showErrorMessage('No data selected');
                }                
                // window.open(base_url+"/po/create/1000000026", '_blank');
            });

            $('#btn-show-pr').on('click', function(){
                displayprlist();
            })
            displayprlist()
            function displayprlist(){
                // alert($('#project').val())
                $('#prlist').datagrid({
                view: detailview,
                detailFormatter:function(index,row){
                    return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
                },
                    onExpandRow: function(index,row){
                    $('#ddv-'+index).panel({
                                border:true,
                                cache:false,
                                href:base_url + '/app/views/pr/detailpropen.php?prnum='+row.prnum,

                                onLoad:function(){
                                    $('#prlist').datagrid('fixDetailRowHeight',index);
                                }
                            });
                            $('#prlist').datagrid('fixDetailRowHeight',index);
                        },
                        width:'100%',
                        height:350,
                        singleSelect:false,
                        resizable:true,
                        fitColumns:true,
                        pagination:true,
                        pageList:[10,20,50,100,150,200],
                        idField:'prnum',
                        url:base_url+'/po/listprtopo/', 
                        columns:[[
                            {field:'prnum',title:'PR Num',width:90},
                            {field:'note',title:'Note',width:200,editor:'text',nowrap:true},
                            {field:'namaproject',title:'Project',width:250,editor:'text'},
                            {field:'createdon',title:'Created Date',width:80,editor:'text'},
                            {field:'tglrequest',title:'Request Date',width:100,editor:'text'},
                            {field:'approvalstat',title:'Aprooval Status',width:100,editor:'text',
                                styler: function(value,row,index){
                                    if (row.status == "1") {
                                        return 'background-color:yellow;color:black;font-weight: bold;';
                                    }else if (row.status == "2") {
                                        return 'background-color:green;color:white;font-weight: bold;';
                                    }else if (row.status == "3") {
                                        return 'background-color:#red;color:white;font-weight: bold;';
                                    }else if (row.status == "4") {
                                        return 'background-color:#c57530;color:white;font-weight: bold;';
                                    }else if (row.status == "5") {
                                        return 'background-color:#c57530;color:white;font-weight: bold;';
                                    }else{
                                        return 'background-color:yellow;color:black;font-weight: bold;';
                                    }
                                }
                            },
                            // {field:'Action',title:'',width:100,align:'center',
                            //     formatter:function(value,row,index){
                            //         var a = '<a href="javascript:void(0)" onclick="createpo(this)">Convert to PO</a>';                                
                            //         return a;
                            //     },
                            //     styler: function(value,row,index){
                            //         return 'background-color:white;color:blue;';
                            //     }
                            // }
                        ]],				
                });
            }

            function showErrorMessage(message){
                swal("", message, "warning");
            }
        })

        function createpo(target){
            var tr = $(target).closest('tr.datagrid-row');
            var x  = (tr.attr('datagrid-row-index'));
            var v  = $('#prlist').datagrid('getRows')[x].prnum;
            window.location.href = base_url+"/po/create/"+v;
        }
    </script>