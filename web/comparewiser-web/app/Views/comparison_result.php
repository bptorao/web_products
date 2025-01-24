<!DOCTYPE html>
<html>
<head>
    <title>Product Comparison</title>
    <style>
        .comparison-table {
            width: 100%;
            border-collapse: collapse;
        }
        .comparison-table, .comparison-table th, .comparison-table td {
            border: 1px solid black;
        }
        .comparison-table th, .comparison-table td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Product Comparison</h1>
    <script>
    document.getElementById('comparison-form').addEventListener('submit', function () {
        document.getElementById('loading').style.display = 'block';
    });
    </script>

    <div id="loading" style="display:none;">
        <img src="/path/to/loading-spinner.gif" alt="Loading...">
    </div>

    <table class="comparison-table">
        <thead>
            <tr>
                <?php foreach ($comparison as $product): ?>
                    <th><?= $product['name'] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($comparison as $product): ?>
                    <td><?= $product['description'] ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($comparison as $product): ?>
                    <td><?= $product['reviews'] ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>
</body>
</html>
