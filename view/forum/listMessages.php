<?php
    $category = $result["data"]['category'];
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<section class="information-container">
    <div class="information">
        <h2><a href="index.php?ctrl=forum&action=index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $topic->getCategory()->getId() ?>"><?= $topic->getCategory() ?></a> / <?= $topic ?> <?= $topic->getLocked() ? '<i class="fas fa-lock"></i>' : '' ?></h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header class="contents-header">
            <div class="contents-header-title">
                <h3><?= $topic ?></h3> 
                <?php if(App\Session::isAdmin()) { ?>
                    <form action="index.php?ctrl=forum&action=<?= $topic->getLocked() ? 'unlockTopic' : 'lockTopic' ?>&id=<?= $topic->getId() ?>" method="post" class="">
                        <button type="submit" class="btn edit-btn">
                            <?= $topic->getLocked() ? '<i class="fas fa-lock"></i>' : '<i class="fas fa-lock-open"></i>' ?>
                        </button>
                    </form>
                <?php } ?>
            </div>
                <?php 
                    if(!$topic->getIsLocked() && App\Session::isConnected()) { ?>
                        <button class="btn" id="btn-new-content">Commenter</button>
                    <?php } 
                ?>
        </header>

        <div class="contents-main">
            <?php
                foreach($posts as $post ){ 

                    $class = App\Session::isAuthor($post->getUser()->getId()) ? "author" : "contributor";
                    ?>
                    <div class="discussion-item <?= $class ?>">
                        <p><?= $post->getContent() ?></p>
                        <span><?= $post->getUser() ?>, le <?= $post->getCreationDate() ?></span>
                        <?php 
                            // Vérifier si l'utilisateur peut supprimer le message
                            if(App\Session::isAdmin() || App\Session::isAuthor($post->getUser()->getId())) {?>
                                <form action="index.php?ctrl=forum&action=deletePost&id=<?= $post->getId() ?>" method="post">
                                    <button type="submit" class="btn delete-btn message-delete">Supprimer   <i class="fa-solid fa-trash"></i></button>
                                </form>
                            <?php } ?>
                    </div>
        <?php } ?>
        </div>

        <div class="contents-form">
            <form action="index.php?ctrl=forum&action=createPost&id=<?= $topic->getId() ?>" method="post">
                <div class="contents-form-header">
                    <fieldset class="form-title">
                        <label for="content">Répondre</label>
                        <button class="close-btn"><i class="fa-solid fa-close"></i></button>
                    </fieldset>
                </div>    
                <div class="contents-form-main">
                    <textarea name="content" id="content" cols="30" rows="10" placeholder="Votre message" required></textarea>
                    <fieldset class="contents-form-footer">
                        <button type="submit" class="btn btn-publish-content" >Publier <i class="fa-solid fa-paper-plane"></i></button>
                    </fieldset>
                </div>
            </form>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Dans la discussion</h3>
        <?php 
        $users = $result["data"]['users'] ?? [];
        if (!empty($users)) { 
            foreach ($users as $user) { ?>
                <div class="member-item">
                    <a href="index.php?ctrl=security&action=profile&id=<?= $user->getId() ?>"><?= $user->getNickName() ?></a>
                </div>
        <?php } 
        } else { ?>
            <p>Aucun utilisateur n'a encore participé à cette discussion</p>
        <?php } ?>
    </aside>
</article>
