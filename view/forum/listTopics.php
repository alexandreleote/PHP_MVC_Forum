<?php
    $category = $result["data"]['category'] ?? []; 
    $topics = $result["data"]['topics'] ?? []; 
?>

<section class="information-container">
    <div class="information">
        <h2><a href="index.php?ctrl=home&action=index">Accueil</a> / <?= $category ?></h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header class="contents-header">
            <h3>Tous les sujets : <?= $category ?></h3>
            <?php if(App\Session::isConnected()) { ?>
                <button class="btn" id="btn-new-content">Nouveau sujet</button>
            <?php } ?>    
        </header>

        <div class="contents-main">
            <div class="contents-discussion">
                <?php
                if(empty($topics)) { ?>
                    <p>Soyez le premier à écrire dans cette catégorie</p>
                <?php } else {
                    foreach($topics as $topic) { ?>
                        <div class="discussion-item">
                            <div class="discussion-item-title">
                                <div class="discussion-item-name">
                                    <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId()?>"><?= $topic ?></a>
                                    <span><?= $topic->getIsLocked() ? '<i class="fas fa-lock "></i>' : '' ?></span>
                                </div>
                                <div class="discussion-item-info">
                                    <span>par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <div class="contents-form">
            <form action="index.php?ctrl=forum&action=createTopic&id=<?= $category->getId()?>" method="post">
            <div class="contents-form-header">
                <fieldset class="form-title">
                    <label for="title">Créer : </label>
                    <input type="text" name="title" id="title" required placeholder="Titre du sujet" maxlength="255">
                    <button class="close-btn"><i class="fa-solid fa-close"></i></button>
                </fieldset>
            </div>
            <div class="contents-form-main">
                <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu du sujet" required></textarea>
                <fieldset class="contents-form-footer">
                    <button type="submit" class="btn btn-publish-content" >Publier <i class="fa-solid fa-paper-plane"></i></button>
                </fieldset>
            </div>
        </form>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Les membres du mois</h3>
        <ul class="">
            <li><a href="#" class="member-item">Nom du membre 1</a></li>
            <li><a href="#" class="member-item">Nom du membre 2</a></li>
            <li><a href="#" class="member-item">Nom du membre 3</a></li>
        </ul>
    </aside>
</article>