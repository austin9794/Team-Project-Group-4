<?php
require_once __DIR__ . '/../Database.php';

class Review {
    public static function getByProduct($productId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT r.*, u.name, u.email 
                              FROM reviews r 
                              JOIN users u ON r.user_id = u.user_id 
                              WHERE r.product_id = ? 
                              ORDER BY r.created_at DESC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($userId, $productId, $orderItemId, $rating, $comment, $title) {
    $db = Database::getInstance()->getConnection();

       $stmt = $db->prepare(" INSERT INTO reviews
           (user_id, product_id, order_item_id, rating, title, comment, created_at)
           VALUES (?, ?, ?, ?, ?, ?, NOW())
       ");

        return $stmt->execute([
            $userId,
            $productId,
            $orderItemId,
            $rating,
            $title,
            $comment
        ]);
    }

    public static function averageRating($productId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT AVG(rating) as avg_rating, COUNT(*) as count 
                              FROM reviews WHERE product_id = ?");
        $stmt->execute([$productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
      
        if (!$result['avg_rating']) {
            return ['avg_rating' => 0, 'count' => 0];
        }
        return $result;
    }

    public static function getDeliverableOrderItem($userId, $productId) {
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare(" SELECT oi.order_item_id
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.order_id
        WHERE o.user_id = ?
          AND oi.product_id = ?
          AND o.status = 'delivered'
          AND oi.order_item_id NOT IN (
              SELECT order_item_id FROM reviews
          )
        LIMIT 1
    ");

    $stmt->execute([$userId, $productId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public static function userHasReviewed($userId, $productId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as count 
                              FROM reviews 
                              WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public static function getUserReview($userId, $productId) {
      $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM reviews WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>