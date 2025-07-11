<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konark Temple</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            padding: 16px;
            max-width: 600px;
            margin: auto;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .language-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .language-buttons button {
            flex: 1 1 28%;
            min-width: 90px;
            max-width: 100px;
            padding: 12px 8px;
            background-color: #1e88e5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }

        .language-buttons button:hover {
            background-color: #1565c0;
        }

        audio {
            width: 100%;
            margin-top: 10px;
            border-radius: 8px;
        }

        @media screen and (max-width: 400px) {
            .language-buttons button {
                flex: 1 1 40%;
                font-size: 13px;
                padding: 10px 6px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="{{ asset('website/konarks.jpg') }}" alt="Konark Temple">

        <div class="language-buttons">
            <button onclick="playAudio('hindi')">Hindi</button>
            <button onclick="playAudio('odia')">Odia</button>
            <button onclick="playAudio('english')">English</button>
            <button onclick="playAudio('bengali')">Bengali</button>
            <button onclick="playAudio('telugu')">Telugu</button>
            <button onclick="playAudio('tamil')">Tamil</button>
            <button onclick="playAudio('kannada')">Kannada</button>
            <button onclick="playAudio('marathi')">Marathi</button>
            <button onclick="playAudio('punjabi')">Punjabi</button>
        </div>

        <audio id="audioPlayer" controls>
            <source id="audioSource" src="" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>

    <script>
        function playAudio(language) {
            const audioSource = document.getElementById('audioSource');
            const audioPlayer = document.getElementById('audioPlayer');
            audioSource.src = `{{ asset('website/hindi.mp3') }}/${language}.mp3`;
            audioPlayer.load();
            audioPlayer.play();
        }
    </script>

</body>
</html>
w