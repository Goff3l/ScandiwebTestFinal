<?php
require_once 'product_classes.php';

$sku = $_POST['sku'];
$name = $_POST['name'];
$price = $_POST['price'];
$type = $_POST['productType'];

$product = null;

switch ($type) {
    case 'DVD':
        $size = $_POST['size'];
        $product = new DVD($sku, $name, $price, $size);
        break;
    case 'Book':
        $weight = $_POST['weight'];
        $product = new Book($sku, $name, $price, $weight);
        break;
    case 'Furniture':
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $product = new Furniture($sku, $name, $price, $height, $width, $length);
        break;
}

$response = ['success' => false, 'message' => 'Unknown error'];

if ($product) {
    try {
        $product->save();
        $response = ['success' => true];
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
