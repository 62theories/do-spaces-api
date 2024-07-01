<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// DigitalOcean Spaces configuration
$space_name = '';
$space_region = ''; // e.g., 'nyc3'
$access_key = '';
$secret_key = '';

// Create S3 client
$client = new S3Client([
    'version' => 'latest',
    'region'  => $space_region,
    'endpoint' => "https://{$space_region}.digitaloceanspaces.com",
    'credentials' => [
        'key'    => $access_key,
        'secret' => $secret_key,
    ],
]);

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_type = $_FILES['image']['type'];

        // Generate a unique file name
        $new_file_name = uniqid() . '-' . $file_name;

        // Try to upload the file
        try {
            $result = $client->putObject([
                'Bucket' => $space_name,
                'Key'    => $new_file_name,
                'Body'   => fopen($file_tmp_path, 'r'),
                'ACL'    => 'public-read',
                'ContentType' => $file_type
            ]);

            // Return success response
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'url' => $result['ObjectURL']
            ], JSON_UNESCAPED_SLASHES);
        } catch (AwsException $e) {
            // Return error response
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to upload file: ' . $e->getMessage()
            ]);
        }
    } else {
        // Return error response
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'No file uploaded or upload error occurred'
        ]);
    }
} else {
    // Return error for non-POST requests
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Method not allowed'
    ]);
}