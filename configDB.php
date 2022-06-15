<?php
const HOST = 'localhost';
const USER = 'root';
const PASSWORD = '';
const DATABASE = 'quiz';

// INSERT, UPDATE, DELETE
function execute($query)
{
    $connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    $responseResult = mysqli_query($connect, $query);
    mysqli_close($connect);
    return array('response' => $responseResult ? 'success' : 'fail');
}

// SELECT
function executeResult($query, $isSingle = false)
{
    $responseData = null;
    $connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

    $responseResult = mysqli_query($connect, $query);
    if ($isSingle) {
        $responseArray = mysqli_fetch_array($responseResult, MYSQLI_ASSOC);
        $responseData = $responseArray;
    } else {
        if (mysqli_num_rows($responseResult) != 1) {
            $data = [];
            while ($row = mysqli_fetch_array($responseResult, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $responseData = $data;
        } else {
            $responseArray = mysqli_fetch_array($responseResult, MYSQLI_ASSOC);
            $responseData = $responseArray;
        }
    }

    mysqli_close($connect);
    return $responseData;
}