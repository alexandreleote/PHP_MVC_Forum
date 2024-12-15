<?php
    $categories = $result["data"]['categories']; 
    $topics = $result["data"]['topics']; 
?>

<section>
    <div class="search-container">
        <div class="search">
            <label for="search">Vous cherchez quelque chose ?</label>
            <input type="search" name="search" id="search" placeholder="Rechercher sur les forums...">
            <button class="search-btn"><i class="fas fa-search"></i> Rechercher</button>
        </div>
    </div>
</section>

<section>
    <div class="active-category-container">
        <h2>Les sujets actifs</h2>
        <?php foreach ($categories as $category) { ?>
            <div class="category-container">
                <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId()?>"><?= $category->getName() ?></a></p>
                <?php foreach ($topics as $topic) { ?>
                    <p><a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId()?>"><?= $topic ?></a> par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?></p>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>