<?php
require 'autoload.php';

use App\Controllers\DatabaseController;

$db = new DatabaseController();
$db->con();
$db->fetch();