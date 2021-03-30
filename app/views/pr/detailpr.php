<?php
    require_once '../../config/config.php';

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME."";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    $stm = $pdo->query("SELECT * From t_pr02 WHERE prnum = '$_GET[prnum]'");

    $prdata = $stm->fetchAll();

    // echo json_encode($prdata);
?>
<table class="table table-bordered table-hover" Width='800'>
<tr>
    <!-- <th> Order No. </th> -->
    <th> Item </th>
    <th> Material </th>
    <th> Deskripsi </th>
    <th style="text-align:right;"> Quantity </th>
    <th> Unit </th>
    <th> Remark </th>
</tr>
<?php foreach ($prdata as $data) : ?>
<tr>
    <td>
        <?= $data['pritem']; ?>
    </td>
    <td>
        <?= $data['material']; ?>
    </td>
    <td>
        <?= $data['matdesc']; ?>
    </td>
    <td style="text-align:right;">
        <?php if (strpos($data['quantity'], '.00') !== false) {
            echo number_format($data['quantity'], 0, ',', '.');;
        }else{
            echo number_format($data['quantity'], 2, ',', '.');;
        } ?>        
    </td>
    <td>
        <?= $data['unit']; ?>
    </td>
    <td>
        <?= $data['remark']; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>