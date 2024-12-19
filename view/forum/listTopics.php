<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
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
            <button class="btn" id="btn-new-topic">Nouveau sujet</button>
        </header>

        <div class="">
            <ul class="">
                <?php
                if(empty($topics)) { ?>
                    <p>Soyez le premier à écrire dans cette catégorie</p>
                <?php } else {
                    foreach($topics as $topic ){ ?>
                        <li>
                            <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId()?>"><?= $topic ?></a>
                            <span>par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?></span>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>

        <div class="">
            <form action="index.php?ctrl=forum&action=createTopic&id=<?= $category->getId()?>" method="post">
            <div class="">
                <fieldset class="">
                    <label for="title">Créer : </label>
                    <input type="text" name="title" id="title" required placeholder="Titre du sujet">
                    <button class="close-btn"><i class="fa-solid fa-close"></i></button>
                </fieldset>
            </div>
            <div class="">
                <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu du sujet" required></textarea>
                <fieldset class="">
                        <input type="submit" value="Publier" class="">
                        <i class="fa-solid fa-paper-plane"></i>
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