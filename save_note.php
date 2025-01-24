<?php
session_start();
error_reporting(0); // Désactiver l'affichage des erreurs PHP
header('Content-Type: application/json'); // Forcer le type de contenu en JSON

try {
    // Connexion directe à la base de données
    $connexion = new PDO(
        "mysql:host=localhost;dbname=ruches;charset=utf8",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Créer la table si elle n'existe pas
    $connexion->exec("CREATE TABLE IF NOT EXISTS notes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        ruche_id INT NOT NULL,
        user_id INT NOT NULL,
        content TEXT,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL
    )");

    // Traitement GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['ruche_id'])) {
            throw new Exception("ID de ruche manquant");
        }

        $ruche_id = intval($_GET['ruche_id']);
        
        $stmt = $connexion->prepare("SELECT content FROM notes WHERE ruche_id = ? LIMIT 1");
        $stmt->execute([$ruche_id]);
        $note = $stmt->fetch();
        
        echo json_encode([
            'success' => true,
            'content' => $note ? $note['content'] : ''
        ]);
        exit;
    }

    // Traitement POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['content'], $_POST['ruche_id'])) {
            throw new Exception("Données manquantes");
        }

        // Pour le test, on utilise un user_id fixe si la session n'existe pas
        $user_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 1;
        $content = $_POST['content'];
        $ruche_id = intval($_POST['ruche_id']);

        // Vérifier si une note existe déjà
        $stmt = $connexion->prepare("SELECT id FROM notes WHERE ruche_id = ?");
        $stmt->execute([$ruche_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            $stmt = $connexion->prepare("UPDATE notes SET content = ?, updated_at = NOW() WHERE ruche_id = ?");
            $success = $stmt->execute([$content, $ruche_id]);
        } else {
            $stmt = $connexion->prepare("INSERT INTO notes (ruche_id, user_id, content, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
            $success = $stmt->execute([$ruche_id, $user_id, $content]);
        }

        if (!$success) {
            throw new Exception("Erreur lors de l'enregistrement de la note");
        }

        echo json_encode(['success' => true]);
        exit;
    }

    throw new Exception("Méthode non autorisée");

} catch (PDOException $e) {
    error_log("Erreur PDO : " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erreur de base de données',
        'debug' => $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    error_log("Erreur générale : " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
    exit;
} 