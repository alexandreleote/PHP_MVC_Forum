<?php
    $categories = $result["data"]['categories'];
?>

<section class="information-container">
    <div class="information">
        <h2><a href="index.php?ctrl=home&action=index">Accueil</a> / Catégories</h2>
    </div>
</section>

<?php foreach ($categories as $category) { ?>
    <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
        <article class="main-container">
            <section class="contents-container">
                <div class="contents-main">
                    <div class="category-list">
                        <div class="category-item">
                            <?= $category->getName() ?>
                        </div>
                    </div>
                </div>
            </section>
        </article>
    </a>
<?php } ?>