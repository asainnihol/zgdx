<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO N Hacker Portal</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');
        
        body {
            background: #000;
            color: #0f0;
            font-family: 'Press Start 2P', monospace;
            text-align: center;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        
        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .logo {
            font-size: 3em;
            font-weight: bold;
            text-shadow: 0 0 10px #0f0, 0 0 20px #0f0;
            animation: glitch 1s infinite;
        }

        @keyframes glitch {
            0% { text-shadow: 2px 2px 0 red, -2px -2px 0 blue; }
            50% { text-shadow: -2px -2px 0 red, 2px 2px 0 blue; }
            100% { text-shadow: 2px 2px 0 red, -2px -2px 0 blue; }
        }

        .hacker-text {
            font-size: 1.2em;
            color: #0f0;
            text-shadow: 0 0 5px #0f0;
            margin-top: 10px;
            white-space: nowrap;
            overflow: hidden;
            border-right: 2px solid #0f0;
            width: 20ch;
            animation: typing 3s steps(20) infinite alternate;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 20ch; }
        }

        .btn {
            margin-top: 20px;
            padding: 15px 30px;
            font-size: 1.2em;
            color: #000;
            background: #0f0;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 0 10px #0f0;
        }

        .btn:hover {
            background: red;
            box-shadow: 0 0 20px red;
        }

        .matrix-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://media.giphy.com/media/xT9IgzoKnwFNmISR8I/giphy.gif') repeat;
            opacity: 0.2;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="matrix-bg"></div>
    <div class="container">
        <div class="logo">SEO N</div>
        <div class="hacker-text">THE GHOST OF THE WEB</div>
        <button class="btn" onclick="window.location.href='https://imgsaya.online/me/hehe.mp4'">ENTER</button>
    </div>
</body>
</html>