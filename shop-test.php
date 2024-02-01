<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// connexion PDO.
$pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';port=' . $_ENV['DB_PORT'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

// requête pour récupérer tous les produits.
$sql = 'SELECT * FROM product ORDER BY created_at DESC';
$query = $pdo->prepare($sql);
$query->execute();

// affichage de tous les produits.
$products = $query->fetchAll(PDO::FETCH_ASSOC);

// echo('<pre>');
// var_dump($products);
// echo('</pre>');

// déterminer sur quelle page on se trouve.
if(isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

// déterminer le nombre total de produits.
$sql = 'SELECT COUNT(*) AS nb_products FROM product';
$query = $pdo->prepare($sql);
$query->execute();
$result = $query->fetch();
$nbProducts = (int) $result['nb_products'];

// echo('<pre>');
// echo 'Nombre total de produits dans la boutique : ' . htmlspecialchars($nbProducts);
// echo('</pre>');

// déterminer le nombre de produits par page.
$perPage = 4;

// calculer le nombre de pages total.
$pages = ceil($nbProducts / $perPage);

// calculer du 1er produit de la page.
$first = ($currentPage * $perPage) - $perPage;

$sql = 'SELECT * FROM product ORDER BY created_at DESC LIMIT :first, :perPage';

$query = $pdo->prepare($sql);
$query->bindValue(':first', $first, PDO::PARAM_INT);
$query->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$query->execute();
$products = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test pagination</title>
</head>
<body>

    <h1>Liste des produits</h1>
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Titre</th>
                <th>Date</th>
            </thead>
    <?php
    // On boucle sur tous les articles
        foreach ($products as $product){
    ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['created_at'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><?= $product['price'] ?></td>
        </tr>
    <?php
        }
    ?>
        </table>
    <div class="pagination-nav">
        
        <a href="shop-test.php?page=<?= $currentPage - 1 ?>" class="page-link">
            <button class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">Précédent</button>    
        </a>

        <?php for($page = 1; $page <= $pages; $page++): ?>
            
            <a href="shop-test.php?page=<?= $page ?>" class="page-link">
                <button class="page-item <?= ($currentPage == $page) ? "active" : "" ?>"><?= $page ?></button>
            </a>

        <?php endfor ?>
        
        <a href="shop-test.php?page=<?= $currentPage + 1 ?>" class="page-link">
            <button  class="page-item" <?= ($currentPage == $pages) ? "disabled" : "" ?> >Suivant</button>    
        </a>
    </div>
</body>
</html>