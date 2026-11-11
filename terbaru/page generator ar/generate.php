<?php

// ==========================
// LOAD FILES
// ==========================
$pages = file(
    'pages.txt',
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

$brands = file(
    'brand.txt',
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

$template = file_get_contents('template.txt');

// ==========================
// COUNTER
// ==========================
$success = 0;
$failed = 0;
$brandIndex = 0;

echo "<h2>Generator System by VN</h2>";

// ==========================
// LOOP PAGE
// ==========================
foreach ($pages as $page) {

    $page = trim($page);

    if ($page == '') continue;

    // ==========================
    // BRAND ROTATION
    // ==========================
    if ($brandIndex >= count($brands)) {
        $brandIndex = 0;
    }

    $brand = trim($brands[$brandIndex]);
    $brandIndex++;

    // ==========================
    // PATH FILE
    // ==========================
    $file = __DIR__ . "/" . $page;

    // buat folder otomatis
    $dir = dirname($file);

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // ==========================
    // CLEAN SLUG
    // ==========================
    $slug = preg_replace(
        '/\.(html?|php|txt|shtml)$/i',
        '',
        $page
    );

    $slugText = str_replace(
        ['/', '_', '-'],
        ' ',
        $slug
    );

    // ==========================
    // TITLE & DESC
    // ==========================
    $title = $brand;

    $description =
        "Halaman informasi " .
        $slugText .
        " dari " .
        $brand;

    // ==========================
    // TEMPLATE RENDER
    // ==========================
    $html = str_replace(
        ['{{title}}', '{{description}}'],
        [$title, $description],
        $template
    );

    // ==========================
    // WRITE FILE
    // ==========================
    if (file_put_contents($file, $html)) {

        echo "SUCCESS : " . $page . "<br>";

        $success++;

    } else {

        echo "FAILED : " . $page . "<br>";

        $failed++;
    }
}

// ==========================
// RESULT
// ==========================
echo "<hr>";
echo "Success : $success<br>";
echo "Failed : $failed<br>";

?>