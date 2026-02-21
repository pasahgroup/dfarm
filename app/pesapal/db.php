<?php
class DB {
    private $pdo;

    public function __construct($config) {
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/db.log', "DB connection error: " . $e->getMessage() . "\n", FILE_APPEND);
            throw $e;
        }
    }

    /**
     * Insert or update payment status
     */
    public function upsertPaymentStatus($reference, $trackingId, $status, $rawResponse = []) {
        try {
            // Check if record exists
            $stmt = $this->pdo->prepare("SELECT id FROM payments WHERE reference = :reference LIMIT 1");
            $stmt->execute(['reference' => $reference]);
            $existing = $stmt->fetch();

            if ($existing) {
                // Update existing record
                $update = $this->pdo->prepare("
                    UPDATE payments 
                    SET tracking_id = :tracking_id, status = :status, raw_response = :raw_response, updated_at = NOW()
                    WHERE reference = :reference
                ");
                $update->execute([
                    'tracking_id' => $trackingId,
                    'status'      => $status,
                    'raw_response'=> json_encode($rawResponse),
                    'reference'   => $reference
                ]);
            } else {
                // Insert new record
                $insert = $this->pdo->prepare("
                    INSERT INTO payments (reference, tracking_id, status, raw_response, created_at, updated_at)
                    VALUES (:reference, :tracking_id, :status, :raw_response, NOW(), NOW())
                ");
                $insert->execute([
                    'reference'   => $reference,
                    'tracking_id' => $trackingId,
                    'status'      => $status,
                    'raw_response'=> json_encode($rawResponse)
                ]);
            }

            file_put_contents(__DIR__ . '/db.log', date('c') . " Upserted payment: Ref=$reference, Track=$trackingId, Status=$status\n", FILE_APPEND);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/db.log', "DB error: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }
}