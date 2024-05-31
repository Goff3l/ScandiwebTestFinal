<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1>Product List</h1>
        <a href="add-product.php" class="btn btn-primary mb-3">ADD</a>
        <button id="mass-delete-button" class="btn btn-danger mb-3">MASS DELETE</button>
        <div class="row">
            <?php
            require_once 'product_classes.php';
            $products = getAllProducts();
            foreach ($products as $product) {
                echo "<div class='col-md-4'>";
                echo "<div class='card mb-4'>";
                echo "<div class='card-body'>";
                echo "<input type='checkbox' class='delete-checkbox' name='skus[]' value='{$product['sku']}'>";
                echo "<h5 class='card-title'>{$product['sku']}</h5>";
                echo "<p class='card-text'>{$product['name']}</p>";
                echo "<p class='card-text'>\${$product['price']}</p>";
                switch ($product['type']) {
                    case 'DVD':
                        echo "<p class='card-text'>Size: {$product['size']} MB</p>";
                        break;
                    case 'Book':
                        echo "<p class='card-text'>Weight: {$product['weight']} Kg</p>";
                        break;
                    case 'Furniture':
                        echo "<p class='card-text'>Dimensions: {$product['height']}x{$product['width']}x{$product['length']} cm</p>";
                        break;
                }
                echo "</div></div></div>";
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#mass-delete-button').click(function() {
                var skus = [];
                $('.delete-checkbox:checked').each(function() {
                    skus.push($(this).val());
                });

                if (skus.length > 0) {
                    $.ajax({
                        url: 'delete_products.php',
                        type: 'POST',
                        data: { skus: skus },
                        success: function(response) {
                            location.reload();
                        }
                    });
                } else {
                    alert('Please select at least one product to delete.');
                }
            });
        });
    </script>
</body>
</html>
