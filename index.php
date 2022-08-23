<?php 
include './template/header.php'; 
include './admin/config/db.php';
$db = conectarDB();
//Consultar Marca
$result = mysqli_query($db,"SELECT * FROM marca");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

   //Array de alertas
    $errores = [];
    $success = '';
    $resultado = '';

    $precioAndIdModelo = explode("-",$_POST['selectModelo'] ?? '');//limpiamos la variable eliminamos el -
    $stock = $_POST['stock'];


    if (!$stock || empty($stock)) {
        $errores[] = "Debes añardir una cantidad.";
    }
    if (!$precioAndIdModelo[0] || empty($precioAndIdModelo[0])) {
        $errores[] = "Debes escoger un modelo.";
    }


    //Revisamos que el arreglo de errores este vacio
    if (empty($errores)) {
        $totalV = (int)$stock * (float)$precioAndIdModelo[0];
        $query = "INSERT INTO ventas (cantidad, total_venta, fk_modelo) VALUES ($stock, $totalV,$precioAndIdModelo[1])";
        $queryUpdate= "UPDATE modelo SET stock = stock - $stock  WHERE id_modelo = $precioAndIdModelo[1]";
        $resultado = mysqli_query($db,$query);
        $resultado = mysqli_query($db,$queryUpdate);
        $success = "Venta agregada correctamente.";
    }
}


//Consultamos las tablas relacionadas y las unimos
$resultTbl = mysqli_query($db,"SELECT * FROM ventas v 
    INNER JOIN modelo m ON v.fk_modelo = m.id_modelo
    INNER JOIN marca r ON m.fk_marca = r.id_marca"
    );

//Funcion que me permite eliminar
    if (isset($_GET['id'])) {
        $id=(int) $_GET['id'];
        $query = mysqli_query($db,"DELETE FROM ventas WHERE id_venta= $id");
    }

?>


<br>
<div class="col-md-5">
    <?php 
    if (!empty($errores)) {
     foreach($errores as $error){
        echo '<div class="alert alert-danger error" role="alert">'.$error.'</div>';
        }
    }else if (!empty($resultado)) {
        echo '<div class="alert alert-success success" role="alert">'.$success.'</div>';
    }
    ?>
    <div class="card">
        <div class="card-header">
            Registrar Venta
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <!-- <div class="form-group">
                    <label for="nombre">Nombre del Cliente</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Cliente">
                </div> -->

                <div class="form-group">
                    <label for="">Elegir Marca</label>
                    <select class="form-control" name="" id="marca" onchange="selectMarca()">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?php echo $row['id_marca']?>"><?php echo $row['nombre_marca']?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Elegir Modelo</label>
                    <select class="form-control" name="selectModelo" id="modelo" disabled>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Cantidad</label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Cantidad">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" value="" class="btn btn-s">Agregar venta</button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="col-md-7">

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Total Venta</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $resultTbl->fetch_array()):?>
            <tr>
                <td><?php echo $row['nombre_marca']; ?></td>
                <td><?php echo $row['nombre_modelo']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td>$<?php echo number_format($row['total_venta'],2); ?></td>
                <td>
                    <a href="?id=<?php echo $row['id_venta']; ?>" id="eliminar" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endwhile?>
        </tbody>
    </table>
</div>
<?php include './template/footer.php'; ?>