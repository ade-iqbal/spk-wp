<?php
require_once "functions/kriteria.php";
require_once "functions/alternatif.php";

$kriteria = new Kriteria;
$alternatif = new Alternatif;

if($_GET["action"] === "update" && $_GET["menu"] === "kriteria"){
    $kriteria->updateKriteria($_POST);
}
else if($_GET["action"] === "store" && $_GET["menu"] === "kriteria"){
    $kriteria->saveKriteria($_POST);
}
else if($_GET["action"] === "delete" && $_GET["menu"] === "kriteria"){
    $kriteria->deleteKriteria($_GET["id"]);
}
else if($_GET["action"] === "store" && $_GET["menu"] === "alternatif"){
    $alternatif->saveAlternatif($_POST);
}
else if($_GET["action"] === "update" && $_GET["menu"] === "alternatif"){
    $alternatif->updateAlternatif($_POST);
}
else if($_GET["action"] === "delete" && $_GET["menu"] === "alternatif"){
    $alternatif->deleteAlternatif($_GET["id"]);
}