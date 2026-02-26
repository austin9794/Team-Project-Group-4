<?php
require_once __DIR__ . '/../Models/Review.php';

class ReviewController {
    public function showReviews($productId) {
        return Review::getByProduct($productId);
    }

   public function addReview($userId, $productId, $rating, $comment, $title) {

    if ($rating < 1 || $rating > 5) {
        throw new Exception("Rating must be between 1 and 5.");
    }

    if (empty($title)) {
        throw new Exception("Review title is required.");
    }

    if (empty($comment)) {
        throw new Exception("Review comment cannot be empty.");
    }

    $orderItem = Review::getDeliverableOrderItem($userId, $productId);

    if (!$orderItem) {
        throw new Exception("You can only review delivered items once per order.");
    }

    return Review::add(
        $userId,
        $productId,
        $orderItem['order_item_id'],
        $rating,
        $comment,
        $title
    );
}

    public function getAverage($productId) {
        return Review::averageRating($productId);
    }

    public function canUserReview($userId, $productId) {
    return Review::getDeliverableOrderItem($userId, $productId) !== false;
}

    public function getUserReview($userId, $productId) {
        return Review::getUserReview($userId, $productId);
    }
}
?>