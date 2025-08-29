<h2>Update Post</h2>

<form action="/admin/posts/<?= $post->id ?>" method="POST">
	<?= csrf_token() ?>
	<div>
		<label for="title">Title</label>
		<input type="text" name="title" id="title" value="<?= htmlspecialchars($post->title) ?>" required>
	</div>

	<div>
		<label for="content">Content</label>
		<textarea name="content" id="content" required><?= htmlspecialchars($post->content) ?></textarea>
	</div>

	<button type="submit">Update Post</button>
</form>