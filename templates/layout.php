<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Pizza</title>
    <link href="style/standard.css" rel="stylesheet" />
    <link href="style/petit.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="preload" as="pizzaHorizon" href="pizzaHorizon.jpg">
</head>

<body>
    <header>

    </header>
    <main>
        <h1><span>Pizza</span></h1>
        <form method="post">
            <fieldset>
                <button type="submit" name='commande' value="nouvelle">Nouvelle Commande</button>
                <button>actualiser</button>
            </fieldset>

            <?= $menu ?>
        </form>
    </main>
    <?php
    if ($ticket ?? null) {
        echo $ticket;
    }
    ?>
</body>

</html>