<?php
$koneksi;

function connectDB()
{
    global $koneksi;

    $koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($koneksi->connect_error) {
        die('Connection Failed' . $koneksi->connect_error);
    }
    return $koneksi;
}

function queryData($query)
{
    global $koneksi;

    $result = $koneksi->query($query);
    if ($result === false) {
        die("Error: " . $koneksi->error);
    }

    return $result;
}

function fetchAssoc($result)
{
    global $koneksi;
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $koneksi->close();

    return $data;
}
