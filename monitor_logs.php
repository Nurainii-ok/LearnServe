<?php
// Monitor Laravel logs in real-time
$logFile = __DIR__ . '/storage/logs/laravel.log';

if (!file_exists($logFile)) {
    echo "Log file not found: $logFile\n";
    exit(1);
}

echo "Monitoring Laravel logs... (Press Ctrl+C to stop)\n";
echo "Log file: $logFile\n";
echo str_repeat("-", 80) . "\n";

// Get current file size
$lastSize = filesize($logFile);

while (true) {
    clearstatcache();
    $currentSize = filesize($logFile);
    
    if ($currentSize > $lastSize) {
        // New content added
        $handle = fopen($logFile, 'r');
        fseek($handle, $lastSize);
        
        while (($line = fgets($handle)) !== false) {
            echo $line;
        }
        
        fclose($handle);
        $lastSize = $currentSize;
    }
    
    usleep(500000); // Sleep for 0.5 seconds
}
?>