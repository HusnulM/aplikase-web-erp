<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Report Payment Purchase Order
                            </h2>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                <table id="paymentlist"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        var strdate = "<?= $data['strdate']; ?>";
        var enddate = "<?= $data['enddate']; ?>";
        $('#paymentlist').datagrid({
            view: detailview,
            detailFormatter:function(index,row){
                return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
            },
                onExpandRow: function(index,row){
                $('#ddv-'+index).panel({
                            border:true,
                            cache:false,
                            href:base_url + '/app/views/invoice/detailpayment.php?ivnum='+row.ivnum+'&year='+row.ivyear,

                            onLoad:function(){
                                $('#paymentlist').datagrid('fixDetailRowHeight',index);
                            }
                        });
                        $('#paymentlist').datagrid('fixDetailRowHeight',index);
                    },
                    width:'100%',
                    height:400,
                    singleSelect:true,
                    resizable:true,
                    fitColumns:true,
                    pagination:true,
                    pageList:[10,20,50,100,150,200],
                    idField:'ivnum',
                    url:base_url+'/reports/rpaymentdata/'+strdate+'/'+enddate, 
                    columns:[[
                        {field:'ivnum',title:'Payment Number',width:90},
                        {field:'ivyear',title:'Year',width:150,editor:'text',nowrap:true},
                        {field:'namavendor',title:'Vendor',width:200,editor:'text'},
                        {field:'createdon',title:'Payment Date',width:80,editor:'text'}
                    ]],				
            });
    </script>