<?php
session_start();
session_destroy();
header('Location: /clothes/index.php');
