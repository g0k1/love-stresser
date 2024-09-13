<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    function generateToken($length = 100) {
        return bin2hex(random_bytes($length / 2));
    }
    $token = generateToken();
    echo json_encode(['token' => $token]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time to Crack Test</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600&display=swap');
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Urbanist', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            padding: 50px;
            height: 850px;
            margin-top: 150px;
            width: 900px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            text-align: center;
        }
        h1 {
            color: #e0e0e0;
        }
        .button-ga542 {
            align-items: center;
            justify-content: center;
            align-self: center;
            border-radius: 10px;
            padding: 10px;
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            color: #FFFFFF;
            border: none;
            height: 62px;
            width: 154px;
            background: linear-gradient(57.75deg, #F70FFF 14.44%, #2C63FF 85.65%);
            box-shadow: 0 16px 24px rgba(247, 15, 255, 0.48);
            cursor: pointer;
            margin: 30%;
            margin-bottom: 10px;
        }
        button:hover {
            background: linear-gradient(57.75deg, #2C63FF 14.44%, #F70FFF 85.65%);
        }
        #timer, #tokenDisplay, #generatedToken, #attempts {
            margin-top: 20px;
            font-size: 20px;
        }
        #token, #generatedTokenSpan, #currentToken {
            color: #4caf50;
        }
        .matched {
            color: #4caf50;
        }
        .not-matched {
            color: #f44336;
        }
        input {
            width: 100%;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 16px 24px;
            font-size: 16px;
            line-height: 22px;
            font-family: 'Urbanist', sans-serif;
        }
    </style>
</head>
<body>
    
    <div class="container">
    <center>
        <h1>Time to Crack Test</h1>
        <button class="button-ga542" id="crackButton">Try to Crack</button>
        <div id="generatedToken">Generated Token: <span id="generatedTokenSpan"></span></div>
        <div id="timer">Time: 0s</div>
        <span id="token"></span>
        <span>Attempting: </span><div id="currentToken"><span id="currentTokenSpan"></span></div>
        <div id="attempts">Attempts: 0</div>
    </center>
    </div>
    <script>
        document.getElementById('crackButton').addEventListener('click', function() {
            fetch(window.location.href, { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'generate=true'
            })
            .then(response => response.json())
            .then(data => {
                const originalToken = data.token;
                document.getElementById('generatedTokenSpan').textContent = originalToken;
                document.getElementById('token').textContent = '';
                document.getElementById('currentTokenSpan').textContent = '';
                document.getElementById('currentTokenSpan').classList.remove('matched', 'not-matched');

                let attempts = 0;
                let startTime = Date.now();

                function updateTimer() {
                    let elapsedTime = (Date.now() - startTime) / 1000;
                    document.getElementById('timer').textContent = `Time: ${elapsedTime.toFixed(2)}s`;
                }

                function attemptToCrack() {
                    let generatedToken = generateRandomToken(100);
                    attempts++;
                    document.getElementById('attempts').textContent = `Attempts: ${attempts}`;
                    document.getElementById('currentTokenSpan').textContent = generatedToken;

                    if (generatedToken === originalToken) {
                        document.getElementById('currentTokenSpan').classList.remove('not-matched');
                        document.getElementById('currentTokenSpan').classList.add('matched');
                        clearInterval(timerInterval);
                        alert(`Token cracked in ${attempts} attempts and ${(Date.now() - startTime) / 1000} seconds!`);
                    } else {
                        document.getElementById('currentTokenSpan').classList.remove('matched');
                        document.getElementById('currentTokenSpan').classList.add('not-matched');
                        setTimeout(attemptToCrack, 0);
                    }
                }

                function generateRandomToken(length) {
                    let result = '';
                    let characters = '0123456789abcdef';
                    let charactersLength = characters.length;
                    for (let i = 0; i < length; i++) {
                        result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    }
                    return result;
                }

                let timerInterval = setInterval(updateTimer, 100);
                attemptToCrack();
            });
        });
    </script>
</body>
</html>
