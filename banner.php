<?php

class VisitorTracker {
    private $pdo;
    
    public function __construct($host, $port, $dbName, $dbUsername, $dbPassword) {
        $this->connectDatabase($host, $port, $dbName, $dbUsername, $dbPassword);
    }
    
    private function connectDatabase($host, $port, $dbName, $dbUsername, $dbPassword) {
        try {
            $dsn = "mysql:host=$host;port=$port;dbname=$dbName";
            $this->pdo = new PDO($dsn, $dbUsername, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public function trackVisitor($ipAddress, $userAgent, $pageUrl) {
        $ipAddress = $this->sanitizeInput($ipAddress);
        $userAgent = $this->sanitizeInput($userAgent);
        
        $referer = $_SERVER['HTTP_REFERER'];
        $pageUrl = $_SERVER['HTTP_HOST'].'/'.basename(parse_url($referer, PHP_URL_PATH));
        
        $viewDate = date('Y-m-d H:i:s');
        
        $query = "SELECT * FROM visitor_data WHERE ip_address = ? AND user_agent = ? AND page_url = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$ipAddress, $userAgent, $pageUrl]);
        $visitor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($visitor) {
            $query = "UPDATE visitor_data SET view_date = ?, views_count = views_count + 1 WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$viewDate, $visitor['id']]);
        } else {
            $query = "INSERT INTO visitor_data (ip_address, user_agent, view_date, page_url, views_count) VALUES (?, ?, ?, ?, 1)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$ipAddress, $userAgent, $viewDate, $pageUrl]);
        }
    }

    private function sanitizeInput($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}

$host = '127.0.0.1';
$port = 3309;
$dbName = 'infuse_test';
$dbUsername = 'root';
$dbPassword = '';

$tracker = new VisitorTracker($host, $port, $dbName, $dbUsername, $dbPassword);
$tracker->trackVisitor($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI']);

$imagePath = "image.jpg";
header("Content-Type: image/jpeg");
readfile($imagePath);
exit;
?>
