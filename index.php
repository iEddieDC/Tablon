
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cualtos chan</title>
    <link rel="stylesheet" href="resources/css/Main.css">
    
</head>

<body>
    <header>
        <h1>CUALTOS-CHAN</h1>
    </header>
    <div id="phpHeader">
    <?php include 'resources/php/header.php';?>
    </div>
    <main id="IndexMain">
        <div id="phpCategories">  
        <?php include 'resources/php/categories.php';?>
        <?php/* include 'resources/php/upload.php';*/?>
        </div>
        <div id="phpLastPost">
        <?php include 'resources/php/lastpost.php';?>
        </div>
    </main>
</body>
    <div id="phpFooter">
    <?php include 'resources/php/footer.php';?>
    </div>
</html>