<?php
$jsonData = file_get_contents('./datos.json');
// Decodifica el JSON en un arreglo asociativo
$dataArray = json_decode($jsonData, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="container_principal">
        <div class="container_addtodo">
            <h1>My ToDo App</h1>
            <form action="actionTodo.php"  method="post">
                <label for="">New ToDo:</label>
                <input type="text" name="todo">
                <input type="submit" value="add toDo" class="btn_add">
            </form>
        </div>
        <div class="container_table">
            <table border="1px">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ToDo</th>
                        <th>Status</th>
                        <th>Operation</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($dataArray !== null) : ?>
                        <?php foreach ($dataArray["todos"] as $key) : ?>
                            <tr class="<?php echo("table_row_".(!$key["completed"]?"uncheked":"checked")); ?>">
                                <td><input type="checkbox" name="completed" <?php echo $key["completed"] ? "checked":NULL; ?>></td>
                                <td><?php echo $key["todo"] ?></td>
                                <td><?php echo $key["completed"] ? "Completed" : "Incompleted" ?></td>
                                <td>
                                    <form method="get" action="actionTodo.php">
                                        <input type="hidden" name="idTodo" value=<?php echo $key["id"];?>>
                                        <input class="btn_op" type="submit" value=<?php echo($key["completed"]?"Uncheck":"Check") ?> name="operation">
                                        <input class="btn_op" type="submit" value="Delete" name="operation">
                                    </form>
                                </td>
                                <td><?php echo $key["id"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : echo "Error al decodificar el JSON."; endif;?> 
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>