<?php

// Fungsi untuk membuat folder
function createFolder($folderName) {
    if (!is_dir($folderName)) {
        mkdir($folderName);
    }
}

// Fungsi untuk membuat file
function createFile($fileName) {
    if (!file_exists($fileName)) {
        fopen($fileName, "w");
    }
}

// Fungsi untuk upload file
function uploadFile($file, $currentDir) {
    $target_dir = $currentDir . "/";
    $target_file = $target_dir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $target_file);
}

// Fungsi untuk rename file atau folder
function renameItem($oldName, $newName) {
    if (file_exists($oldName)) {
        rename($oldName, $newName);
    }
}

// Fungsi untuk delete file atau folder
function deleteItem($itemName) {
    if (is_dir($itemName)) {
        rmdir($itemName);
    } else {
        unlink($itemName);
    }
}

// Fungsi untuk edit file
function editFile($fileName, $content) {
    file_put_contents($fileName, $content);
}

// Handle permintaan POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentDir = isset($_GET['dir']) ? $_GET['dir'] : '.';
    if (isset($_POST['create_folder'])) {
        createFolder($currentDir . DIRECTORY_SEPARATOR . $_POST['folder_name']);
    } elseif (isset($_POST['create_file'])) {
        createFile($currentDir . DIRECTORY_SEPARATOR . $_POST['file_name']);
    } elseif (isset($_POST['upload_file'])) {
        uploadFile($_FILES['file_to_upload'], $currentDir);
    } elseif (isset($_POST['rename_item'])) {
        renameItem($currentDir . DIRECTORY_SEPARATOR . $_POST['old_name'], $currentDir . DIRECTORY_SEPARATOR . $_POST['new_name']);
    } elseif (isset($_POST['delete_item'])) {
        deleteItem($currentDir . DIRECTORY_SEPARATOR . $_POST['item_name']);
    } elseif (isset($_POST['edit_file'])) {
        editFile($_POST['file_name'], $_POST['file_content']);
    }
}

// Tentukan direktori saat ini
$currentDir = isset($_GET['dir']) ? $_GET['dir'] : '.';
$items = scandir($currentDir);

// Fungsi untuk membuat breadcrumb
function createBreadcrumb($currentDir) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $currentDir = realpath($currentDir);
    $path_parts = explode(DIRECTORY_SEPARATOR, $currentDir);
    $path_display = "";
    $breadcrumb = '<a href="?dir=">Home</a> / Directory > ';

    foreach ($path_parts as $index => $path_part) {
        if ($index > 0) {
            $path_display .= DIRECTORY_SEPARATOR;
        }
        $path_display .= $path_part;
        $breadcrumb .= '<a href="?dir=' . urlencode(str_replace($root, '', $path_display)) . '">' . htmlspecialchars($path_part) . '</a> / ';
    }

    return rtrim($breadcrumb, ' / ');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">File Manager</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <form class="d-flex" method="POST">
                        <input class="form-control me-2" type="text" name="folder_name" placeholder="New Folder Name">
                        <button class="btn btn-outline-success" type="submit" name="create_folder">Create Folder</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form class="d-flex" method="POST">
                        <input class="form-control me-2" type="text" name="file_name" placeholder="New File Name">
                        <button class="btn btn-outline-primary" type="submit" name="create_file">Create File</button>
                    </form>
                </li>
                <li class="nav-item">
                    <form class="d-flex" method="POST" enctype="multipart/form-data">
                        <input class="form-control me-2" type="file" name="file_to_upload">
                        <button class="btn btn-outline-warning" type="submit" name="upload_file">Upload File</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><?php echo createBreadcrumb($currentDir); ?></li>
        </ol>
    </nav>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <?php if ($item != '.' && $item != '..'): ?>
                    <tr>
                        <td>
                            <?php if (is_dir($currentDir . DIRECTORY_SEPARATOR . $item)): ?>
                                <a href="?dir=<?php echo urlencode($currentDir . DIRECTORY_SEPARATOR . $item); ?>"><?php echo htmlspecialchars($item); ?></a>
                            <?php else: ?>
                                <?php echo htmlspecialchars($item); ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" class="d-inline-block">
                                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item); ?>">
                                <button class="btn btn-outline-danger" type="submit" name="delete_item">Delete</button>
                            </form>
                            <form method="POST" class="d-inline-block">
                                <input type="hidden" name="old_name" value="<?php echo htmlspecialchars($item); ?>">
                                <input type="text" name="new_name" placeholder="New Name" class="form-control d-inline-block" style="width: auto;">
                                <button class="btn btn-outline-secondary" type="submit" name="rename_item">Rename</button>
                            </form>
                            <?php if (!is_dir($currentDir . DIRECTORY_SEPARATOR . $item)): ?>
                                <a href="?edit=<?php echo urlencode($currentDir . DIRECTORY_SEPARATOR . $item); ?>&dir=<?php echo urlencode($currentDir); ?>" class="btn btn-outline-info">Edit</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php if (isset($_GET['edit'])): ?>
    <div class="modal show" id="editFileModal" tabindex="-1" aria-labelledby="editFileLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFileLabel">Edit File: <?php echo basename($_GET['edit']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <textarea name="file_content" class="form-control" rows="10"><?php echo htmlspecialchars(file_get_contents($_GET['edit'])); ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="file_name" value="<?php echo $_GET['edit']; ?>">
                        <button type="submit" name="edit_file" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var modal = new bootstrap.Modal(document.getElementById('editFileModal'), {});
        modal.show();
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>