<?php
function pageName(){ return basename($_SERVER['PHP_SELF']); }
function sanitizeMail($email){ return filter_var(trim($email), FILTER_SANITIZE_EMAIL); }
?>
