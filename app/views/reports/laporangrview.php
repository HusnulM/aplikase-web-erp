<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                Report Receipt PO
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/reports/grpo" type="button" class="btn btn-primary">Back</a>
							</ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                <!-- <table id="grlist"></table> -->
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Receipt Num</th>
                                                <th>Item</th>
                                                <th>Material</th>
                                                <th>Description</th>
                                                <th>Receipt Date</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>PO Number</th>
                                                <th>Warehouse</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['grdata'] as $prdata) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $prdata['grnum']; ?></td>
                                                    <td><?= $prdata['gritem']; ?></td>
                                                    <td><?= $prdata['material']; ?></td>
                                                    <td><?= $prdata['matdesc']; ?></td>
                                                    <td><?= $prdata['movementdate']; ?></td>
                                                    <td style="text-align:right;"><?= number_format($prdata['quantity'], 0, ',', '.'); ?></td>
                                                    <td><?= $prdata['unit']; ?></td>
                                                    <td><?= $prdata['ponum']; ?> | <?= $prdata['poitem']; ?></td>
                                                    <td><?= $prdata['warehouse']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
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
        $('#grlist').datagrid({
            view: detailview,
            detailFormatter:function(index,row){
                return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
            },
                onExpandRow: function(index,row){
                $('#ddv-'+index).panel({
                            border:true,
                            cache:false,
                            href:base_url + '/app/views/grpo/detailgr.php?grnum='+row.grnum+'&year='+row.year,

                            onLoad:function(){
                                $('#grlist').datagrid('fixDetailRowHeight',index);
                            }
                        });
                        $('#grlist').datagrid('fixDetailRowHeight',index);
                    },
                    width:'100%',
                    height:400,
                    singleSelect:true,
                    resizable:true,
                    fitColumns:true,
                    pagination:true,
                    pageList:[10,20,50,100,150,200],
                    idField:'grnum',
                    url:base_url+'/reports/laporangrdata/'+strdate+'/'+enddate, 
                    columns:[[
                        {field:'grnum',title:'Receipt Num',width:90},
                        {field:'keterangan',title:'Note',width:150,editor:'text',nowrap:true},
                        {field:'nmsup',title:'Vendor',width:200,editor:'text'},
                        {field:'tglterima',title:'Receipt Date',width:80,editor:'text'}
                    ]],				
            });
    </script>