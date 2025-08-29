<article>
	<h1><?= htmlspecialchars($post->title) ?></h1>
	<p>Views: <?= $post->views ?></p>
	<p>
		<?= nl2br(htmlspecialchars($post->content)) ?>
	</p>
</article>

<section>
	<h2 id="comments">Comments</h2>

	<?php if($user && check('comment')): ?>
		<form action="/posts/<?= $post->id ?>/comment" method="POST">
			<?= csrf_token() ?>
			<textarea name="content" rows="3" required></textarea>
			<button type="submit">Add comment</button>
		</form>
	<?php else: ?>
		<a href="/login">Login to comment.</a>
	<?php endif ?>

	<?php foreach($comments as $comment): ?>
		<div>
			<p>
				<?= nl2br(htmlspecialchars($comment->content)) ?>
			</p>
			<small>Posted on: <?= $comment->created_at ?></small>
		</div>
	<?php endforeach; ?>
</section>