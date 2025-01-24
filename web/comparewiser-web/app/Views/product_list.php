<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script>
        function compareProducts() {
            let selectedProducts = [];
            document.querySelectorAll('input[type=checkbox]:checked').forEach(checkbox => {
                selectedProducts.push(checkbox.value);
            });
            if (selectedProducts.length < 2) {
                alert("- Please select at least two products to compare.");
                return;
            }
            //let comparisonResult = document.getElementById('comparison-result');
            //comparisonResult.innerHTML = ''; // Clear any previous data
            // selectedProducts.forEach(productId => formData.append('product_ids[]', productId));
            
            // Send the selected products to the comparison API
            const comparisonUrl = "http://localhost:8080/compare_products";
            // const comparisonUrl = "http://192.168.18.54:8080/compare_products";
            // const comparisonUrl = "http://10.2.1.68:8080/compare_products";
            //const comparisonUrl = "http://10.3.6.4:8080/compare_products";
            

            // Create an object with the product IDs
            const productData = {
                product_ids: selectedProducts
            };

            // Show loading while waiting for comparison
            document.getElementById('loading').style.display = 'block';

            // alert("Selected Products: " + selectedProducts.join(", ")); // Check the selected products array

            // console.log("FormData contents:");
            // for (let pair of formData.entries()) {
            //     console.log(pair[0] + ', ' + pair[1]);
            // }

            // console.log("Sending request to:", comparisonUrl);
            // console.log("FormData:", formData);

            // Fetch comparison data
            fetch(comparisonUrl, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',  // Set the content type
                },
                body: JSON.stringify(productData)  // Send JSON instead of FormData
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading
                document.getElementById('loading').style.display = 'none';

                // Display comparison result
                let comparisonResult = document.getElementById('comparison-result');
                comparisonResult.innerHTML = ''; // Clear any previous data
                
                // Set the innerHTML to the raw HTML string received
                comparisonResult.innerHTML = data.comparison_result;
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                console.error("Error comparing products:", error);
            });
        }
    </script>
</head>
<body>
    <h1>Product List</h1>
    <form id="comparison-form" method="POST" ></form>
        <!-- Product Table -->
        <table border="1">
            <thead>
                <tr>
                    <th>Compare</th>
                    <th>Product Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                        <td><input type="checkbox" name="product_ids[]" value="<?= $product['asin'] ?>"></td>
                        <td><a href="<?= $product['detail_page_url'] ?>" target="_blank"><?= $product['title'] ?></a></td>
                        <td><?= $product['price'] ?> <?= $product['currency'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Button to compare products -->
        <button type="button" onclick="compareProducts()">Compare</button>
    </form>
    <!-- Loading Icon (hidden by default) -->
    <div id="loading" style="display:none;">Comparing products... Please wait.</div>
    
    <!-- Comparison Result -->
    <div id="comparison-result"></div>
</body>
</html>
