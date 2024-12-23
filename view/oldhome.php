<?php
    $categories = $result["data"]['categories']; 
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
            <?php if($categories) { ?>
                <?php foreach ($categories as $category) { 
                    $topics = $category->getTopics();
                    ?>
                    <article class="content-item">
                        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a>
                        <p class="content-item__topic"><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topics->getId() ?>"><?= $topics[0]->getTitle() ?></a></p>
                        <p class="content-item__post"><a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topics->getId() ?>"><?= $posts[0]->getContent() ?></a></p>
                        <p class="content-item__author"><a href="index.php?ctrl=forum&action=profile&id=<?= $users[0]->getId() ?>"><?= $users[0]->getPseudo() ?></a></p>
                    </article>
                <?php } ?>
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