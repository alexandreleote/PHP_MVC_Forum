<?php
    $topic = $result["data"]['topic']; 
    $posts = $result["data"]['posts']; 
?>

<h1>Messages du topic : <?= $topic ?></h1>

<?php
foreach($posts as $post ){ ?>
    <p><?= $post->getContent() ?> par <?= $post->getUser() ?> le <?= $post->getCreationDate() ?></p>
<?php }