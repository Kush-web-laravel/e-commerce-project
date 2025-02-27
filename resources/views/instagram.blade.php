<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram View</title>
    <style>
        .instagram-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .instagram-gallery img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
    
</head>
<body>
<div class="instagram-gallery">
    @foreach($mediaData['data'] as $media)
        @if($media['media_type'] === 'IMAGE') 
            <img src="{{ $media['media_url'] }}" alt="Instagram Post">
        @endif
    @endforeach
</div>
</body>
</html>