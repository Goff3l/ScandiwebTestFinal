<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1>Add Product</h1>
        <form id="product_form">
            <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" class="form-control" id="sku" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" required>
            </div>
            <div class="form-group">
                <label for="productType">Product Type</label>
                <select class="form-control" id="productType" required>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>
            </div>
            <div id="type-specific-fields"></div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
        </form>
    </div>

    <script>
        function updateTypeSpecificFields() {
            const type = $('#productType').val();
            let fields = '';
            if (type === 'DVD') {
                fields = `
                    <div class="form-group">
                        <label for="size">Size (MB)</label>
                        <input type="number" step="0.01" class="form-control" id="size" required>
                    </div>
                `;
            } else if (type === 'Book') {
                fields = `
                    <div class="form-group">
                        <label for="weight">Weight (Kg)</label>
                        <input type="number" step="0.01" class="form-control" id="weight" required>
                    </div>
                `;
            } else if (type === 'Furniture') {
                fields = `
                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="height" required>
                    </div>
                    <div class="form-group">
                        <label for="width">Width (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="width" required>
                    </div>
                    <div class="form-group">
                        <label for="length">Length (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="length" required>
                    </div>
                `;
            }
            $('#type-specific-fields').html(fields);
        }

        $(document).ready(function() {
            $('#productType').change(updateTypeSpecificFields);
            updateTypeSpecificFields();

            $('#cancel-button').click(function() {
                window.location.href = '/';
            });

            $('#product_form').submit(function(e) {
                e.preventDefault();
                const type = $('#productType').val();
                const data = {
                    sku: $('#sku').val(),
                    name: $('#name').val(),
                    price: $('#price').val(),
                    productType:  $('#productType').val()
                };

                if (type === 'DVD') {
                    data.size = $('#size').val();
                } else if (type === 'Book') {
                    data.weight = $('#weight').val();
                } else if (type === 'Furniture') {
                    data.height = $('#height').val();
                    data.width = $('#width').val();
                    data.length = $('#length').val();
                }

                $.post('save_product.php', data, function(response) {
                    if (response.success) {
                        window.location.href = '/';
                    } else {
                        alert(response.message);
                    }
                }, 'json');
            });
        });
    </script>
</body>
</html>
