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
                            <div class="item-category">
                                <i class="fa-solid fa-chevron-right"></i>
                                <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                                <span>(<?= $topicCount ?>)</span>
                            </div>
                            <button class="btn" id="btn-see-all">Tout voir <i class="fa-solid fa-chevron-right"></i></button>
                        </article>
                        <?php if($topics) { ?>
                            <article class="home-topics-list">
                                <?php 
                                    $maxTopics = 3; 
                                    $topicCount = 0;
                                    foreach($topics as $topic) { 
                                        if($topicCount >= $maxTopics) break;?>
                                    <div class="home-topic-item">
                                        <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId() ?>">
                                            <?= strlen($topic->getTitle()) > 20 ? substr($topic->getTitle(), 0, 35).'...' : $topic->getTitle() ?>
                                        </a>
                                        <div class="topic-item-details">
                                                <p>par <span><?= $topic->getUser() ?></span></p>
                                                <div class="topic-item-specs">
                                                    <p>le <span><?= $topic->getCreationDate() ?></span></p>
                                                    <p>(0)</p>
                                                </div>
                                        </div>
                                    </div>
                                <?php $topicCount++; } ?>
                            </article>
                        <?php } ?>
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