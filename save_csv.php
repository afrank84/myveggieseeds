<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tableData'])) {
        $tableData = json_decode($_POST['tableData'], true);

        $file = fopen('events/records.csv', 'w');

        // Write the header row
        fputcsv($file, ['Date', 'Event', 'Description']);

        // Write the table data
        foreach ($tableData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
    // Redirect to the previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
