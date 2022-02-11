<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>おかき管理</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    
    <body>
        <header>
            <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #F8BC54;">
                <div class="col-12 clearfix">
                    <a class="navbar-brand" href="/"><h2><i class="fas fa-cat mr-2"></i>おかき管理</h2></a>
                    <a class="navbar-brand float-right mt-2" href="/food_weight"><i class="fas fa-fish mr-2"></i>ご飯の量</a>
                </div>
            </nav>
        </header>
        
        <div class="content container">
            @yield('content')
        </div>
        
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>