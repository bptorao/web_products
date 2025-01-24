<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        .search-container {
            margin-bottom: 20px;
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .search-container input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-container button {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        .category-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 columns */
            gap: 20px; /* space between squares */
            max-width: 900px; /* adjust as needed */
            width: 100%;
        }
        
        .category-square {
            border: 2px solid #007bff;
            border-radius: 8px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .category-square:hover {
            background-color: #e9ecef;
        }

        @media (max-width: 768px) {
            .category-container {
                grid-template-columns: repeat(2, 1fr); /* 2 columns for smaller screens */
            }

            .category-square {
                height: 120px;
            }
        }

        @media (max-width: 480px) {
            .category-container {
                grid-template-columns: repeat(1, 1fr); /* 1 column for very small screens */
            }

            .category-square {
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <h1>Comparador de productos</h1>
    <h2>Busca y compara cualquier producto</h2>

    <div class="search-container">
        <input type="text" id="searchBox" placeholder="Escribe para buscar productos...">
        <button onclick="searchProducts()">Buscar</button>
    </div>
    
    <h3>Categorías sugeridas</h3>
    <div class="category-container">
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/airfryers') ?>'">AirFriers</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/hard_disks') ?>'">Hard Disks</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/home_appliances') ?>'">Home Appliances</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/fashion') ?>'">Fashion</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/sports_outdoors') ?>'">Sports & Outdoors</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/books') ?>'">Books</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/beauty_health') ?>'">Beauty & Health</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/toys_games') ?>'">Toys & Games</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/automotive') ?>'">Automotive</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/groceries') ?>'">Groceries</div>
        <div class="category-square" onclick="window.location.href='<?= base_url('products/list/office_supplies') ?>'">Office Supplies</div>
    </div>

    <script>
        function searchProducts() {
            const searchText = document.getElementById('searchBox').value.trim();
            if (searchText) {
                window.location.href = '<?= base_url('products/list/') ?>' + encodeURIComponent(searchText);
            } else {
                alert('Por favor, escribe algo para buscar.');
            }
        }
    </script>
</body>
</html>
