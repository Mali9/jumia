<!DOCTYPE html>
<html lang="en">

<head>
    <title>403 Forbidden</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- font -->

    <link href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
    <style>
        body {
            background: url(https://dimofinf.net/cmsdevimages/error_pages/403/Background.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            color: #c1d2e5;
            font-family: 'droid arabic kufi', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-attachment: fixed;
        }

        .container-circles {
            position: relative;

        }

        /* Circle outside */
        .circle-outside {
            /* position:absolute; */
            width: 650px;
            height: 650px;
            animation-name: spin;
            animation: spin 5s linear infinite;
            border: 2px solid rgba(221, 221, 221, 0.10196078431372549);
            background-color: rgba(221, 221, 221, 0.03);
            border-radius: 50%;
            margin-top: 10%;
        }

        .circle-hide {
            width: 650px;
            height: 650px;
            animation-name: points;
            animation: points 5s linear infinite;
            border-radius: 50%;
            position: absolute;
            top: 0;
            z-index: -9;
        }

        .circle-outside .rocket-img {
            -ms-transform: rotate(62deg);
            /* IE 9 */
            -webkit-transform: rotate(62deg);
            /* Safari 3-8 */
            transform: rotate(62deg);
            position: absolute;
            top: 14%;
        }

        .circle-hide .point1 {
            top: -1%;
            left: 50%;
        }

        .circle-hide .point2 {
            bottom: 7%;
            left: 22%;
        }

        .circle-hide .point3 {
            right: -1%;
            bottom: 50%;
        }

        /* circle middle */
        .circle-middle {
            width: 500px;
            height: 500px;
            border: 2px solid rgba(221, 221, 221, 0.1);
            border-radius: 50%;
            position: absolute;
            animation-name: points;
            animation: points 5s linear infinite;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
        }

        .points {
            position: absolute;
        }

        .point1 {
            top: 35%;
        }

        .point2 {
            bottom: -1%;
            left: 40%;
        }

        .point3 {
            right: 1%;
            bottom: 65%;
        }

        /* Cricle inside */
        .circle-inside {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 370px;
            height: 370px;
            border-radius: 50%;
            position: absolute;
            animation-name: points;
            /* animation:points 5s linear infinite; */
            background-color: rgba(221, 221, 221, 0.06);
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
        }

        /* texts */
        .face-error {
            margin: 10% 0 2%;
            width: 20%;
        }

        .error-txt {
            font-size: 70px;
            color: #fff;
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .msg-error {
            font-size: 15px;
            color: #fff;
            font-weight: 700;
        }

        .content-txt p {
            color: #a5b2be;
            font-size: 12px;
            margin: 0;
            padding: 0 30px;
        }

        .hosted {
            position: absolute;
            right: 0;
            bottom: 14%;
            left: 0;
            margin: auto;
            z-index: 9;
        }

        .hosted p {
            font-size: 10px;
            color: #fff;
            margin: 0px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .hosted img {
            width: 10%;
        }

        .back {
            padding: 30px 0;
        }

        .btn-outline-white {
            background-color: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .btn-outline-white:focus,
        .btn-outline-white:hover,
        .btn-outline-white:active {
            background-color: #fff;
            color: #37435D;
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            25% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            25% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }

        }

        @-moz-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            25% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }

        }

        @keyframes points {
            0% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }

            25% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            100% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
        }

        @-webkit-keyframes points {
            0% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }

            25% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            100% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
        }

        @-moz-keyframes points {
            0% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }

            25% {
                -webkit-transform: rotate(270deg);
                transform: rotate(270deg);
            }

            50% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }

            75% {
                -webkit-transform: rotate(90deg);
                transform: rotate(90deg);
            }

            100% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
        }

        .content-txt {
            width: 70%;
        }

        @media screen and (max-width: 1024px) {

            .circle-outside,
            .circle-hide {
                width: 550px;
                height: 550px;
                margin: auto;
            }

            .container-circles {
                position: relative;
                margin: 30px auto;
                zoom: 1;
            }

            .circle-middle {
                width: 360px;
                height: 360px;
            }

            .circle-inside {
                width: 300px;
                height: 300px;
            }

            .error-txt {
                font-size: 30px;
            }

            .msg-error {
                font-size: 10px;
            }

            .content-txt p {
                font-size: 8px;
            }

            .hosted p {
                font-size: 6px;
                line-height: .3px;
            }

            .hosted {
                bottom: 8%;
                margin: auto;
            }

            .hosted img {
                width: 20%;
            }
        }

        @media screen and (max-width: 700px) {

            .circle-outside,
            .circle-hide {
                width: 85vw;
                height: 85vw;
                margin: auto;
            }

            .container-circles {
                position: relative;
                margin: 20% auto 30%;
                zoom: 1;
            }

            .circle-middle {
                width: 70vw;
                height: 70vw;
            }

            .circle-inside {
                width: 200px;
                height: 200px;
            }

            .error-txt {
                font-size: 30px;
            }

            .msg-error {
                font-size: 10px;
            }

            .content-txt p {
                font-size: 8px;
            }

            .hosted p {
                font-size: 6px;
                line-height: .3px;
            }

            .hosted {
                bottom: -15%;
                margin: auto;
            }

            .hosted img {
                width: 20%;
            }
        }
    </style>
</head>

<body>
    <div class="error-page">
        <div class="container">
            <div class="container-circles">

                <div class="circle-outside">
                    <img class="rocket-img" src="https://dimofinf.net/cmsdevimages/error_pages/403/rocket.png" alt=""
                        width="15%">

                </div>
                <div class="circle-hide">
                    <img class="points point1" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="2%">
                    <img class="points point2" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="2%">
                    <img class="points point3" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="2%">

                </div>
                <div class="circle-middle">
                    <img class="points point1" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="3%">
                    <img class="points point2" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="3%">
                    <img class="points point3" src="https://dimofinf.net/cmsdevimages/error_pages/403/points.png" alt=""
                        width="3%">

                </div>
                <div class="circle-inside text-center">
                    <img class="face-error" src="https://dimofinf.net/cmsdevimages/error_pages/403/403.png" alt="">
                    <div class="content-txt">
                        <h1 class="error-txt">403</h1>
                        <h2 class="msg-error">Forbidden error</h2>
                        <h2 class="msg-error">خطأ 403</h2>
                        <p>ليس لديك صلاحية الدخول الى الصفحة</p>
                    </div>
                </div>
                <div class="hosted text-center">
                    <p>hosted by</p>
                    <a href="https://dimofinf.net">
                        <img src="https://dimofinf.net/cmsdevimages/error_pages/500/logo.png" alt="">
                    </a>
                </div>
            </div>
            <div class="text-center back">
                <a class="btn btn-outline-white" href="/dashboard">الرجوع إلى الرئيسية</a>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    window.setTimeout(function() {
history.go(-1);
    }, 3000);
</script>