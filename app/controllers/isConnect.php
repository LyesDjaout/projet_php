<?php

if (!isset($_SESSION['LOGGED_USER'])) {
    throw new Exception('Il faut être authentifié pour cette action.');
}
