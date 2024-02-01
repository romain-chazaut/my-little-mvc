<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Initialisation de Dotenv pour charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

// Supposons que vous avez une classe Product qui inclut une méthode findPaginated
// et une méthode pour compter le total des produits pour la pagination
$productModel = new \App\Model\Product(); // Assurez-vous que cette classe existe

// Récupération du numéro de la page depuis l'URL, avec 1 comme valeur par défaut
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Récupération des produits paginés et du nombre total de produits
$products = $productModel->findPaginated($page, 5); // 5 produits par page
$totalProducts = $productModel->count(); // Méthode pour compter le total des produits
$totalPages = ceil($totalProducts / 5);

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>RAM SHOP</title>
</head>
<body>
    <h1>Nos produits</h1>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Photos</th>
                <th>Description</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id'] ?? '') ?></td>
                <td><?= htmlspecialchars($product['name'] ?? '') ?></td>
                <td><?= htmlspecialchars($product['photos'] ?? '') ?></td>
                <td><?= htmlspecialchars($product['description'] ?? '') ?></td>
                <td><?= htmlspecialchars($product['price'] ?? '') ?> €</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<!-- Pagination -->
<div class="pagination">
    <!-- Bouton Précédent -->
    <?php if ($page > 1): ?>
        <a class="pagination-button" href="?page=<?= $page - 1 ?>" aria-label="Previous">Précédent</a>
    <?php endif; ?>

    <!-- Liens des Numéros de Page -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a class="number-button" <?= ($i == $page) ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>

    <!-- Bouton Suivant -->
    <?php if ($page < $totalPages): ?>
        <a class="pagination-button" href="?page=<?= $page + 1 ?>" aria-label="Next">Suivant</a>
    <?php endif; ?>
</div>

</body>
</html>
