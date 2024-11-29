<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>403 Forbidden</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f8d7da;
                    color: #721c24; 
                }

            
                .container {
                    text-align: center;
                }

                h1 {
                    font-size: 3rem;
                    margin: 0;
                }

                p {
                    font-size: 1.25rem;
                    margin: 0;
                }

                a {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    color: #721c24;
                    background-color: #f5c6cb;
                    text-decoration: none;
                    border-radius: 5px;
                }

                a:hover {
                    background-color: #f1b0b7;
                }
            </style>
    </head>

    <body>
        <div class="container">
            <h1>{{$errorCode}} Forbidden</h1>
            <p>{{$title}}</p>
            @if(auth()->check() && auth()->user()->role == 'Admin')
            <a href="{{ url('/admindashboard') }}">Return to Home</a>
            @else
            <a href="{{ url('/cashierdashboard')}}">Return to Home</a>
            @endif
        </div>
    </body>
</html>