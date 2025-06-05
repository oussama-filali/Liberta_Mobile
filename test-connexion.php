<?php

include_once 'backend/config/database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "✅ Connexion réussie à Supabase PostgreSQL !";
} else {
    echo "❌ La connexion a échoué.";
}
