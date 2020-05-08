<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            * {
                margin: 0;
                padding: 0;
            }

            body {
                font-family: sans-serif;
                font-size: 14px;
                font-weight: bold;
            }

            .wrapper {
                min-height: 100vh;
                min-width: 100vw;
                display: flex;
                flex-direction: column;
                -ms-align-items: center;
                align-items: center;
                justify-content: center;
            }

            .wrapper-item {
                min-width: 100%;
                min-height: 100%;
                display: flex;
                flex-direction: row;
                -ms-align-items: center;
                align-items: center;
                justify-content: center;
            }

            .block {
                width: 700px;
                background-color: #e6e6e6;
                border: 1px solid #b7b7b7;
                border-radius: 5px;
                padding: 10px;
            }

            .input-item {
                margin-bottom: 5px;

            }

            input {
                width: 680px;
                font-size: 14px;
                padding: 6px 0 4px 10px;
                border: 1px solid #cecece;
                background: #F6F6f6;
                font-family: 'Harmonia Sans', sans-serif;
            }

            .choose{
                width: 150px;
                height: 30px;
                margin: 10px 0 10px 0;
                background-color: #ffebec;
            }

            .shorten {
                width: 200px;
                height: 40px;
                margin: 10px 0 10px 0;
                background-color: #7ac601;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
                <div class="wrapper">
                    <div class="wrapper-item">
                        <div class="block">
                            <div class="input-item">
                                <span>Введите адрес исходной ссылки</span><br>
                                <input type="text"/>
                            </div>
                            <div class="input-item">
                                <span>Введите заголовок opengraph</span><br>
                                <input type="text"/>
                            </div>
                            <div class="input-item">
                                <span>Введите описание opengraph</span><br>
                                <input type="text"/>
                            </div>
                            <div class="button-img">
                                <span>Прикрепите изображение</span><br>
                                <button class="choose">Выбрать</button>
                            </div>
                            <div class="button-shorten">
                                <button class="shorten">Сократить ссылку</button>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </body>
</html>
