<?php


echo '<form>
    <p><b>Введите пример</b></p>
    <p><input type="text" name="math" value="=10*$n">
    <p><b>Введите $n</b></p>
    <p><input type="text" name="col" value="10">
     <input type="button" value="ОК" onClick="alert(tryCalc(this.form.math.value,this.form.col.value))"></p>
  </form>';

require ('assets/snippets/shop/include/config.inc.php');

$code_tr= isset($code_tr) ? $code_tr : 0;
$Form_ch= isset($Form_ch) ? $Form_ch : 1;

if ($Form_ch==1){
    $numorder=isset($numorder) ? $numorder : $_GET['zakaz'];
    $id_p = isset($id_p) ? $id_p : $_GET['id'];
    $code = isset($code) ? $code : md5($_GET['pass']);
    echo "<br />";
    echo '<form action=""  method="get" >';
    echo '<input name="id" type="hidden" value="'.$id_p.'">';
    echo '<p>Номер заказа<input name="zakaz" type="text" size="40" value="'.$_GET['zakaz'].'"></p>';
    echo '<p>Код на просмотр<input name="pass" type="text" size="40" value="'.$_GET['pass'].'"></p>';
    echo '<p><input type="submit"value="Просмотр"></p>';
    echo ' </form>';
    echo "<br />";
}else{
    $numorder=isset($numorder) ? $numorder : 0;
    $id_p = isset($id_p) ? $id_p : 0;
    $code = isset($code) ? $code : 0;
};

if (strlen($numorder)>0){

    $table = $modx->getFullTableName( 'shop_order_detail');
    $sql="SELECT *
        FROM  ".$table."
        WHERE  `numorder` =".$numorder;

    $res1=$modx->db->query($sql);


    $table = $modx->getFullTableName( 'shop_numorder' );
    $sql="SELECT *
        FROM  ".$table."
        WHERE  `numorder` =".$numorder;

if ($code_tr==0)  $sql.= " AND `code` ='".$code."'";

    $res2=$modx->db->query($sql);
    $row2 = $modx->db->getRow($res2);

    $table = $modx->getFullTableName( 'shop_order' );
    $sql="SELECT *
        FROM  ".$table."
        WHERE  `numorder` =".$numorder;;
    $res3=$modx->db->query($sql);
    $row3 = $modx->db->getRow($res3);

if (strlen($row2["numorder"])>0){
    echo "<br />";
    echo "<table border=1>";

    echo "<tr><td colspan='2'>Данные заказа </td></tr>";
    echo "<tr><td>Номер заказа  </td><td><b>".$row3["numorder"]."</b></td></tr>";
    echo "<tr><td>Дата заказа </td><td><b>".$row3["dateorder"]."</b></td></tr>";
    echo "<tr><td>Номер счета </td><td><b>".$row2["key"]."</b></td></tr>";
    echo "<tr><td>Статус заказа </td><td><b>".$row3["status"]."</b></td></tr>";

    echo "<tr><td colspan='2'>Данные заказчика </td></tr>";
    echo "<tr><td>Полное наименование организации </td><td><b>".$row3["fio"]."</b> </td></tr>";
    echo "<tr><td>Тип доставки </td><td><b>".$row3["dostavka"]."</b> </td></tr>";
//echo "<tr><td>Дисконт: Карта [+shop.mail.discountcard+] ([+shop.mail.discount+]%) </td></tr>";
    echo "<tr><td>Город доставки </td><td><b>".$row3["city"]."</b> </td></tr>";
    echo "<tr><td>Адрес доставки </td><td><b>".$row3["adress"]."</b> </td></tr>";
    echo "<tr><td>Телефон для связи </td><td><b>".$row3["phone"]."</b> </td></tr>";
    echo "<tr><td>E-mail </td><td><b>".$row3["email"]."</b> </td></tr>";

    echo "<tr><td colspan='2'>Комментарии к заказу </td></tr>";
    echo "<tr><td>Пользователь</td><td><b>".$row3["comments"]."</b></td></tr>";
    echo "<tr><td>Менеджер</td><td><b>".$row3["commentadmin"]."</b></td></tr>";

    echo "</table>";
    echo "<br />";
    echo "<br />";

    echo 'Содержание заказа';
    echo '<table border="1" width="90%"><tr><th>№</th><th>Артикул</th><th>Название товара</th><th>Кол-во</th><th>Цена</th></tr>';

    $i=1;
    while ($row1 = $modx->db->getRow($res1))  {
        echo '<tr><td align="center">';
        echo $i;
        $i++;
        echo '</td><td align="center">';
        echo $row1['id'];
        echo '</td><td align="left">';
        echo $row1['name'];
        echo '</td><td align="center">';
        echo $row1['quantity'];
        echo '</td><td align="center">';
        echo $row1['price'];
        echo '</td></tr>';
    };

    echo '<tr><td colspan="4" align="right">ПОДИТОГ:</td><td colspan="1" align="center">'.$row3['subtotal'].'</td></tr>';
    echo '<tr><td colspan="4" align="right">ОТГРУЗКА:</td><td colspan="1" align="center">'.$row3['dostprice'].'</td></tr>';
    if ($DisplayDiscount=="true") {
        echo '<tr><td colspan="3" align="right">';
        echo 'СКИДКА:';
        echo '</td><td colspan="1" align="center">';
        echo $row3['discount'];
        echo '</td><td colspan="1" align="center">';
        echo $row3['discountsize'];
        echo '</td></tr>';
    }
    echo '<tr><td colspan="4" align="right">';
    echo 'ВСЕГО:';
    echo '</td><td colspan="1" align="center">';
    echo $row3['total'];
    echo '</td></tr>';
    echo '</table>';
}else{
    echo 'ОШИБОЧНЫЕ&nbsp;ДАННЫЕ';
}};

?>
