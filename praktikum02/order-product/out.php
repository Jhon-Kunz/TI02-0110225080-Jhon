<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $account_number = isset($_POST['account_number']) ? trim($_POST['account_number']) : '';
    $bank = isset($_POST['bank']) ? trim($_POST['bank']) : '';
    $account_holder = isset($_POST['account_holder']) ? trim($_POST['account_holder']) : '';
    $transaction = isset($_POST['transaction']) ? intval($_POST['transaction']) : 0;  
    $sendToMobilePhone = isset($_POST['sendToMobilePhone']) ? true : false;  
    $mobile_number = isset($_POST['mobile_number']) ? trim($_POST['mobile_number']) : '';
    $sendToEmail = isset($_POST['sendToEmail']) ? true : false;  
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

   
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $fileTmpPath = $_FILES['product_image']['tmp_name'];
        $fileName = basename($_FILES['product_image']['name']);  
        $uploadPath = 'uploads/' . $fileName;  

       
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);  
        }

       
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            echo "Gambar berhasil diunggah: " . $fileName . "<br>";
        } else {
            echo "Error: Gagal mengunggah gambar.<br>";
        }
    } else {
        echo "Tidak ada gambar yang diunggah atau ada error.<br>";
    }

    
    if (empty($name)) {
        echo "Error: Nama harus diisi.<br>";
    } else {
       
        echo "Data yang diterima:<br>";
        echo "Name: " . htmlspecialchars($name) . "<br>";
        echo "Description: " . htmlspecialchars($description) . "<br>";
        echo "Account Number: " . htmlspecialchars($account_number) . "<br>";
        echo "Bank: " . htmlspecialchars($bank) . "<br>";
        echo "Account Holder: " . htmlspecialchars($account_holder) . "<br>";
        echo "Transaction: " . $transaction . "<br>";

        
        if ($sendToMobilePhone && !empty($mobile_number)) {
            echo "Mengirim ke nomor ponsel: " . htmlspecialchars($mobile_number) . "<br>";
           
        } elseif ($sendToMobilePhone && empty($mobile_number)) {
            echo "Error: Nomor ponsel harus diisi jika checkbox dipilih.<br>";
        }

        if ($sendToEmail && !empty($email)) {
            $to = $email;
            $subject = "Konfirmasi Pembayaran dari Logitech Market";
            $message = "Terima kasih, " . $name . ". Transaksi Anda telah diproses.\nDetail: " . $description;
            $headers = "From: no-reply@logitechmarket.com";  

            if (mail($to, $subject, $message, $headers)) {
                echo "Email berhasil dikirim ke: " . htmlspecialchars($email) . "<br>";
            } else {
                echo "Error: Gagal mengirim email.<br>";
            }
        } elseif ($sendToEmail && empty($email)) {
            echo "Error: Email harus diisi jika checkbox dipilih.<br>";
        }

        echo "<br>Proses selesai. <a href='index.html'>Kembali ke form</a>";
    }
} else {
    echo "Tidak ada data yang disubmit. <a href='index.html'>Kembali ke form</a>";
}
?>