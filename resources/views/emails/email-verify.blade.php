<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MyMentor</title>

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
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content row">
                <div class="title m-b-md col-lg-12">
                    My Mentor
                </div>

                <div class="links col-lg-12">

                    <p>Your registered email-id is <h5>{{$user->email}}</h5> , Please click on the below link to verify your email account
                    </p>
                    <br>
                    <div><p>token: {{$user->remember_token}}</p> </div>

                        <br/>
                    <a href="{{url('api/v1/auth/verify')}}?token={{$user->remember_token}}">Verify Email api</a>
                    <br>
                    <br>
                    <a href="http://localhost:4200/verify-email?token={{$user->remember_token}}">Verify Email angular Local</a>
                    <br>
                    <a href="https://mohamd-khairy.github.io/mymentor-angular/verify-email?token={{$user->remember_token}}">Verify Email angular server</a>

                </div>
            </div>
        </div>
    </body>
</html>
