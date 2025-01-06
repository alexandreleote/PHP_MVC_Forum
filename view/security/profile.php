<?php
    $user = $result['data']['user'] ?? null;
    $categories = $result['data']['categories'] ?? [];
    
    if (!$user) {
        // Rediriger si aucun utilisateur n'est trouvé
        header("Location: index.php?ctrl=home&action=index");
        exit();
    }
?>

<section class="information-container">
    <div class="information">
        <h2>
            <a href="index.php?ctrl=home&action=index">Accueil</a> / 
            Profil : <?= $user->getNickName() ?>
        </h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header class="contents-header">
            <h3>Informations de l'utilisateur :</h3>
            <?php if ($result['data']['isCurrentUser']) { ?>
                <button class="btn" id="btn-new-content">Modifier</button>
            <?php } ?>
        </header>

        <div class="contents-main">
            <!-- Informations de l'utilisateur -->
            <div class="profile-main-info">
                <div class="user-role">
                    <i class="fa-solid fa-chevron-right"></i>
                    <?php if($user->isAdmin()) { ?>
                        <span>Admin</span>
                    <?php } else if ($user->isMod()) { ?>
                        <span>Modérateur</span>
                    <?php } else { ?>
                        <span>Membre</span>
                    <?php } ?>
                </div>
                <div class="subscription-date">
                    <p>Inscrit depuis le</p>
                    <span><?= $user->getSubscriptionDate() ?></span>
                </div>
                <p>Sujets créés (<?= $user->countCreatedTopics() ?>)</p>
                <p>Messages envoyés (<?= $user->countCreatedPosts() ?>)</p>
            </div>
        </div>

        <div class="contents-created-topics">
            <h4>Derniers sujets créés</h4>
            <div class="contents-topics-list">
                <?php 
                $createdTopics = $user->getCreatedTopics();
                if (!empty($createdTopics)) { ?>
                    <ul>
                        <?php foreach ($createdTopics as $createdTopic) { ?>
                            <li class="post-topic-item">
                                <div class="post-topic-wrapper">
                                    <div class="post-topic-category">
                                        <i class="fa-solid fa-chevron-right"></i>
                                        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $createdTopic->getCategory()->getId() ?>">
                                            <?= $createdTopic->getCategory()->getName() ?>
                                        </a>
                                    </div>
                                    <div class="post-topic-title">
                                        <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $createdTopic->getId() ?>">
                                            <?= $createdTopic->getTitle() ?>
                                        </a>
                                    </div>
                                    <div class="post-topic-date">
                                        <p><?= $createdTopic->getCreationDate() ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Aucun sujet créé</p>
                <?php } ?>
            </div>
        </div>

        <div class="contents-created-posts">
            <h4>Derniers messages envoyés</h4>
            <div class="contents-posts-list">
                <?php 
                $createdPosts = $user->getCreatedPosts();
                if (!empty($createdPosts)) { ?>
                    <ul>
                        <?php foreach ($createdPosts as $createdPost) { ?>
                            <li class="post-post-item">
                                <div class="post-post-wrapper">
                                    <div class="post-post-category">
                                        <i class="fa-solid fa-chevron-right"></i>
                                        <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $createdTopic->getCategory()->getId() ?>">
                                            <?= $createdTopic->getCategory()->getName() ?>
                                        </a>
                                    </div>
                                    <div class="post-post-title">
                                        <a href="index.php?ctrl=forum&action=discussionByTopic&id=<?= $createdTopic->getId() ?>">
                                            <?= $createdTopic->getTitle() ?>
                                        </a>
                                    </div>
                                    <div class="post-post-date">
                                        <p><?= $createdPost->getCreationDate() ?></p>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Aucun message envoyé</p>
                <?php } ?>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="contents-form">
            <form action="index.php?ctrl=security&action=modify&id=<?= $user->getId() ?>" method="post">
                <div class="contents-form-header">
                    <div class="form-title">
                        <p>Modification</p>
                        <button class="close-btn"><i class="fa-solid fa-close"></i></button>
                    </div>
                </div>

                <div class="contents-form-main modification-form">
                    <div class="form-content">
                        <label for="username">Pseudonyme</label>
                        <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" value="<?= $user->getNickName() ?>">
                    </div>
                    <div class="form-content">
                        <div>
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" value="<?= $user->getEmail() ?>">
                        </div> 
                        <div>
                            <label for="emailConfirm">Confirmer l'email</label>
                            <input type="email" name="emailConfirm" id="emailConfirm" placeholder="Confirmer l'email">
                        </div>
                    </div>
                    <div class="form-content">
                        <div>
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" placeholder="Mot de passe">
                        </div>
                        <div>
                            <label for="passwordConfirm">Confirmer le mot de passe</label>
                            <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmer mot de passe">
                        </div>
                    </div>
                </div>
                <span class="contents-form-info">
                    * Le pseudonyme ne doit pas comporter d’insultes ou d’injures sous peine de banissement temporaire
                    ou permanent si cas extrêmement grave (se renseigner sur les <a href="#">conditions d’utilisation</a>)
                </span>
    
                <div class="contents-form-footer">
                    <button type="submit" class="btn btn-publish-content">Modifier <i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </form>
            <form action="index.php?ctrl=security&action=deleteAccount&id=<?= $user->getId() ?>" method="post">
                <button type="submit" class="btn delete-btn" id="delete-user-btn">Supprimer le compte <i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Les Stacks</h3>
        <div class="main-aside-list">
            <div class="aside-list">
                <?php 
                foreach ($categories as $category) { ?>
                    <div class="aside-item">
                        <div class="aside-item-name">
                            <i class="fa-solid fa-chevron-right"></i>
                            <a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>">
                                <?= $category->getName() ?>
                            </a>
                        </div>
                        <span>(<?= count($category->getTopics()) ?>)</span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </aside>
</article>