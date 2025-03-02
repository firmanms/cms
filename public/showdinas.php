

<?php      
require '../vendor/autoload.php'; // Pastikan ini mengarah ke file autoload.php yang dihasilkan oleh Composer      
      
use GuzzleHttp\Client;      
      
// URL API      
$url = "https://skm.bandungkab.go.id/api/showDinas";      
      
// Data yang akan dikirim dalam body request      
$data = array(      
    'dinas_id' => null, // Pastikan input ini aman dan valid      
    'id_kategori' => 20 // Ganti dengan ID kategori yang sesuai      
);      
      
// Inisialisasi klien Guzzle      
$client = new Client();      
      
try {      
    // Mengirim request POST      
    $response = $client->request('POST', $url, [      
        'form_params' => $data      
    ]);      
      
    // Mendapatkan isi respon      
    $body = $response->getBody();      
    $responseString = $body->getContents();      
      
    // Parsing JSON ke array PHP      
    $responseData = json_decode($responseString, true);      
      
    // Cek apakah decoding JSON berhasil      
    if (json_last_error() !== JSON_ERROR_NONE) {      
        die('Error decoding JSON: ' . json_last_error_msg());      
    }      
      
    // Cek apakah data ada dan tidak kosong      
    if (!isset($responseData) || empty($responseData)) {      
        die('No data available.');      
    }      
    
    // Mengurutkan data berdasarkan nm_dinas secara ascending    
    usort($responseData, function($a, $b) {    
        return strcmp($a['nm_dinas'], $b['nm_dinas']);    
    });    
      
    // Encode the sorted data to JSON  
    $jsonData = json_encode($responseData, JSON_PRETTY_PRINT);  
      
    // Write JSON data to a file  
    file_put_contents('showdinasIKM.json', $jsonData);  
      
} catch (Exception $e) {      
    die('Error occurred while fetching data: ' . $e->getMessage());      
}      
?>      
      
<!DOCTYPE html>      
<html lang="en">      
<head>      
    <meta charset="UTF-8">      
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title>Select Form</title>      
</head>      
<body>      
    <h1>Select School</h1>      
    <form>      
        <label for="dinas">Choose a school:</label>      
        <select id="dinas" name="dinas">      
            <?php foreach ($responseData as $school): ?>      
                <option value="<?php echo htmlspecialchars($school['nm_dinas']); ?>">      
                <?php echo htmlspecialchars($school['nm_dinas']); ?> | ID <?php echo htmlspecialchars($school['id']); ?>      
                </option>      
            <?php endforeach; ?>      
        </select>      
        <input type="submit" value="Submit">      
    </form>      
</body>      
</html>      

