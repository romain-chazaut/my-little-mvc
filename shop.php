<?php
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$cloth = new \App\Model\Clothing();
$electronic = new \App\Model\Electronic();

$clothTab = $cloth->findAll();
$electronicTab = $electronic->findAll();

?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Job-02</title>
    </head>

    <body>
        <h1>Tableau des produits de clothing</h1>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Photos</th>
                <th>Price</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Category_id</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Size</th>
                <th>Color</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($clothTab as $cloth) { ?>
                    <tr>
                        <td><?php echo $cloth->getId() ?></td>
                        <td><?php echo $cloth->getName() ?></td>
                        <td><?php echo $cloth->getPhotos() ?></td>
                        <td><?php echo $cloth->getPrice() ?></td>
                        <td><?php echo $cloth->getDescription() ?></td>
                        <td><?php echo $cloth->getQuantity() ?></td>
                        <td><?php echo $cloth->getCategoryId() ?></td>
                        <td><?php echo $cloth->getCreatedAt() ?></td>
                        <td><?php echo $cloth->getUpdatedAt() ?></td>
                        <td><?php echo $cloth->getSize() ?></td>
                        <td><?php echo $cloth->getColor() ?></td>
                        <td><?php echo $cloth->getType() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h1>Tableau des produits de electronic</h1>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Photos</th>
                <th>Price</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Category_id</th>
                <th>Created_at</th>
                <th>Updated_at</th>
                <th>Waranty_fee</th>
                <th>Brand</th>

            </tr>
            </thead>
            <tbody>
                <?php foreach ($electronicTab as $electronic) { ?>
                    <tr>
                        <td><?php echo $electronic->getId() ?></td>
                        <td><?php echo $electronic->getName() ?></td>
                        <td><?php echo $electronic->getPhotos() ?></td>
                        <td><?php echo $electronic->getPrice() ?></td>
                        <td><?php echo $electronic->getDescription() ?></td>
                        <td><?php echo $electronic->getQuantity() ?></td>
                        <td><?php echo $electronic->getCategoryId() ?></td>
                        <td><?php echo $electronic->getCreatedAt() ?></td>
                        <td><?php echo $electronic->getUpdatedAt() ?></td>
                        <td><?php echo $electronic->getWarantyFee() ?></td>
                        <td><?php echo $electronic->getBrand() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>
