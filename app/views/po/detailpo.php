<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From v_po004 WHERE ponum = '$_GET[ponum]'");

    $prdata = $stm->fetchAll();

?>
<div class="table-responsive">
<table class="table table-stripped table-bordered table-hover" Width='100%'>
<tr>
        <th> Item </th>
        <th> Kode Barang</th>
        <th> Nama Barang </th>
        <th> Jenis Sparepart </th>
        <th> Quantity </th>
        <th> Receipt Qty </th>
        <th> Unit </th>
        <th style="text-align:right;"> Price </th>
        <th style="text-align:right;"> Discount </th>
        <th style="text-align:right;"> TAX </th>
        <th> Total Price </th>
        <th> Prnum </th>
        <th> Pritem </th>
        <th> Status</th>
        <th> Tgl Approve/Reject</th>
</tr>
<?php foreach ($prdata as $data) : ?>
<tr>
        <td>
            <?= $data['poitem']; ?>
        </td>
        <td>
            <?= $data['material']; ?>
        </td>
        <td>
            <?= $data['matdesc']; ?>
        </td>
        <td>
            <?= $data['mattypedesc']; ?>
        </td>
        <td style="text-align:right;">
            <?php if (strpos($data['quantity'], '.00') !== false) {
                echo number_format($data['quantity'], 0, ',', '.');;
            }else{
                echo number_format($data['quantity'], 2, ',', '.');;
            } ?>   
        </td>
        <td style="text-align:right;">
            <?php if (strpos($data['grqty'], '.00') !== false) {
                echo number_format($data['grqty'], 0, ',', '.');;
            }else{
                echo number_format($data['grqty'], 2, ',', '.');;
            } ?>   
        </td>
        <td>
            <?= $data['unit']; ?>
        </td>
        <td style="text-align:right;">
            <?php if (strpos($data['price'], '.00') !== false) {
                echo number_format($data['price'], 0, ',', '.');;
            }else{
                echo number_format($data['price'], 2, ',', '.');;
            } ?>  
        </td>
        <td style="text-align:right;">
            <?php if (strpos($data['discount'], '.00') !== false) {
                echo number_format($data['discount'], 0, ',', '.');;
            }else{
                echo number_format($data['discount'], 2, ',', '.');;
            } ?>  
        </td>
        <td style="text-align:right;">
            <?= $data['ppn']; ?>%
        </td>
        <td style="text-align:right;">
            <?php if (strpos($data['subtotal'], '.00') !== false) {
                echo number_format($data['subtotal'], 0, ',', '.');
            }else{
                echo number_format($data['subtotal'], 2, ',', '.');
            } ?>  
        </td>
        <td>
            <?= $data['prnum']; ?>
        </td>
        <td>
            <?= $data['pritem']; ?>
        </td>

        <?php if($data['approvestat'] === '1') : ?>
            <td style="background-color:yellow;color:black;font-weight: bold;">
                Open
            </td>
        <?php elseif($data['approvestat'] === '5') : ?>
            <td style="background-color:red;color:white;font-weight: bold;">
                Rejected by <?= $data['approvedby']; ?>
            </td>             
        <?php else : ?>
            <td style="background-color:green;color:white;font-weight: bold;">
                Approved by <?= $data['approvedby']; ?>
            </td> 
        <?php endif; ?>

        <td>
            <?= $data['approvedate']; ?>
        </td>
</tr>
<?php endforeach; ?>
</table>
</div>   