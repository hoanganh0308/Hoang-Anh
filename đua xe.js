<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Car Racing Game</title>
    <style>
        #container {
            position: relative;
            height: 100vh;
            top: 0%;
        }

        .button_1,
        .button_2,
        .button_3,
        .button_4 {
            position: absolute;
            padding: 15px 25px;
            font-size: 24px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: red;
            background-color: rgb(235, 235, 34);
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
            left: 75%;
            min-width: 300px;
        }

        .button_1 {
            top: 250px;
        }

        .button_2 {
            top: 350px;
        }

        .button_3 {
            top: 450px;
        }

        .button_4 {
            top: 550px;
        }

        .button_1:hover,
        .button_2:hover,
        .button_3:hover,
        .button_4:hover {
            background-color: #3e8e41
        }

        .button_1:active,
        .button_2:active,
        .button_3:active,
        .button_4:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        body,
        html {
            height: 100%;
            margin: 0;
        }

        .pic {
            /* The image used */
            background-image: url("temp.jpeg");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        p {
            position: absolute;
            top: -140px;
            left: 25%;
            color: rgb(235, 235, 34);
            font-family: 'Courier New', Courier, monospace;
            font-size: 140px;
        }
    </style>
</head>

<body>
    <div class="pic" id="container">
        <p>ℂ𝔸ℝ ℝ𝔸ℂ𝔼</p>
        <button id="single_player" class="button_1">SINGLE PLAYER</button>
        <button id="dual_player" class="button_2">DUAL PLAYER</button>
        <button id="tutorial" class="button_3">TUTORIAL</button>
        <button id="about" class="button_4">ABOUT</button>
    </div>

    <script type="text/javascript">
        document.getElementById("single_player").onclick = function () {
            location.href = "Single_player.html";
        };
        document.getElementById("dual_player").onclick = function () {
            location.href = "multi_player.html";
        };
        document.getElementById("tutorial").onclick = function () {
            location.href = "tutorial.html";
        };
        document.getElementById("about").onclick = function () {
            location.href = "about.html";
        };
    </script>
</body>

</html>
        
     

    
