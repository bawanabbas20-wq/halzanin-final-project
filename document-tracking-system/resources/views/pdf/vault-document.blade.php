<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scanned Document</title>
    <style>
        body { margin: 0; padding: 20px; font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .document-type { font-size: 24px; font-weight: bold; text-transform: uppercase; }
        .timestamp { font-size: 12px; color: #666; margin-top: 5px; }
        .image-container { text-align: center; margin-top: 30px; }
        img { max-width: 100%; max-height: 800px; border: 1px solid #ccc; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="header">
        <div class="document-type">{{ $type }} Scan</div>
        <div class="timestamp">Digitally Scanned & Encrypted on {{ now()->format('M d, Y h:i A') }}</div>
    </div>
    
    <div class="image-container">
        <img src="{{ $image }}" alt="Document Scan">
    </div>
</body>
</html>
