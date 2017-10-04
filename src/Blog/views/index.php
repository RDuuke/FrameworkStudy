<?= $renderer->render('header'); ?>

<h1>Welcome the Blog!</h1>

<p><a href="<?= $router->generateUri('blog.show', ['slug' => 'article-of']) ?>">Article</a></p>
<?= $renderer->render('footer'); ?>
