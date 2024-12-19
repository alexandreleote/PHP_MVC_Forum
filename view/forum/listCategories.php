<?php
    $categories = $result["data"]['categories'];
    var_dump($categories); 
?>

<section class="">
    <div class="">
        <h2><a href="index.php?ctrl=home&action=index">Accueil</a></h2>
    </div>
</section>

<article class="main-container">
    <section class="contents-container">
        <header>
            <div>
                <h3>Toutes les catégories</h3> 
            </div>
        </header>

        <div class="">
            <?php
                foreach($categories as $category ){ ?>
                    <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
            <?php } ?>    
        </div>

        <!-- <div class="">
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
        </div> -->
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




  
