<?php
// Minimal session test - put this in the ROOT of your project
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Step 1: Before any session code<br>";
flush();

if (session_status() === PHP_SESSION_NONE) {
    echo "Step 2: Starting session<br>";
    flush();

    // Set session save path explicitly
    $savePath = '/home2/nextt3ac/lifeinsdata.com/sessions';
    if (!is_dir($savePath)) {
        echo "ERROR: Save path does not exist: $savePath<br>";
    } else {
        echo "Step 3: Save path exists: $savePath<br>";
        flush();
        session_save_path($savePath);

        $result = session_start();
        echo "Step 4: session_start() returned: " . ($result ? "true" : "false") . "<br>";
        echo "Step 5: Session ID: " . session_id() . "<br>";
        flush();

        if ($result) {
            echo "Step 6: Setting session data<br>";
            flush();
            $_SESSION['test'] = 'Hello World';
            $_SESSION['time'] = time();
            $_SESSION['admin'] = 'testuser';

            echo "Step 7: Session data set: <pre>" . print_r($_SESSION, true) . "</pre>";
            flush();

            echo "Step 8: Calling session_write_close()<br>";
            flush();
            session_write_close();

            echo "Step 9: Checking session file...<br>";
            flush();

            $sessionFile = $savePath . '/sess_' . session_id();
            if (file_exists($sessionFile)) {
                $size = filesize($sessionFile);
                echo "Step 10: Session file EXISTS, size: $size bytes<br>";
                if ($size > 0) {
                    echo "<span style='color:green'>SUCCESS: Session file has data!</span><br>";
                    echo "File content: " . htmlspecialchars(file_get_contents($sessionFile)) . "<br>";
                } else {
                    echo "<span style='color:red'>FAILURE: Session file is EMPTY!</span><br>";
                }
            } else {
                echo "<span style='color:red'>FAILURE: Session file does NOT exist!</span><br>";
            }

            echo "<hr><h2>Refresh the page to test if session persists</h2>";

            // On refresh, try to read the session
            if (isset($_SESSION['test'])) {
                echo "<span style='color:green'>Session PERSISTED! Value: " . $_SESSION['test'] . "</span><br>";
            } else {
                echo "<span style='color:red'>Session LOST on refresh!</span><br>";
            }
        }
    }
} else {
    echo "Session already active. ID: " . session_id() . "<br>";
}
?>