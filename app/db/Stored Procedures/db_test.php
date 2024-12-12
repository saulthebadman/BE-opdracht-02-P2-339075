<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=jouw_database_naam", "jouw_gebruikersnaam", "jouw_wachtwoord");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Verbonden met de database!";
} catch (PDOException $e) {
    die("Fout bij verbinden: " . $e->getMessage());
}
