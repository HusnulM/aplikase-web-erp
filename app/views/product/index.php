<div class="row">
	<div class="col-xs-12">
        <table id="dg" title="Product List" class="easyui-datagrid" style="width:'100%';height:400px"
			url="<?= BASEURL; ?>/product/productList" toolbar="#toolbar" pagination="true" fitColumns="false" singleSelect="true">
			<thead>
				<tr>
					<th field="ItemCode" width="150">Item Code</th>
					<th field="ItemName" width="400">Item Name</th>
					<th field="ItemGroup" width="100">Item Group</th>
					<th field="ItmsGrpNam" width="150">Item Group Name</th>
		    		<th field="ItemUnit" width="100">Inventory Uom</th>
				</tr>
			</thead>
		</table>
        <div id="toolbar">
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-new" plain="true" onclick="newProduk()">Add New Product</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="editProduct()">Change Product</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="deleteProduct()">Remove Product</a>
		</div>
    </div>

    <div id="newProduk" class="ydialog" iconCls="icon-ok" minimizable="false" maximizable="false" collapsible="false" closable="true" style="padding: 10px 20px;">
        <fieldset>
			<label class="block clearfix">
				<span class="block input-icon input-icon-right">
				<input type="text" id="itemcode" name="itemcode" class="form-control" placeholder="Item Code" />
				</span>
			</label>

			<label class="block clearfix">
				<span class="block input-icon input-icon-right">
				<input type="text" id="itemname" name="itemname" class="form-control" placeholder="item Name" required/>
				</span>
			</label>

			<label class="block clearfix">
				<select id="itmgrp" class="easyui-dropdown form-control">
				</select>
            </label>

			<label class="block clearfix">
				<span class="block input-icon input-icon-right">
				<input type="text" id="itemuom" name="itemuom" class="form-control" placeholder="item Unit" required/>
				</span>
			</label>
		</fieldset>
    </div>
</div>

<script>
    let base_url = window.location.origin;

    $(function(){
		var dg = $('#dg').datagrid({

		});
		// dg.datagrid('enableFilter', [{}]);
	});

    // this.getItemGroup();

    //Create New Product
    function newProduk(){
        
        $('#itemcode, #itemname, #itemuom').val('');
		$('#newProduk').dialog({
			title: 'Add New Product',
			width: 500,
			height: 320,
			closed: false,
			cache: false,
			modal: true,
			buttons:[{
				text:'Create',
				iconCls:'icon-save',
				width:'100px',
				handler:function(){
					if($('#itemcode').attr("value") == ""){
						$.messager.show({    
							title: 'Warning',
							msg: 'Please input Itemcode'
						});
					}else if($('#itemname').attr("value") == ""){
						$.messager.show({    
							title: 'Warning',
							msg: 'Please input Itemname'
						});
					}else{
						var prodData = {
								itemcode  : $('#itemcode').val(),
								itemname  : $('#itemname').val(),
								itemgroup : $('#itmgrp').val(),
								itemuom   : $('#itemuom').val()
							}					
                            
							$.ajax({
								type:'POST',
								url:base_url + '/webpr/product/create',
								dataType: "json",
								data:prodData,
								cache:false,
								success:function(results){
									console.log(results);
									if(results == "sukses"){
										$('#newProduk').dialog('close');
										$.messager.show({    
											title: 'Sukses',
											msg: "New Product Created"
										});
                                        $('#dg').datagrid('reload');
									}else{
										$.messager.show({
											title: 'Warning',
											msg: "Error"
										});
									}

								}
							});
					}
				}
			},
			{
				text:'Cancel',
				iconCls:'icon-cancel',
				width:'100px',
				handler:function(){
					$('#newUserdlg').dialog('close');
				}
			}
			]
		});
    }

    function deleteProduct(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to delete product?',function(r){
				if (r){
					$.post(base_url + '/webpr/product/delete',{id:row.ItemCode},function(result){
						if (result == "sukses") {
							$('#dg').datagrid('reload');
							$.messager.show({	
								title: 'Sukses',
								msg: 'Product ' + row.ItemCode + ' deleted'
							});	
						} else {
							$.messager.show({	
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		}
	}  
        // let url = base_url + '/webpr/product/productGroup';
        let itmgrpitems;
        $(document).ready(function(){
            $.ajax({
                type:'GET',
                url: base_url + '/webpr/product/productGroup',
                dataType: "json",
                data:{user_id:''},
                cache:false,
                success:function(results){
                    
                    var count = results.length;
                    console.log(results);                   
                    console.log(results.length);
                    itmgrpitems = '<option value="0">--Select Item Group--</option>';
                    for (var i = 0; i < count; i++) {
                        itmgrpitems += "<option value='" + results[i].ItemGroup + "'>" + results[i].description + "</option>";
                    };
                    $("#itmgrp").html(itmgrpitems);
                    
                }
            });
        });
    

</script>