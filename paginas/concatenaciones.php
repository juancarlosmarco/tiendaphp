<?php  

$id='10';
echo 'El valor es '.$id;
echo '<br>';
echo 'El valor es $id';
echo '<br>';
echo "El valor es $id";
echo '<hr>';

$vector['id']=10;
echo 'El valor es '.$vector['id'];
echo '<br>';
echo 'El valor es $vector[\'id\']';
echo '<br>';
echo "El valor es {$vector['id']}";
echo '<hr>';

$vector[0]=10;
echo 'El valor es '.$vector[0];
echo '<br>';
echo 'El valor es $vector[0]';
echo '<br>';
echo "El valor es $vector[0]";
echo '<hr>';
?>