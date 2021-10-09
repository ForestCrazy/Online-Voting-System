<?php
if (!isset($_SESSION['username'])) {
    gotoPage('home');
} else {
    if (isAdmin($_SESSION['u_id'])) {
        if (!isset($_GET['admin'])) {
            $_GET['admin'] = 'account';
        }
        if ($_GET['admin'] == 'account') {
            include_once __DIR__ . '/admin/account.php';
        } elseif ($_GET['admin'] == 'election') {
            include_once __DIR__ . '/admin/election.php';
        } else {
            gotoPage('admin');
        }
    } else {
        gotoPage('home');
    }
}
