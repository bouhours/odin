<?php
header('Content-type: text/html; charset=UTF-8');
header("Content-Security-Policy: default-src 'self';");
header("X-Frame-Options: deny");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=259200; includeSubDomains; preload;");
