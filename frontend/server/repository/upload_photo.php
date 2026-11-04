<?php

    function upload_photo($file, int $userId) {

        if ($file["error"] !== UPLOAD_ERR_OK) {
            throw new Exception("Server could not load File");
        }

        $allowedTypes = ["image/png" => "png", "image/jpeg" => "jpg"];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file["tmp_name"]);

        if (!isset($allowedTypes[$mimeType])) {
            throw new Exception("Server could not load File");
        }

        $uploadDirectory = __DIR__ . "/../../assets/uploads/users/" . $userId . "/";

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        $extension = $allowedTypes[$mimeType];
        $filename = bin2hex(random_bytes(16)) . "." . $extension;
        $destination = $uploadDirectory . $filename;

        if (!move_uploaded_file($file["tmp_name"], $destination)) {
            throw new Exception("Server could not load File");
        }

        return "assets/uploads/users/" . $userId . "/" . $filename;
    }
?>