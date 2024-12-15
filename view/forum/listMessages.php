<?php
    $category = $result["data"]['category'];
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<section class="information-container">
    <div class="information">
        <h2> <?= $category ?> / <?= $topic ?></h2>
    </div>
</section>

<article class="content-container">
    <section class="topics-container topics-card">
        <header>
            <h3>Fil d'actualité</h3>
            <button class="btn" id="btn-create-topic">Nouveau sujet</button>
        </header>

        <div class="topics">
            <ul class="topics-list">
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
<?php
foreach($posts as $post ){ ?>
    <p><?= $post->getContent() ?> par <?= $post->getUser() ?> le <?= $post->getCreationDate() ?></p>
<?php }