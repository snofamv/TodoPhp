<?php
// Paso 2: Decodificar el JSON
// Si el segundo argumento es 'true', decodifica como array asociativo
$jsonFilePath = 'datos.json';
$jsonContent = file_get_contents($jsonFilePath);
$data = json_decode($jsonContent, true);
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    // parametros
    $idTodoParam = $_GET["idTodo"];
    $operation = $_GET["operation"];
    //evaluacion de valores
    if (!empty($operation) && !empty($idTodoParam)) {
        if ($operation === "Delete") {
            // Filtrar el array y eliminar el dato
            foreach ($data["todos"] as $index => $value) {
                if ($value["id"] == $idTodoParam) {
                    unset($data["todos"][$index]);
                    break; // Terminar el bucle después de encontrar y eliminar el dato
                }
            }
        } else if ($operation === "Check" || "Uncheck") {
            foreach ($data["todos"] as $index => $value) {
                if ($value["id"] == $idTodoParam) {
                    $data["todos"][$index]["completed"] = !$data["todos"][$index]["completed"];
                    break;
                }
            }
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $todoParam = empty($_POST["todo"]) ? "Empty ToDo" : $_POST["todo"];
    $uniqueId = uniqid('ID_', true);
    $newTodo = array("id" => $uniqueId, "todo" => $todoParam, "completed" => false);
    array_push($data["todos"], $newTodo);
}else{
    header("Location: index.php");
}
// Reorganizar los índices del array resultante // opcional
// $newArray["todos"] = array_values($data["todos"]);

try {
    // modificar contenido json 
    $newJsonContent = json_encode($data, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT agrega formato legible
    // Paso 5: Escribir en el archivo
    file_put_contents($jsonFilePath, $newJsonContent);
} catch (\Throwable $th) {
    echo $th->getMessage();
} finally {
    header("Location: index.php");
}
