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
            background-color: #f0f2f5;
            color: #222;
        }

        .container {
            padding: 16px;
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
            margin-top: 16px;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .language-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .language-buttons button {
            flex: 1 1 30%;
            min-width: 90px;
            padding: 12px;
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .language-buttons button:hover {
            background: linear-gradient(135deg, #1e88e5, #1565c0);
            transform: translateY(-2px);
        }

        .audio-container {
            background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
            border: 1px solid #81d4fa;
            border-radius: 12px;
            padding: 16px 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-top: 10px;
            transition: transform 0.2s ease;
        }

        .audio-container:hover {
            transform: scale(1.01);
        }

        .audio-container::before {
            content: "Audio Player";
            display: block;
            font-weight: 600;
            font-size: 15px;
            color: #0277bd;
            margin-bottom: 8px;
        }

        audio {
            width: 100%;
            outline: none;
            border-radius: 6px;
            background-color: #ffffff;
        }

        @media (max-width: 480px) {
            .language-buttons button {
                flex: 1 1 45%;
                font-size: 13px;
                padding: 10px;
            }

            .container {
                padding: 12px;
            }

            .audio-container {
                padding: 8px;
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

        <div class="audio-container">
            <audio id="audioPlayer" controls>
                <source id="audioSource" src="" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>

    </div>

    <script>
        function playAudio(language) {
            const basePath = "{{ asset('website') }}"; // Base public path
            const audioSource = document.getElementById('audioSource');
            const audioPlayer = document.getElementById('audioPlayer');

            audioSource.src = `${basePath}/${language}.mp3`;
            audioPlayer.load();
            audioPlayer.play();
        }
    </script>

</body>

</html>
