<?php

$data = array(
    'shouldHideA' => $shouldHideA,
    'shouldHideB' => $shouldHideB,
    'shouldHideC' => $shouldHideC,
    'shouldHideD' => $shouldHideD,
    'shouldHideE' => $shouldHideE,
    'shouldHideF' => $shouldHideF
);

header('Content-Type: application/json');
echo json_encode($data);
?>
