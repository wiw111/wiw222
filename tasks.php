<?php
// Verificar la existencia del archivo de tareas
if (file_exists('tasks.php')) {
    echo "[OK] Tasks File Exist"; // Si existe, muestra un mensaje de éxito
} else {
    echo "[ERROR] Tasks File NOT Exist"; // Si no existe, muestra un mensaje de error y finaliza el script
    return;
}

// Función para agregar una nueva tarea al archivo
function addTask($name, $desc) {
    // Establecer el estado predeterminado de la tarea
    $status = "Not finished";

    // Leer el contenido del archivo de tareas
    $tasks = file_get_contents("tasks.php");

    // Dividir las líneas del archivo en un array
    $lines = explode("\n", $tasks);

    // Obtener el ID de la última tarea
    $lastTask = end($lines);
    $lastTaskId = explode(",", $lastTask)[0];
    $newTaskId = intval($lastTaskId) + 1; // Incrementar el ID para la nueva tarea

    // Crear la nueva línea de tarea
    $newTask = $newTaskId . "," . $name . "," . $desc . "," . $status;

    // Verificar si la última línea está vacía
    if (empty(trim($lastTask))) {
        // Si la última línea está vacía, sobrescribir la última línea con la nueva tarea
        $lines[count($lines) - 1] = $newTask;
    } else {
        // Si no está vacía, agregar la nueva tarea al final del archivo en una nueva línea
        $lines[] = $newTask;
    }

    // Escribir las tareas actualizadas de nuevo al archivo
    file_put_contents("tasks.php", implode(PHP_EOL, $lines));
}

// Función para mostrar todas las tareas
function showTasks() {
    // Leer el contenido del archivo de tareas
    $file = 'tasks.php';
    $data = file_get_contents($file);

    // Dividir las líneas del archivo en un array
    $lines = explode("\n", $data);

    // Mostrar el encabezado de la lista de tareas
    echo "\n";
    echo "===== TASK LIST =====";

    // Iterar sobre cada línea del archivo
    foreach ($lines as $line) {
        // Dividir los datos de la tarea por comas
        $taskData = explode(",", $line);
        $id = trim($taskData[0]);
        $name = trim($taskData[1]);
        $description = trim($taskData[2]);
        $status = trim($taskData[3]);

        // Mostrar los detalles de la tarea
        echo "\n";
        echo "===================\n";
        echo "ID: $id\n";
        echo "Task name: $name\n";
        echo "Description: $description\n";
        echo "Status: $status\n";
        echo "===================\n";
    }
}

// Función para marcar una tarea como "Finalizada"
function finishTask($taskId) {
    // Leer el contenido del archivo de tareas
    $tasks = file_get_contents("tasks.php");
    $lines = explode("\n", $tasks);

    // Iterar sobre cada línea del archivo
    foreach ($lines as &$line) {
        // Dividir los datos de la tarea por comas
        $task = explode(",", $line);
        $taskId = trim($task[0]);

        // Si el ID de la tarea coincide con el ID proporcionado
        if ($taskId == $taskId) {
            $task[3] = "Finished"; // Cambiar el estado a "Finished"
            // Actualizar la línea de la tarea
            $line = implode(",", $task);
            // Romper el bucle una vez que se haya encontrado y actualizado la tarea
            break;
        }
    }

    // Guardar las tareas actualizadas en el archivo
    file_put_contents("tasks.php", implode("\n", $lines));
}

// Función para eliminar una tarea
function deleteTask($taskId) {
    // Leer el contenido del archivo de tareas
    $tasks = file_get_contents("tasks.php");
    $lines = explode("\n", $tasks);

    // Crear un nuevo array vacío para almacenar las líneas que no coincidan con el ID de la tarea a eliminar
    $newLines = [];

    // Iterar
