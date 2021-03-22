<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From t_inv_i WHERE grnum = '$_GET[grnum]' and year  = '$_GET[year]'");

    $prdata = $stm->fetchAll();

?>
<table class="table table-bordered table-hover" Width='800'>
<tr>
    <th> Item </th>
    <th> Item Name </th>
    <th> Quantity </th>
    <th> Unit </th>
    <th align="right"> Price </th>
    <th> Total Price </th>
    <th> PO Num </th>
    <th> PO Item </th>
</tr>
<?php foreach ($prdata as $data) : ?>
<tr>
    <td>
        <?= $data['gritem']; ?>
    </td>
    
    <td>
        <?= $data['namabrg']; ?>
    </td>
    <td align="right">
        <?= $data['jumlah']; ?>
    </td>
    <td>
        <?= $data['satuan']; ?>
    </td>
    <td align="right">
        <?= number_format($data['harga'],0,",","."); ?>
    </td>
    <td align="right">
        <?= number_format(($data['harga'] * $data['jumlah']),0,",","."); ?>
    </td>
    <td>
        <?= $data['ponum']; ?>
    </td>
    <td>
        <?= $data['poitem']; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>