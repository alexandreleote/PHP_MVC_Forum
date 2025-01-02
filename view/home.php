<?php
    $categoriesArray = [];
    if (isset($result["data"]['categories'])) {
        $categoriesArray = iterator_to_array($result["data"]['categories']) ?: [];
    }
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
            if(!empty($categoriesArray)) { 
                foreach ($categoriesArray as $category) { 
                    $topics = $category->getTopics();
                    $topicCount = count($topics);
                    
                    if ($topicCount > 0) {
                        $activeCategoriesFound = true;
                        ?>
                        <article class="content-item">
                            <div class="item-category">
                                <i class="fa-solid fa-chevron-right"></i>
                                <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                                <span>(<?= $topicCount ?>)</span>
                            </div>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>" class="btn" id="btn-see-all">Tout voir <i class="fa-solid fa-chevron-right"></i></a>
                        </article>
                        <?php if($topics) { ?>
                            <article class="home-topics-list">
                                <?php 
                                    $maxTopics = 3; 
                                    $topicCount = 0;
                                    foreach($topics as $topic) { 
                                        if($topicCount >= $maxTopics) break;?>
                                    <div class="home-topic-item">
                                        <div>
                                            <span><?= $topic->getIsLocked() ? '<i class="fas fa-lock "></i>' : '' ?></span>
                                            <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId() ?>">
                                                <?= strlen($topic->getTitle()) > 20 ? substr($topic->getTitle(), 0, 35).'...' : $topic->getTitle() ?>
                                            </a>
                                        </div>
                                        <div class="topic-item-details">
                                                <p><?= $topic->getUser() ?></p>
                                                <div class="topic-item-specs">
                                                    <p><?= $topic->getLastActivity() ?></p>
                                                    <p>(<?= $topic->getPostsCount() ?>)</p>
                                                </div>
                                        </div>
                                    </div>
                                <?php $topicCount++; } ?>
                            </article>
                        <?php } ?>
                    <?php } 
                }
                
                if (!$activeCategoriesFound) { ?>
                    <p>Aucune catégorie avec des sujets n'est disponible</p>
                <?php }
            } else { ?>
                <p>Aucune catégorie disponible</p>
            <?php } ?>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Les Stacks</h3>
        <div class="main-stacks-list">
            <ul>
                <?php foreach ($categoriesArray as $category) { ?>
                    <li><i class="fa-solid fa-chevron-right"></i><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </aside>
</section>