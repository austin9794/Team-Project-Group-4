<?php
require_once __DIR__ . '/../Models/Review.php';

class ReviewController {
    public function showReviews($productId) {
        return Review::getByProduct($productId);
    }

    public function addReview($userId, $productId, $rating, $comment) {
        if (!Review::userHasPurchased($userId, $productId)) {
            throw new Exception("You can only review products you've purchased.");
        }

        if ($rating < 1 || $rating > 5) {
            throw new Exception("Rating must be in the range of 1 and 5.");
        }

        return Review::add($userId, $productId, $rating, $comment);
    }

    public function getAverage($productId) {
        return Review::averageRating($productId);
    }

    public function canUserReview($userId, $productId) {
        return Review::userHasPurchased($userId, $productId) && 
               !Review::userHasReviewed($userId, $productId);
    }

    public function getUserReview($userId, $productId) {
        return Review::getUserReview($userId, $productId);
    }
}
?>