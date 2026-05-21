<?php
/**
 * One-time deployment setup script.
 * DELETE THIS FILE immediately after running it.
 */

// Secret token to prevent unauthorized access
define('SECRET', 'halzanin-deploy-2026');

if (($_GET['token'] ?? '') !== SECRET) {
    http_response_code(403);
    die('Forbidden.');
}

$action = $_GET['run'] ?? '';

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

function runArtisan($kernel, $command, $args = []) {
    echo "<strong>$ php artisan $command</strong><br>";
    $code = $kernel->call($command, $args);
    $output = $kernel->output();
    echo nl2br(htmlspecialchars($output));
    echo "Exit code: $code<br><br>";
    return $code;
}

echo '<!DOCTYPE html><html><head><meta charset="utf-8">
<title>Halzanin Deploy Setup</title>
<style>
  body{font-family:monospace;background:#111;color:#0f0;padding:30px;font-size:14px;}
  strong{color:#fff;}
  .btn{display:inline-block;margin:8px 4px;padding:10px 20px;background:#1B4F8A;color:#fff;text-decoration:none;border-radius:6px;font-family:sans-serif;}
  .danger{background:#dc2626;}
  .success{color:#4ade80;}
  .error{color:#f87171;}
  h2{color:#fff;font-family:sans-serif;}
</style></head><body>';

echo '<h2>Halzanin Deployment Setup</h2>';

if ($action === 'all') {
    echo '<pre>';
    runArtisan($kernel, 'key:generate', ['--force' => true]);
    runArtisan($kernel, 'migrate', ['--force' => true]);
    runArtisan($kernel, 'storage:link', ['--force' => true]);
    runArtisan($kernel, 'config:cache');
    runArtisan($kernel, 'route:cache');
    runArtisan($kernel, 'view:cache');
    echo '</pre>';
    echo '<p class="success">✓ Setup complete! <strong>Delete this file now.</strong></p>';
    echo '<a href="?token=' . SECRET . '&run=delete" class="btn danger">Delete this file</a>';

} elseif ($action === 'migrate') {
    echo '<pre>';
    runArtisan($kernel, 'migrate', ['--force' => true]);
    echo '</pre>';

} elseif ($action === 'delete') {
    unlink(__FILE__);
    echo '<p class="success">✓ deploy-setup.php has been deleted. You are safe.</p>';
    echo '<p><a href="/" style="color:#60a5fa;">Go to site →</a></p>';

} else {
    echo '<p>Choose an action:</p>';
    echo '<a href="?token=' . SECRET . '&run=all" class="btn">Run Full Setup (recommended)</a>';
    echo '<a href="?token=' . SECRET . '&run=migrate" class="btn">Run Migrations Only</a>';
    echo '<br><br><p style="color:#f87171;">⚠ Delete this file immediately after setup.</p>';
}

echo '</body></html>';
