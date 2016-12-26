<!doctype html>
<html>
    <head>
        <title>Scaffold</title>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300" rel="stylesheet">

        <?php if (isset($styles)) : foreach ($styles as $style) : ?>
            <link rel="stylesheet" href="<?php echo $style; ?>">
        <?php endforeach; endif; ?>
    </head>
    <body>
        <?php module('header', ['name' => $message . ' ' . $text]); ?>
    </body>

    <?php if (isset($scripts)) : foreach ($scripts as $script) : ?>
        <script src="<?php echo $script; ?>"></script>
    <?php endforeach; endif; ?>
</html>