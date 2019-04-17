<?php
if ($_GET['action'] == "Input") {
  echo insert_string($_GET['str']);
}

function insert_string($str) {
  // $input_string = "5 3 cat map bat man pen 4 ?at ma? ?a? ??n";
  $string_arr = (explode(" ", $str));
  $words_arr = [];
  $queries_arr = [];

  foreach ($string_arr as $ar) {
    if (!preg_match('/[^a-zd]/', $ar)) {
      $words_arr[] = $ar;
    }
    else {
      if (!is_numeric($ar)) {
        $queries_arr[] = str_replace('?', '', $ar);
      }
    }
  }

  $words_string = implode(" ", $words_arr);
  foreach ($queries_arr as $query) {
    $output.= substr_count($words_string, $query);
  }
  return $output;
}
