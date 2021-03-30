<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From tblpritem WHERE prnum = '$_GET[prnum]'");

    $prdata = $stm->fetchAll();

    // echo json_encode($prdata);
?>
<table class="table table-bordered table-hover" Width='800'>
<tr>
    <!-- <th> Order No. </th> -->
    <th> Item </th>
    <!-- <th> Item Code </th> -->
    <th> Item Name </th>
    <th> Quantity </th>
    <th> Unit </th>
    <th> Price </th>
    <th> Total </th>
    <th> Remark </th>    
</tr>
<?php foreach ($prdata as $data) : ?>
<tr>
    <td>
        <?= $data['pritem']; ?>
    </td>
    
    <td>
        <?= $data['text']; ?>
    </td>
    <td>
        <?= $data['quantity']; ?>
    </td>
    <td>
        <?= $data['unit']; ?>
    </td>
    <td>
        <?= $data['price']; ?>
    </td>
    <td>
        <?= $data['totalPrice']; ?>
    </td>
    <td>
        <?= $data['item_remark']; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>