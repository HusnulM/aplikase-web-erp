<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From t_po02 WHERE ponum = '$_GET[ponum]'");

    $prdata = $stm->fetchAll();

?>
<table class="table table-bordered table-hover" Width='800'>
<tr>
    <th> Item </th>
    <th> Kode Barang</th>
    <th> Nama Barang </th>
    <th> Quantity </th>
    <th> Receipt Qty </th>
    <th> Unit </th>
    <th align="right"> Price </th>
    <th> Total Price </th>
    <th> Prnum </th>
    <th> Pritem </th>
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
    <td style="text-align:right;">
        <?php if (strpos($data['quantity'], '.00') !== false) {
            echo number_format($data['quantity'], 0, ',', '.');
        }else{
            echo number_format($data['quantity'], 2, ',', '.');
        } ?>
    </td>
    <td style="text-align:right;">
        <?php if (strpos($data['grqty'], '.00') !== false) {
            echo number_format($data['grqty'], 0, ',', '.');
        }else{
            echo number_format($data['grqty'], 2, ',', '.');
        } ?>
    </td>
    <td>
        <?= $data['unit']; ?>
    </td>
    <td style="text-align:right;">
        <?= number_format($data['price'],0,",","."); ?>
    </td>
    <td style="text-align:right;">
        <?= number_format(($data['price'] * $data['quantity']),0,",","."); ?>
    </td>
    <td>
        <?= $data['prnum']; ?>
    </td>
    <td>
        <?= $data['pritem']; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>