<?php
    $category = $result["data"]['category'];
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<section class="information-container">
    <div class="information">
        <h2><a href="index.php?ctrl=forum&action=listCategories"><?= $category ?></a> / <?= $topic ?></h2>
    </div>
</section>

<article class="content-container">
    <section class="contents-container contents-card">
        <header>
            <h3><?= $topic ?></h3>
            <button class="btn" id="btn-create-content">Nouveau message</button>
        </header>

        <div class="contents">
            <?php
                foreach($posts as $post ){ ?>
                    <p><?= $post->getContent() ?> par <?= $post->getUser() ?> le <?= $post->getCreationDate() ?></p>
            <?php 
                // Vérifier si l'utilisateur peut supprimer le message
                if(App\Session::isAdmin() || App\Session::isAuthor($post->getUser()->getId())) {?>
                    <form action="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>" method="post">
                        <button type="submit">Supprimer</button>
                    </form>
                <?php } 
            } ?>
        </div>

        <div class="form-container">
            <form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId() ?>" method="post">
                <label for="content">Répondre : </label>
                <div class="form-content">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Contenu du sujet" required></textarea>
                    <input type="submit" value="Publier">
                </div>
            </form>
        </div>
    </section>

    <aside class="aside-container members-card">
        <h3>Dans la discussion</h3>
        <ul class="members-list">
            <li><a href="#" class="member-item">Nom du membre 1</a></li>
            <li><a href="#" class="member-item">Nom du membre 2</a></li>
            <li><a href="#" class="member-item">Nom du membre 3</a></li>
        </ul>
    </aside>
</article>
