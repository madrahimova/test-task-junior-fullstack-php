<?php
if (!isset($_POST["input"])) {
    echo json_encode(array("error" => "Пустая строка в запросе"));
    return;
}
$names = explode(",", $_POST["input"]);
$data = array();
foreach ($names as $id => $name) {
    if ($name == "") {
        echo json_encode(array("error" => "Имя участника не должно быть пустым"));
        return;
    }
    try {
        $data[] = array("name" => $name, "score" => random_int(0, 100));
    } catch (Exception $e) {
        echo json_encode(array("error" => $e->getMessage()));
        return;
    }
}
echo json_encode($data);