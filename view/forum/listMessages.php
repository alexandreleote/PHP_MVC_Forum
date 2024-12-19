<?php
    $category = $result["data"]['category'];
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<section class="">
    <div class="">
        <h2><a href="index.php?ctrl=forum&action=listCategories"><?= $category ?></a> / <?= $topic ?></h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header>
            <div>
                <h3><?= $topic ?></h3> 
                    <?php if(App\Session::isAdmin()) { ?>
                        <form action="index.php?ctrl=forum&action=<?= $topic->getLocked() ? 'unlockTopic' : 'lockTopic' ?>&id=<?= $topic->getId() ?>" method="post" class="">
                            <button type="submit" class="">
                                <?= $topic->getLocked() ? '<i class="fas fa-lock"></i>' : '<i class="fas fa-lock-open"></i>' ?>
                            </button>
                        </form>
                    <?php } else if (App\Session::isAdmin()){ ?>
                        <?= $topic->getLocked() ? '<i class="fas fa-lock text-danger"></i>' : '<i class="fas fa-lock-open text-success"></i>' ?>
                    <?php } ?>
            </div>
                <?php 
                    if(!$topic->getIsLocked() && App\Session::isConnected()) { ?>
                        <button class="" id="">Nouveau message</button>
                    <?php } 
                ?>
        </header>

        <div class="">
            <?php
                foreach($posts as $post ){ 

                    $class = App\Session::isAuthor($post->getUser()->getId()) ? "author" : "contributor";
                    ?>
                    <p class=" <?= $class ?> "><?= $post->getContent() ?> par <?= $post->getUser() ?> le <?= $post->getCreationDate() ?></p>
            <?php 
                // Vérifier si l'utilisateur peut supprimer le message
                if(App\Session::isAdmin() || App\Session::isAuthor($post->getUser()->getId())) {?>
                    <form action="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>" method="post">
                        <button type="submit">Supprimer</button>
                    </form>
                <?php } 
            } ?>
        </div>

        <div class="">
            <form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId() ?>" method="post">
                <div class="">
                    <fieldset class="">
                        <label for="content">Répondre</label>
                    </fieldset>
                </div>    
                <div class="">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Votre message" required></textarea>
                    <fieldset class="">
                        <input type="submit" value="Publier" class="">
                        <i class="fa-solid fa-paper-plane"></i>
                    </fieldset>
                </div>
            </form>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Dans la discussion</h3>
        <ul class="">
            <li><a href="#" class="member-item">Nom du membre 1</a></li>
            <li><a href="#" class="member-item">Nom du membre 2</a></li>
            <li><a href="#" class="member-item">Nom du membre 3</a></li>
        </ul>
    </aside>
</article>
