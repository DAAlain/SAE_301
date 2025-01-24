<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Fonction de log personnalisée avec écriture dans un fichier
function logError($message, $context = []) {
    $logMessage = date('Y-m-d H:i:s') . " - " . $message . " - " . json_encode($context) . "\n";
    file_put_contents(__DIR__ . '/debug.log', $logMessage, FILE_APPEND);
}

try {
    logError("Début de la requête", ['method' => $_SERVER['REQUEST_METHOD']]);

    // Vérification de la session
    if (!isset($_SESSION['id'])) {
        logError("Session invalide", ['session' => $_SESSION]);
        throw new Exception("Utilisateur non connecté");
    }

    // Connexion à la base de données
    try {
        $connexion = new PDO(
            "mysql:host=localhost;dbname=ruches;charset=utf8mb4",
            "root",
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        logError("Connexion BD réussie");
    } catch (PDOException $e) {
        logError("Erreur connexion BD", ['error' => $e->getMessage()]);
        throw new Exception("Erreur de connexion à la base de données");
    }

    // Vérifier et créer la table si nécessaire
    $connexion->exec("CREATE TABLE IF NOT EXISTS `notes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `ruche_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `content` TEXT,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_ruche` (`ruche_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // Liste des notes
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
        $ruche_id = isset($_GET['ruche_id']) ? intval($_GET['ruche_id']) : 0;
        
        if ($ruche_id <= 0) {
            throw new Exception("ID de ruche invalide");
        }

        $stmt = $connexion->prepare("
            SELECT id, created_at,
            CONCAT('Note du ', DATE_FORMAT(created_at, '%d/%m/%Y')) as title
            FROM notes 
            WHERE ruche_id = ?
            ORDER BY created_at DESC
        ");
        
        $stmt->execute([$ruche_id]);
        $notes = $stmt->fetchAll();

        echo json_encode([
            'success' => true,
            'notes' => $notes ?: []
        ]);
        exit;
    }

    // Récupérer une note
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get') {
        if (!isset($_GET['note_id'])) {
            throw new Exception("ID de note manquant");
        }

        $stmt = $connexion->prepare("SELECT content FROM notes WHERE id = ?");
        $stmt->execute([intval($_GET['note_id'])]);
        $note = $stmt->fetch();

        echo json_encode([
            'success' => true,
            'content' => $note ? $note['content'] : ''
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $raw_input = file_get_contents('php://input');
        logError("Données brutes reçues", ['raw_input' => $raw_input]);

        $postData = json_decode($raw_input, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            logError("Erreur décodage JSON", ['error' => json_last_error_msg()]);
            throw new Exception("Erreur dans le format des données");
        }

        logError("Données décodées", ['postData' => $postData]);

        // Validation des données selon l'action
        $action = $postData['action'] ?? '';
        $user_id = intval($_SESSION['id']);

        if ($action === 'add' || $action === 'update') {
            // Validation pour ajout et modification
            if (!isset($postData['content'])) {
                throw new Exception("Contenu de la note manquant");
            }
            if (!isset($postData['ruche_id'])) {
                throw new Exception("ID de la ruche manquant");
            }
            $content = trim($postData['content']);
            $ruche_id = intval($postData['ruche_id']);
        }
        elseif ($action === 'delete') {
            // Validation pour suppression
            if (!isset($postData['note_id'])) {
                throw new Exception("ID de la note manquant pour la suppression");
            }
        }
        else {
            throw new Exception("Action non spécifiée ou invalide");
        }

        // Traitement selon l'action
        if ($action === 'add') {
            try {
                $stmt = $connexion->prepare("
                    INSERT INTO notes (ruche_id, user_id, content, created_at, updated_at) 
                    VALUES (?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
                ");
                $success = $stmt->execute([$ruche_id, $user_id, $content]);
                $note_id = $connexion->lastInsertId();
                
                logError("Note ajoutée avec succès", ['note_id' => $note_id]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Note ajoutée avec succès',
                    'note_id' => $note_id
                ]);
            } catch (PDOException $e) {
                logError("Erreur SQL lors de l'ajout", ['error' => $e->getMessage()]);
                throw new Exception("Erreur lors de l'ajout de la note");
            }
        } 
        elseif ($action === 'update') {
            if (!isset($postData['note_id'])) {
                throw new Exception("ID de note manquant pour la modification");
            }
            
            try {
                $note_id = intval($postData['note_id']);
                $stmt = $connexion->prepare("
                    UPDATE notes 
                    SET content = ?, 
                        updated_at = CURRENT_TIMESTAMP 
                    WHERE id = ? AND ruche_id = ? AND user_id = ?
                ");
                $success = $stmt->execute([$content, $note_id, $ruche_id, $user_id]);
                
                logError("Note mise à jour avec succès", ['note_id' => $note_id]);

                echo json_encode([
                    'success' => true,
                    'message' => 'Note modifiée avec succès',
                    'note_id' => $note_id
                ]);
            } catch (PDOException $e) {
                logError("Erreur SQL lors de la mise à jour", ['error' => $e->getMessage()]);
                throw new Exception("Erreur lors de la modification de la note");
            }
        }
        elseif ($action === 'delete') {
            try {
                $note_id = intval($postData['note_id']);
                
                // Vérifier si la note existe et appartient à l'utilisateur
                $checkStmt = $connexion->prepare("
                    SELECT id FROM notes 
                    WHERE id = ? AND user_id = ?
                ");
                $checkStmt->execute([$note_id, $user_id]);
                $noteExists = $checkStmt->fetch();
                
                if (!$noteExists) {
                    throw new Exception("Note introuvable ou vous n'avez pas les droits pour la supprimer");
                }
                
                // Supprimer la note
                $deleteStmt = $connexion->prepare("
                    DELETE FROM notes 
                    WHERE id = ? AND user_id = ?
                ");
                $success = $deleteStmt->execute([$note_id, $user_id]);
                
                if ($success) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Note supprimée avec succès'
                    ]);
                } else {
                    throw new Exception("Échec de la suppression de la note");
                }
            } catch (PDOException $e) {
                logError("Erreur SQL lors de la suppression", ['error' => $e->getMessage()]);
                throw new Exception("Erreur lors de la suppression de la note");
            }
        }
        exit;
    }

    throw new Exception("Méthode non supportée");

} catch (Exception $e) {
    logError("Erreur finale", [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'details' => 'Voir les logs pour plus de détails'
    ]);
    exit;
} 