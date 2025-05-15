<?php
session_start();
session_destroy();
echo "<script>alert('Has cerrado sesión correctamente.'); window.location.href = '../../index.php';</script>";
exit();
?>