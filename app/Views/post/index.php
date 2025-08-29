
<h2>All Posts</h2>

<form action="" method="GET">
	<input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search post..." />
	<button>Search</button>
</form>

<?= partial("_posts", ['posts' => $posts]) ?>
<?= partial("_pagination", ['currentPage'=>$currentPage, 'totalPages'=>$totalPages]) ?>
