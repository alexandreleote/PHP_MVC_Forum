<?php
    $categories = $result["data"]['categories'] ?? [];
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
    <section class="contents-container">
        <h2>Les sujets actifs</h2>
        <div class="contents-list">
            <?php 
            $activeCategoriesFound = false;
            if(!empty($categories)) { 
                foreach ($categories as $category) { 
                    $topics = $category->getTopics();
                    $topicCount = count($topics);
                    
                    // N'afficher que les catégories avec des sujets
                    if ($topicCount > 0) {
                        $activeCategoriesFound = true;
                        ?>
                        <article class="content-item">
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                            <p>(<?= $topicCount ?>)</p>
                        </article>
                    <?php } 
                } 
                
                // Si aucune catégorie active n'a été trouvée
                if (!$activeCategoriesFound) { ?>
                    <p>Aucune catégorie avec des sujets n'est disponible</p>
                <?php }
            } else { ?>
                <p>Aucune catégorie disponible</p>
            <?php } ?>
        </div>
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