<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Report Purchase Order
                            </h2>
                            <ul class="header-dropdown m-r--5">     
                            <button id="btn-print" type="button" class="btn btn-primary">Print PO</button>    
                            <button id="btn-excel" type="button" class="btn btn-primary">Export to Excel</button>                       
							<a href="<?= BASEURL; ?>/reports/reportpo" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="polist"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        // $(function(){
        //     $('#poitem').dataTable({});
        // })
        var strdate = "<?= $data['strdate']; ?>";
        var enddate = "<?= $data['enddate']; ?>";

        $('#polist').datagrid({
            view: detailview,
            detailFormatter:function(index,row){
                return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
            },
                onExpandRow: function(index,row){
                $('#ddv-'+index).panel({
                            border:true,
                            cache:false,
                            href:base_url + '/app/views/po/detailpo.php?ponum='+row.ponum,

                            onLoad:function(){
                                $('#polist').datagrid('fixDetailRowHeight',index);
                            }
                        });
                        $('#polist').datagrid('fixDetailRowHeight',index);
                    },
                    width:'100%',
                    height:400,
                    singleSelect:true,
                    resizable:true,
                    fitColumns:false,
                    enableCellEditing:true,
                    pagination:true,
                    pageList:[10,20,50,100,150,200],
                    idField:'ponum',
                    url:base_url+'/reports/laporanpodata/'+strdate+'/'+enddate, 
                    columns:[[
                        {field:'ponum',title:'PO Num',width:180},
                        {field:'note',title:'Note',width:150,editor:'text',nowrap:true},
                        {field:'namavendor',title:'Vendor',width:200,editor:'text',nowrap:true},
                        {field:'createdby',title:'Created By',width:200,editor:'text',nowrap:true},
                        {field:'podat',title:'PO Date',width:100,editor:'text'},
                        {field:'postat',title:'Approval Status',width:100,editor:'text',
                            styler: function(value,row,index){
                                if (row.approvestat == "1") {
                                    return 'background-color:yellow;color:black;font-weight: bold;';
                                }else if (row.approvestat == "2") {
                                    return 'background-color:green;color:white;font-weight: bold;';
                                }else if (row.approvestat == "3") {
                                    return 'background-color:red;color:white;font-weight: bold;';
                                }else if (row.approvestat == "4") {
                                    return 'background-color:#c57530;color:white;font-weight: bold;';
                                }else if (row.approvestat == "5") {
                                    return 'background-color:#c57530;color:white;font-weight: bold;';
                                }else{
                                    return 'background-color:yellow;color:black;font-weight: bold;';
                                }
                            }
                        }
                    ]],				
            });

        $(function(){
            $('#btn-print').on('click', function(){
                // window.location.href = base_url+'/pr/print/'
                var row = $('#polist').datagrid('getSelected');
                if (row){
                    // window.location.href = mainurl+"/purchasing/printPR/"+row.prnum;
                    window.open(base_url+"/po/printpo/data?ponum="+row.ponum, '_blank');
                }else{
                    showErrorMessage('No data selected');
                }
            });

            $('#btn-excel').on('click', function(){
                // window.location.href = base_url+'/pr/print/'
                var row = $('#polist').datagrid('getSelected');
                if (row){
                    window.open(base_url+"/reports/exportpo_excel/data?ponum="+row.ponum, '_blank');
                }else{
                    showErrorMessage('No data selected');
                }
            });

            function showSuccessMessage(message) {
                swal({title: "Berhasil", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url+'/pr';
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        })
    </script>