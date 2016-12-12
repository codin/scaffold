<!doctype html>
<html>
    <head>
        <title>Scaffold</title>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">
        <style>
            
            body {
                background: #eee;
                padding: 0;
                margin: 0;
            }

            h1 {
                color: #051129;
                font-family: 'Source Sans Pro', sans-serif;
                font-size: 40px;
                font-weight: lighter;
                left: 50%;
                position: absolute;
                top: 30%;
                transform: translateX(-50%);
                text-shadow: 0px 2px 1px #fff;
            }

        </style>
    </head>
    <body>
        <?php // module('header', ['name' => 'testing']); ?>
        <h1><?php echo $message; ?> <?php echo $text; ?></h1>
    </body>
</html>