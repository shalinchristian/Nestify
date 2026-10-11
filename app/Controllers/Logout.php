<?php
// Shared logout for both roles (was Agent/Logout.php and User/Logout.php).
if (session_status() === PHP_SESSION_NONE) session_start();
session_unset();
session_destroy();
header('Location: ' . (NESTIFY_ROLE === 'agent' ? 'AgentDashboard.php' : 'Home.php'));
exit();
