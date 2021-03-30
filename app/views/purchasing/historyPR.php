<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<td>
				<input id="strdate" name="strdate" style="width:150px" class="easyui-datebox">
			</td>
			<td>
				<input id="enddate" name="enddate" style="width:150px" class="easyui-datebox">
			</td>
			<td>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="width:200px; background: #2ecac4" onclick="readData()">Display Data</a>
			</td>
			<!-- <td>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-print'" style="width:200px; background: #2ecac4" onclick="print()">Print Data</a>
			</td>
			<td>
				<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-print'" style="width:200px; background: #2ecac4" onclick="printAll()">Print All Data</a>
			</td> -->
			<br><br>
			<table id="prlist"></table>
		</div>
	</div>
</div>

<script>
    
    function print(){		
		var row = $('#prlist').datagrid('getSelected');
		if (row){
			// window.location.href = mainurl+"/purchasing/printPR/"+row.prnum;
			window.open(mainurl+"/purchasing/printPR/"+row.prnum, '_blank');
		}else{
			$.messager.show({	
				title: 'Error',
				msg: 'No data selected'
			});
		}		
	};

	function printAll(){
		var strdate; 
		var enddate;
        strdate = $("#strdate").val();
        enddate = $("#enddate").val();
		// window.location.href = mainurl+"/purchasing/printALLPR/"+strdate+"/"+enddate;
		window.open(mainurl+"/purchasing/printALLPR/"+strdate+"/"+enddate, '_blank');	
	};

    $(document).ready(function () {	
		$('#enddate, #strdate').datebox({
			formatter: function(date) {
				var y = date.getFullYear();
				var m = date.getMonth() + 1;
				var d = date.getDate();

				var r = y + '-' + m + '-' + d;
				return r;
			},

			parser: function(s) {
				if (!s) {
					return new Date();
				}
				var ss = (s.split('-'));
				var y = parseInt(ss[0], 10);
				var m = parseInt(ss[1], 10);
				var d = parseInt(ss[2], 10);

				if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
					return new Date(y, m - 1, d);
				} else {
					return new Date();
				}
			}
		});
		var opts = $('#enddate, #strdate').datebox('options');
        $('#strdate').datebox('setValue', opts.formatter(new Date()));
		$('#enddate').datebox('setValue', opts.formatter(new Date()));
	});	

    function readData(){
        var strdate; 
		var enddate;
		var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); 
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        if($("#strdate").val() === ""){
			strdate = today; 
		}else{
			strdate = $("#strdate").val();	
		}
		
		if($("#enddate").val() === ""){
			enddate = today;
		}else{
			enddate = $("#enddate").val();
		}
		
		var z = new Date(strdate);
		var y = new Date(enddate);
        if(z > y){
			alert('Enddate must be grather than stardate');
		}else{
            var url = mainurl + '/purchasing/getHistoryPR/'+strdate+'/'+enddate;	
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
                    title:'History Purchase Requisition',
                    width:'100%',
                    height:400,
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
                        }
                    ]],				
            });
        } 
    }

    this.readData();
</script>