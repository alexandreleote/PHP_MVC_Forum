<?php
    $user = $result['data']['user'];

?>

<section class="information-container">
    <div class="information">
        <h2><a href="index.php?ctrl=home&action=index">Accueil</a> / Profil : <?= $user ?></h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header class="contents-header">
            <h3>Mes informations :</h3>
            <button class="btn" id="btn-new-modify">Modifier</button>
        </header>

        <div class="">
            <ul class="">
            
            </ul>
        </div>

        <div class="">
            <form action="index.php?ctrl=security&action=modify&id=<?= $user->getId() ?>" method="post">
                <div class="">
                    <fieldset class="">
                        <label for="title">Modification</label>
                        <button type="button" class="close-btn"><i class="fa-solid fa-close"></i></button>
                    </fieldset>
                </div>
            </form>

            <form action="index.php?ctrl=security&action=deleteUserProfile&id=<?= $user->getId() ?>" method="post">
                <button type="submit" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </form>

            <div class="">
                <fieldset class="">
                    <input type="submit" value="Publier" class="">
                    <i class="fa-solid fa-paper-plane"></i>
                </fieldset>
            </div>
        </div>
    </section>

    <aside class="aside-container">
        <h3>Les stacks </h3>
        <ul class="">
            <li>Ici les stacks</li>
            <li>Qui sont les stacks</li>
        </ul>
    </aside>
</article>