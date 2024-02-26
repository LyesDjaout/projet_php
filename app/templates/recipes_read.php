<?php $title = "Site de Recettes - Page de contact"; ?>
<?php ob_start(); ?>
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
    <div>
        <article>
            <?php echo htmlspecialchars($recipe['recipe']); ?>
        </article>
        <aside>
            <p><i>Contribuée par <?php echo htmlspecialchars($recipe['author']); ?></i></p>
            <?php if ($recipe['rating'] !== null) : ?>
                <p><b>Evaluée par la communauté à <?php echo htmlspecialchars($recipe['rating']); ?> / 5</b></p>
            <?php else : ?>
                <p><b>Aucune évaluation</b></p>
            <?php endif; ?>
        </aside>
    </div>
    <hr />
    <h2>Commentaires</h2>
    <?php if ($recipe['comments'] !== []) : ?>
    <div>
        <?php foreach ($recipe['comments'] as $comment) : ?>
            <div class="comment">
                <p><?php echo htmlspecialchars($comment['created_at']); ?></p>
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                <i>(<?php echo htmlspecialchars($comment['full_name']); ?>)</i>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
    <div>
        <p>Aucun commentaire</p>
    </div>
    <?php endif; ?>
    <hr />
    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
        <?php require_once(__DIR__ . '/comments_create.php'); ?>
    <?php endif; ?>
<?php $content = ob_get_clean(); ?>
<?php require('layout.php') ?>
