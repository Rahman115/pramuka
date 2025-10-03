<?php
session_start();
require_once "config/database.php";
require_once "models/AnggotaModel.php";
require_once "models/GudepModel.php";
require_once "models/KwarcabModel.php";
require_once "models/DkcModel.php";
require_once "models/PendampingModel.php";
require_once "models/PesertaDidikModel.php";

$database = new Database();
$db = $database->getConnection();

// Inisialisasi semua model
$anggotaModel = new AnggotaModel($db);
$gudepModel = new GudepModel($db);
$kwarcabModel = new KwarcabModel($db);
$dkcModel = new DkcModel($db);
$pendampingModel = new PendampingModel($db);
$pesertaDidikModel = new PesertaDidikModel($db);

$action = isset($_GET["action"]) ? $_GET["action"] : "dashboard";
$page = isset($_GET["page"]) ? $_GET["page"] : "anggota";

// Include header
include "views/header.php";

// Routing
switch ($action) {
  case "dashboard":
    include "views/dashboard.php";
    break;
  case "list":
    if ($page == "anggota") {
      include "views/anggota/list.php";
    } elseif ($page == "gudep") {
      include "views/gudep/list.php";
    } elseif ($page == "kwarcab") {
      include "views/kwarcab/list.php";
    } elseif ($page == "dkc") {
      include "views/dkc/list.php";
    } elseif ($page == "pendamping") {
      include "views/pendamping/list.php";
    } elseif ($page == "peserta") {
      include "views/peserta/list.php";
    }
    break;
  case "create":
    if ($page == "anggota") {
      include "views/anggota/form.php";
    } elseif ($page == "gudep") {
      include "views/gudep/form.php";
    } elseif ($page == "kwarcab") {
      include "views/kwarcab/form.php";
    } elseif ($page == "dkc") {
      include "views/dkc/form.php";
    } elseif ($page == "pendamping") {
      include "views/pendamping/form.php";
    } elseif ($page == "peserta") {
      include "views/peserta/form.php";
    }
    break;
  case "edit":
    if ($page == "anggota") {
      include "views/anggota/form.php";
    } elseif ($page == "gudep") {
      include "views/gudep/form.php";
    } elseif ($page == "kwarcab") {
      include "views/kwarcab/form.php";
    } elseif ($page == "dkc") {
      include "views/dkc/form.php";
    } elseif ($page == "pendamping") {
      include "views/pendamping/form.php";
    } elseif ($page == "peserta") {
      include "views/peserta/form.php";
    }
    break;
  // Dalam switch statement, tambahkan:
case 'view':
    if($page == 'anggota') {
        include "views/anggota/detail.php";
    } elseif($page == 'gudep') {
        include "views/gudep/detail.php";
    } elseif($page == 'kwarcab') {
        include "views/kwarcab/detail.php";
    } elseif($page == 'dkc') {
        include "views/dkc/detail.php";
    } elseif($page == 'pendamping') {
        include "views/pendamping/detail.php";
    } elseif($page == 'peserta') {
        include "views/peserta/detail.php";
    }
    break;
  default:
    include "views/dashboard.php";
    break;
}

// Include footer
include "views/footer.php";
?>
