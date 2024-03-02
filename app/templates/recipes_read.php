<?php $title = "Page de recette"; ?>
<?php ob_start(); ?>

<section class="flex-container read-recipe-section-container">
    <h1 class="read-recipe-section-flex-item first-title"><?= htmlspecialchars($recipe['title']); ?></h1>
    <article class="read-recipe-section-flex-item first-article"> 
        <p class="read-recipe-section-flex-item first-article recipe"><?= htmlspecialchars($recipe['recipe']); ?></p>
        <p class="read-recipe-section-flex-item first-article autor">Auteur : <?= htmlspecialchars($recipe['author']); ?></p>
        <?php if ($recipe['rating'] !== null) : ?>
            <p class="read-recipe-section-flex-item first-article review">Evaluée par la communauté à <?= htmlspecialchars($recipe['rating']); ?> / 5</p>
        <?php else : ?>
            <p class="read-recipe-section-flex-item first-article no-review">Aucune évaluation</p>
        <?php endif; ?>
    </article>

    <hr id="line">

    <h3 class="read-recipe-section-flex-item second-title">Commentaires</h3>
    <?php if ($recipe['comments'] !== []) : ?>
        <?php foreach ($recipe['comments'] as $comment) : ?>
            <article class="read-recipe-section-flex-item second-article">
                <p class="read-recipe-section-flex-item second-article comment"><?= htmlspecialchars($comment['comment']); ?></p>
                <p class="read-recipe-section-flex-item second-article full-name">Par <?= htmlspecialchars($comment['full_name']); ?></p>
                <time class="read-recipe-section-flex-item second-article time" datetime="<?= htmlspecialchars($comment['created_at']); ?>">Publié le <?= htmlspecialchars($comment['created_at']); ?></time>
            </article>
        <?php endforeach; ?>

    <?php else : ?>

        <p class="read-recipe-section-flex-item no-comment">Aucun commentaire</p>

    <?php endif; ?>

    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <?php require_once(__DIR__ . '/comments_create.php'); ?>
    <?php endif; ?>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>