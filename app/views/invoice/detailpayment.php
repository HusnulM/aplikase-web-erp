<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From t_invoice02 WHERE ivnum = '$_GET[ivnum]' AND ivyear = '$_GET[year]'");

    $prdata = $stm->fetchAll();

?>
<table class="table table-bordered table-hover" Width='800'>
<tr>
    <th> Item </th>
    <th> PO Num </th>
    <th> PO Item </th>
    <th> Item Name </th>
    <th> Quantity </th>
    <th> Unit </th>
    <th align="right"> Price </th>
    <th> Total Price </th>
    <th> Receipt Num </th>
    <th> Receipt Item </th>
</tr>
<?php foreach ($prdata as $data) : ?>
<tr>
    <td>
        <?= $data['ivitem']; ?>
    </td>
    
    <td>
        <?= $data['ponum']; ?>
    </td>
    <td>
        <?= $data['poitem']; ?>
    </td>
    <td>
        <?= $data['namabrg']; ?>
    </td>
    <td align="right">
        <?= $data['quantity']; ?>
    </td>
    <td>
        <?= $data['unit']; ?>
    </td>
    <td align="right">
        <?= number_format($data['price'],0,",","."); ?>
    </td>
    <td align="right">
        <?= number_format(($data['price'] * $data['quantity']),0,",","."); ?>
    </td>
    <td>
        <?= $data['refdoc']; ?>
    </td>
    <td>
        <?= $data['refdocitem']; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>