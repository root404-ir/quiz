<?php

header("Content-Type: application/json");

$quiz_id = $_POST['qid'] ?? false;
$quiz_id = intval($quiz_id);

if(!$quiz_id) die('{"msg" : "quiz id invalid"}');

$quiz_content = file_get_contents("quiz-data.json");
$quiz_content = json_decode($quiz_content , true);
$is_quiz_id_exist = isset($quiz_content[$quiz_id-1]);

if(!$is_quiz_id_exist) die('{"msg" : "quiz id does not found"}');

$current_quiz = $quiz_content[$quiz_id-1];

$quiz_key = !empty($_POST['ans']) && $_POST['ans'] === "true" ? true : false;

if($quiz_key){
    $quiz_to_show = ["key" => $current_quiz['key']];
    helper_encode_array_json_print_out($quiz_to_show);
}else{
    unset($current_quiz['key']);
    helper_encode_array_json_print_out($current_quiz);
}

function helper_encode_array_json_print_out($arr){
    $arr["total"] = count($GLOBALS['quiz_content']);
    $quiz_to_show = json_encode($arr);
    echo $quiz_to_show;
}