<div class="row">
	<div class="col-xs-12">
		<div class="row">
            <table id="prlist"></table>
        </div>

        <div id = "dlgMsg" class = "easyui-dialog" style = "width: 360px; height: 150px; padding: 10px 20px"
			closed = "true" buttons = "#dlgMsg-buttons" closable= "false">

            <form id = "fm" method = "post">				
				<div class = "fitem">
					<label id="txtMsg" style="width: 350px"> </label>
				</div>
			</form>

			<div id = "dlgMsg-buttons">
				<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="closeMsgWindow()"> Ok </a>
			</div>
        </div>
    </div>
</div>

<script>
    $(function(){
		var url = mainurl + '/purchasing/getOpenPR';	
		$('#prlist').datagrid({
			view: detailview,
			detailFormatter:function(index,row){
				return '<div id="ddv-' + index + '" style="padding:5px 0"></div>';
			},
			onExpandRow: function(index,row){
				$('#ddv-'+index).panel({
					border:true,
					cache:false,
					href:mainurl + '/app/views/purchasing/detailpr.php?prnum='+row.prnum,

					onLoad:function(){
						$('#prlist').datagrid('fixDetailRowHeight',index);
					}
				});
				$('#prlist').datagrid('fixDetailRowHeight',index);
			},
			title:'List Purchase Requisition',
			width:'100%',
			height:420,
			singleSelect:true,
			resizable:true,
			fitColumns:true,
			pagination:true,
			pageList:[20,50,100,150,200],
			idField:'prnum',
			url:url, 
			columns:[[
			{field:'prnum',title:'PR Num',width:90},
			{field:'remark',title:'Header Text',width:150,editor:'text',nowrap:true},
			{field:'createdBy',title:'Created By',width:80,editor:'text'},
			{field:'createdOn',title:'Created Date',width:80,editor:'text'},
			{field:'requiredDate',title:'Required Date',width:100,editor:'text'},
			{field:'currency',title:'Currency',width:100,editor:'text'},
			{field:'Status',title:'Aprooval Status',width:100,editor:'text',
				styler: function(value,row,index){
					if (row.approveStat == "1") {
						return 'background-color:#3ea5ef;color:black;font-weight: bold;';
					}else if (row.approveStat == "2") {
						return 'background-color:red;color:white;font-weight: bold;';
					}else if (row.approveStat == "3") {
						return 'background-color:#c57530;color:white;font-weight: bold;';
					}else if (row.approveStat == "4") {
						return 'background-color:#c57530;color:white;font-weight: bold;';
					}else if (row.approveStat == "5") {
						return 'background-color:#c57530;color:white;font-weight: bold;';
					}else{
						return 'background-color:yellow;color:black;font-weight: bold;';
					}
				}
			},
			{field:'Action',title:'',width:60,align:'center',
				formatter:function(value,row,index){
					var a = '<a href="javascript:void(0)" onclick="approve(this)">Approve</a>';
					return a;
				},
				styler: function(value,row,index){
					return 'background-color:white;color:blue;';
				}
			},
			{field:'Reject',title:'',width:60,align:'center',
				formatter:function(value,row,index){
					var a = '<a href="javascript:void(0)" onclick="reject(this)">Reject</a>';
					return a;
				},
				styler: function(value,row,index){
					return 'background-color:white;color:blue;';
				}
			}
			]],				
        });
	});

    function approve(target){
        var rows   = $(target).closest('tr.datagrid-row');
		var index  = (rows.attr('datagrid-row-index'));
		var prnum  =$('#prlist').datagrid('getRows')[index].prnum;
        
        $.ajax({
			type:'POST',
			url:mainurl + '/purchasing/approvePR',
			dataType: "json",
			data:{prnum : prnum},
			cache:false,
			success:function(results){
				if (results.msg === "sukses") {
                    $('#prlist').datagrid('reload');
					$.messager.show({	
						title: 'Sukses',
						msg: 'PR ' + prnum + ' Approved'
					});
				} else {
					$.messager.show({	
						title: 'Error',
						msg: results.msg
					});
				}
			}
		});        
    }

	function reject(target){
        var rows   = $(target).closest('tr.datagrid-row');
		var index  = (rows.attr('datagrid-row-index'));
		var prnum  =$('#prlist').datagrid('getRows')[index].prnum;
        
        $.ajax({
			type:'POST',
			url:mainurl + '/purchasing/rejectPR',
			dataType: "json",
			data:{prnum : prnum},
			cache:false,
			success:function(results){
				if (results.msg === "sukses") {
                    $('#prlist').datagrid('reload');
					$.messager.show({	
						title: 'Sukses',
						msg: 'PR ' + prnum + ' Rejected'
					});
				} else {
					$.messager.show({	
						title: 'Error',
						msg: results.msg
					});
				}
			}
		});        
    }

	function cancelapprove(target){
		var rows   = $(target).closest('tr.datagrid-row');
		var index  = (rows.attr('datagrid-row-index'));
		var prnum  =$('#prlist').datagrid('getRows')[index].prnum;
        
        $.ajax({
			type:'POST',
			url:mainurl + '/purchasing/rejectPR',
			dataType: "json",
			data:{prnum : prnum},
			cache:false,
			success:function(results){
				if (results.msg === "sukses") {
                    $('#prlist').datagrid('reload');
					$.messager.show({	
						title: 'Sukses',
						msg: 'PR ' + prnum + ' Rejected'
					});
				} else {
					$.messager.show({	
						title: 'Error',
						msg: results.msg
					});
				}
			}
		}); 
	}
</script>