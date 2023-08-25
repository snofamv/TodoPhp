EJEMPLOS

<?php
$uniqueId = uniqid('ID_', true);
$jsonFilePath = 'datos.json';
$jsonContent = file_get_contents($jsonFilePath);
// Paso 2: Decodificar el JSON
$data = json_decode($jsonContent, true); // Si el segundo argumento es 'true', decodifica como array asociativo
// Crear el nuevo todo
$newTodo = array("id" => $uniqueId, "todo" => $_POST["todo"], "completed" => false);
// agregarlo a la lista en memoria
try {
    array_push($data["todos"], $newTodo);
    // modificar contenido json 
    $newJsonContent = json_encode($data, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT agrega formato legible
    // Paso 5: Escribir en el archivo
    file_put_contents($jsonFilePath, $newJsonContent);
} catch (\Throwable $th) {
    echo $th->getMessage();
} finally {
    header("Location: index.php");
}
