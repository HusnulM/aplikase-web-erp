<div class="row">
	<div class="col-xs-12">
		<div class="row">
            <div class="easyui-panel" title="Form Entry" style="width:100%;max-width:100%;height:'auto';padding:10px">
                <form id="fm" method="post" novalidate enctype="multipart/form-data">
                    <table width="80%" style="margin: 10px">
                        <thead>						
                            <th>Header Text</th>
                            <th>Project</th>
                            <th>Document Date</th>
                            <th>Required Date</th>
                            <th>Currency</th>
                        </thead>
                        <tbody>
                            <td><input id="project" name="project" style="width:500px;color: black;font-size: 15px;" placeholder="Optional" data-options="prompt:'Optional'" value="<?= $data['prheader']['remark']; ?>">
                            </td>
                            <td >
                                <select id="idproject" class="easyui-dropdown" style="width: 200px" >
                                </select>
                            </td>
                            <td><input id="dcdate" name="dcdate" style="width:150px" class="easyui-datebox" readonly="true" value="<?= $data['prheader']['createdOn']; ?>">
                            </td>
                            <td>
                                <input id="rqdate" name="rqdate" style="width:150px" class="easyui-datebox" value="<?= $data['prheader']['requiredDate']; ?>">
                            </td>
                            <td>
                                <select id="curr" class="easyui-dropdown" style="width: 100px" >
                                </select>
                            </td>
                        </tbody>
                    </table>
                    <div class="hr hr10 hr-dotted"></div>
                    <table id="dg" title="PR Items" class="easyui-datagrid" style="width:100%;height:250px"
					        toolbar="#toolbar" fitColumns="false" singleSelect="true">
					    <thead>
					        <tr>
					            <!-- <th field="itemcode" width="150">Item Code</th> -->
					            <th field="text"         width="300">Item Name</th>
					            <th field="quantity"     width="120">Quantity</th>
					            <th field="unit"         width="80">Unit</th>
					            <th field="price"        width="120">Price</th>
					            <th field="totalPrice"   width="120">Sub Total</th>
					            <th field="item_remark"  width="350">Remark</th> 
					        </tr>
					    </thead>
					</table>
						<div id="toolbar">
						    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="NewItem('new')">Add New Item</a>
						    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="NewItem('edit')">Change PR Item</a>
						    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleterow()">Delete PR Item</a>
						</div>
                </form>
                <div style="margin-bottom: 10px;margin-top:5px;">							          
					<a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-ok'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="updatePR()">Save</a>

                    <!-- <a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-show'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="showData()">Show Data</a> -->
				</div>
                <!-- MessageBox -->
                <div id="smsg" class="xdialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" closable="true" toolbar="#dlg-toolbar" buttons="#dlg-buttons">
                    order created
	            </div>

                <!-- Dialog Add New Item -->
                <div id="addItem" class="zdialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" closable="true">
                    <table cellspacing="2" cellpadding="20px">

                        <tr>
                            <td><h5 style="margin-left: 30px;">Item Name </td>
                            <td style="width: 20px">:</td>
                            <td>
                                <input id="itmname" name="itmname" style="width:500px" class="easyui-textbox" required="true" />
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 100px"><h5 style="margin-left: 30px;">Required Qty </td><td>:</td>
                            <td>
                                <input id="qty" name="qty" style="width:200px" class="easyui-numberbox" required="true" data-options="min:0,precision:2,decimalSeparator:'.',groupSeparator:','"/>
                            </td>
                        </tr>

                        <tr>
                            <td><h5 style="margin-left: 30px;">Unit</td><td>:</td>
                            <td><input id="uom" name="uom" style="width:100px" class="easyui-textbox" placeholder="unit" ></td>
                        </tr>

                        <tr>
                            <td><h5 style="margin-left: 30px;">Price </td><td>:</td>
                            <td>
                                <input id="price" name="price" style="width:200px" class="easyui-numberbox" value="0" data-options="min:0,precision:0,decimalSeparator:'.',groupSeparator:','">
                            </td>
                        </tr>
                        <tr>
                            <td><h5 style="margin-left: 30px;">Total </td><td style="width: 20px">:</td>
                            <td>
                                <input id="total" name="total" style="width:200px" class="easyui-numberbox" value="0" readonly="true" data-options="min:0,precision:0,decimalSeparator:'.',groupSeparator:','"/>
                            </td>
                        </tr>
                    </table>
                    <h5 style="margin-left: 30px;">Remark</h5>
                    <div style="margin-bottom:20px; margin-left: 30px;">
                        <textarea  type="text" id="remark" name="message" style="width:90%;height:100px;"></textarea>
                    </div>
                    <div style="margin-bottom: 10px;margin-left: 30px;">							            	
                        <a href="javascript:void(0)" class="easyui-linkbutton c6" data-options="iconCls:'icon-add'" style="width:150px;height: 30px;background: #267a97;color: #fff;" onclick="addItem()">Add</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    
    let base_url = mainurl + '/purchasing/';
	var zcarnam;
	var zcarcode;
	var action;
	var rIndex;
    var prNum = ("<?= $data['prheader']['prnum']; ?>");
    var _idproj = ("<?= $data['prheader']['idproject']; ?>");
    var _nmproj = ("<?= $data['prheader']['namaproject']; ?>");
    var url = mainurl+"/purchasing/getEditPRByNum/"+prNum;	
    
	function clearForm(){
		$('#itemcode, #itmname, #uom, #dtu').textbox({
			value:''
		})
		$('#qty, #price, #total, #moq, #spq').numberbox({
			value:''
		})
		$('#remark').val("");
    }

    function showData(){		        
        $('#dg').datagrid({
            url:url
        })
        // url = "";
	}
    
    this.showData();
    
    function NewItem(param){
        // this.getCurrency();
        if(param == "new"){
            action = '';
            clearForm();
            $('#addItem').dialog({
                title: 'Add PR Item',
                width: '60%',
                height: 500,
                padding:'20px',
                closed: false,
                cache: false,
                modal: true
            });
        }else{
            var row = $('#dg').datagrid('getSelected');	
            rIndex = $("#dg").datagrid("getRowIndex", row);
            if(rIndex == "-1"){
                alert('Pilih PR Item');
            }else{
                action = 'X';
                clearForm();
                    $('#itmname').textbox({
                        iconAlign:'left',
                        value:row.text
                    })

                    $('#qty').numberbox({
                        iconAlign:'left',
                        value:row.quantity
                    })

                    $('#uom').textbox({
                        iconAlign:'left',
                        value:row.unit
                    })
                    $('#price').numberbox({
                        iconAlign:'left',
                        value:row.price
                    })

                    $('#total').numberbox({
                        iconAlign:'left',
                        value:row.totalPrice
                    })

                    $('#remark').val(row.item_remark);

                $('#addItem').dialog({
                    title: 'Edit PR Item',
                    width: '80%',
                    height: 500,
                    padding:'20px',
                    closed: false,
                    cache: false,
                    modal: true
                });
            }
        }		
    }

    $('#qty, #price').numberbox({
		"onChange":function(){  
			var a = $("#qty").val();
			var b = $("#price").val();
			var c = a * b;
			$('#total').numberbox({
				value:c
			});
		}  
	});

    function addItem(){
		var valdQty  = $("#qty").val();
		
		if(valdQty == ""){
			windowMessage("Input Quantity")
		}else{
			if (action =="X"){

				doeditRow(rIndex);
			}else{
				var count = $('#dg').datagrid('getRows');
                
				$('#dg').datagrid('appendRow',{
                    prnum       : prNum,
					pritem      : count.length + 1,
                    ItemCode    : null,
					text        : $("#itmname").val(),
					quantity    : $("#qty").val(),
					unit        : $("#uom").val(),
					price       : $("#price").val(), 
					totalPrice  : $("#total").val(),
                    currency    : null,
					item_remark : $("#remark").val(),
                    relstatus   : null,
                    ponum       : null,
                    poitem      : null
				});
			}
			$('#addItem').dialog('close');
            return;
		}
	}

    // function getCurrency(){
		$(document).ready(function(){		
            
			$.ajax({
				type:'GET',
				url:base_url + '/currencyList',
				dataType: "json",
				// data:{ItemCode:''},
				cache:false,
				success:function(results){
					var count = results.length;

					var listItems;
					for (var i = 0; i < count; i++) {
						listItems += "<option value='" + results[i].curr + "'>" + results[i].curr + "</option>";
					};
					$("#curr").html(listItems);
				}
			});
		});
	// }

    //Get Department List
    $(document).ready(function(){
		$.ajax({
			type:'GET',
			url:base_url + '/openproject',
			dataType: "json",
			cache:false,
			success:function(results){
                console.log(results);
				var icount = results.length;
				var idproject;
                idproject += "<option value='" + _idproj + "'>" + _nmproj + "</option>";
				for (var i = 0; i < icount; i++) {
					idproject += "<option value='" + results[i].idproject + "'>" + results[i].namaproject + "</option>";
				};
				$("#idproject").html(idproject);
			}
		});
	});

    $(document).ready(function () {	
        $('#dcdate, #rqdate').datebox({
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
		var opts = $('#dcdate').datebox('options');
		$('#dcdate').datebox('setValue', opts.formatter(new Date()));
        $('#rqdate').datebox('setValue', opts.formatter(new Date()));
	});

    //Save PR
    function updatePR(){
		var prNumb;
		var djson    = {};
		var jsonTemp = {};
		var dataH    = [];
		var data     = [];
        var prdata   = {};
		var rows     = $('#dg').datagrid('getRows');
        let dataLength;
		
        //Header Data
        djson.project   = $("#project").val()
		djson.idproject = $("#idproject").val()
		djson.dcdate    = $("#dcdate").val()
		djson.rqdate    = $("#rqdate").val()
        djson.currency  = $("#curr").val()
		dataH.push(djson);
        // prdata.push(djson)
        
        //Items Data
        for(var i=0; i<rows.length; i++){
            dataLength        = i + 1
            jsonTemp          = {}
			jsonTemp.prItem   = i + 1
			jsonTemp.ItemName = rows[i].text
			jsonTemp.qty      = rows[i].quantity
			jsonTemp.uom      = rows[i].unit 
			jsonTemp.price    = rows[i].price 
			jsonTemp.total    = rows[i].totalPrice
			jsonTemp.remark   = rows[i].item_remark
			data.push(jsonTemp);
		}

        prdata = {
            'header' : dataH,
            'items'  : data,
            'rows'   : dataLength
        }

        $.ajax({
			type:'POST',
			url:base_url + 'updatepr/'+prNum,
			dataType: "json",
			data:prdata,
			cache:false,
			success:function(results){
                
                if (results.msg === "sukses") {
                    $('#dg').datagrid('loadData', {"total":0,"rows":[]});
                    $('#project').val('');
					$.messager.show({	
						title: 'Success',
						msg: 'PR ' + prNum + ' updated'
					});
				} else {
					$.messager.show({	
						title: 'Error',
						msg: results.msg
					});
				}
			},error:function(err){
                alert(JSON.stringify(err))
            }
		});		
	}
    
    function deleterow(){
		var row = $('#dg').datagrid('getSelected');					
		var rowIndex = $("#dg").datagrid("getRowIndex", row);

		var index = rowIndex+1;
		$.messager.confirm('Confirm','Are you sure to delete PR item '+ index +' ?',function(r){
			if (r){
				$('#dg').datagrid('deleteRow', rowIndex);
			}
		});
	}

    function doeditRow(rowIndex) {

$('#dg').datagrid('updateRow', {
    index: rowIndex,
    row: {
        // itemcode  : $("#itemcode").val(), 
        text   : $("#itmname").val(),
        quantity 	  : $("#qty").val(),
        unit      : $("#uom").val(),
        price     : $("#price").val(),
        totalPrice    : $("#total").val(),
        item_remark    : $("#remark").val()
    }
});
}
</script>