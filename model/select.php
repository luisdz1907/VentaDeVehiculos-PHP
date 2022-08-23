<?php 
include_once '../admin/config/db.php';
$db = conectarDB();

//Consultar modelo por su id
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $query = mysqli_query($db, "SELECT * FROM modelo WHERE fk_marca = $id");
    
    while($row = mysqli_fetch_assoc($query)){
        echo '<option value="'.$row['precio_unidad'].'-'.$row['id_modelo'].'">'.$row['nombre_modelo'].'</option>';
    }
}
?>