<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title)? $page_title : 'NULL'; ?></title>

    <?php foreach($styles as $style): ?>
        <link href="<?php echo URL::base(); ?>css/<?=$style ?>.css" rel="stylesheet" type="text/css" />
    <?php endforeach; ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">
<?php
echo $content;
?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<?php foreach($scripts as $script): ?><script src="<?php echo URL::base(); ?>js/<?php echo $script; ?>.js"></script>
<?php endforeach; ?>

</body>
</html>