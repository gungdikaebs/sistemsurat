<?php
session_start();
// system file
require_once 'app/core/config.php';
require_once 'app/core/controller.php';
require_once 'app/core/database.php';
require_once 'app/core/functions.php';

// konek ke database
connectDB();

// app file
require_once 'app/request.php';
require_once 'app/routes.php';
handleRoute();
