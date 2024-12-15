<?php
    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
?>

<section class="information-container">
    <div class="information">
        <h2>Catégories / <?= $category ?></h2>
    </div>
</section>

<article class="content-container">
    <section class="contents-container contents-card">
        <header>
            <h3>Fil d'actualité</h3>
            <button class="btn" id="btn-create-content">Nouveau sujet</button>
        </header>

        <div class="contents">
            <ul class="contents-list">
                <?php
                foreach($topics as $topic ){ ?>
                    <li>
                        <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $topic->getId()?>"><?= $topic ?></a> par <?= $topic->getUser() ?> le <?= $topic->getCreationDate() ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="form-container">
            <form action="index.php?ctrl=forum&action=createTopic" method="post">
                <input type="hidden" name="category_id" value="<?= $category->getId()?>">
                <div class="form-header">
                    <label for="title">Créer : </label>
                    <input type="text" name="title" id="title" required placeholder="Titre du sujet">
                </div>
                <div class="form-content">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu du sujet" required></textarea>
                    <input type="submit" value="Publier">
                </div>
            </form>
        </div>
    </section>

    <aside class="aside-container members-card">
        <h3>Les membres du mois</h3>
        <ul class="members-list">
            <li><a href="#" class="member-item">Nom du membre 1</a></li>
            <li><a href="#" class="member-item">Nom du membre 2</a></li>
            <li><a href="#" class="member-item">Nom du membre 3</a></li>
        </ul>
    </aside>
</article>