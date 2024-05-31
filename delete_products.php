<?php
require_once 'product_classes.php';

if (isset($_POST['skus'])) {
    $skus = $_POST['skus'];
    deleteProducts($skus);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No products selected']);
}
?>