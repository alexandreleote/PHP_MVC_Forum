<?php
    $categories = $result["data"]['categories']; 
    $topics = $result["data"]['topics'] ?? []; 
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

<section class="main-container">
    <section class="contents-container active-categories-container">
        <h2>Les sujets actifs</h2>
        <?php foreach ($categories as $category) { ?>
            <div class="category-container">
                <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId()?>"><?= $category->getName() ?></a></p>
                <?php 
                if (!empty($topics)) {
                    foreach ($topics as $topic) { ?>
                        <p>
                            <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId()?>">
                                <?= $topic->getTitle() ?>
                            </a> 
                            par <?= $topic->getUser() ?> 
                            le <?= $topic->getCreationDate() ?>
                        </p>
                    <?php } 
                } else { ?>
                    <p>Aucun sujet récent</p>
                <?php } ?>
            </div>
        <?php } ?>
    </section>


    <aside class="aside-container">
            <h3>Dans la discussion</h3>
            <ul class="members-list">
                <li><a href="#" class="member-item">Nom du membre 1</a></li>
                <li><a href="#" class="member-item">Nom du membre 2</a></li>
                <li><a href="#" class="member-item">Nom du membre 3</a></li>
            </ul>
    </aside>
</section>