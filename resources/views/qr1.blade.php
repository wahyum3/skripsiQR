<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h2>QR Code Generator</h2>
        <p>Data: {{ $data }}</p>
        
        {!! QrCode::size(200)->generate($data) !!}
        
    </div>
</body>
</html>
