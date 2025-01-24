<?php

namespace App\Controllers;

use CodeIgniter\Controller;

error_reporting(E_ALL);
ini_set('display_errors', 1);

function fetchProducts($category) {
    // Base API URL
    $apiUrl = "http://comparewise-api:8080/list_products";

    // Build the full URL with the category parameter
    $url = $apiUrl . "?category=" . urlencode($category);

    // Initialize a cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,               // API URL
        CURLOPT_RETURNTRANSFER => true,   // Return the response as a string
        CURLOPT_FOLLOWLOCATION => true,   // Follow redirects
        CURLOPT_TIMEOUT => 10,            // Timeout in seconds
        CURLOPT_HTTPHEADER => [           // Optional headers
            'Accept: application/json',
        ],
    ]);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL Error: $error");
    }

    // Get the HTTP status code
    $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check if the response status code is not successful
    if ($httpStatusCode !== 200) {
        throw new Exception("HTTP Error: Received status code $httpStatusCode");
    }

    // Decode the JSON response
    $data = json_decode($response, true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("JSON Decoding Error: " . json_last_error_msg());
    }

    return $data;
}


class ProductController extends Controller
{
    #private $api_base_url = 'http://comparewise-api:8080'; // Replace with the correct API URL

    // List products of a specific category
    public function list($category)
    {
        try {
            #$category = "electronics";
            $products = fetchProducts($category);
            #print_r($products['items']);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        $items = $products['items'];

        if ($items) {
            // = $decodedData['items'];
            // Prepare data for the view
            $products = [];
            foreach ($items as $item) {
                // Extract necessary information
                
                $products[] = [
                    'asin' => $item['asin'],
                    'title' => $item['item_info']['title']['display_value'],
                    'price' => isset($item['offers']['listings'][0]['price']['amount']) ? $item['offers']['listings'][0]['price']['amount'] : null,
                    'currency' => isset($item['offers']['listings'][0]['price']['currency']) ? $item['offers']['listings'][0]['price']['currency'] : null,
                    'detail_page_url' => $item['detail_page_url'],
                    // Add any other fields you need here
                ];
            }
        } else {
            // Handle the case when 'items' is not present
            $products = [];
        }

        // Load the view and pass the product data
        return view('product_list', ['products' => $products]);
    }

    // Compare selected products
    public function compare()
    {
        $client = \Config\Services::curlrequest();
        $product_ids = $this->request->getPost('product_ids');
        dd($product_ids);
        if (count($product_ids) < 2) {
            return view('error_page', ['message' => 'Please select at least two products.']);
        }

        // Prepare the data for the API call
        $data = ['product_ids' => $product_ids];

        // Call the CompareWise API to compare products
        #$response = $client->post($this->api_base_url . '/compare_products', [
        $response = $client->post('http://comparewise-api:8080/compare_products', [
            'json' => $data,
            'timeout' => 60
        ]);

        if ($response->getStatusCode() !== 200) {
            return view('error_page', ['message' => 'Unable to compare products.']);
        }

        $comparison_result = json_decode($response->getBody(), true);

        // Pass the comparison data to the view
        return view('comparison_result', ['comparison' => $comparison_result]);
    }

    public function categories()
    {
        return view('category_list');
    }

}

