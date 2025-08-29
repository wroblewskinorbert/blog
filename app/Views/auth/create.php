<h2>Login</h2>

<?php if (isset($error)): ?>
<div style="color:red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form action="/login" method="POST">
<!-- CSRF -->
<?= csrf_token() ?>
<div>
	<label for="email">Email</label>
	<input type="email" name="email" id="email" placeholder="Email" required />
	<label for="password">Password</label>
	<input type="password" name="password" id="password" placeholder="Password" required />
	<div>
		<button type="submit">Login</button>
	</div>
	<!-- Remember me feature -->
	 	<label for="remember">
			Remember me 			
		</label>
		<input type="checkbox" name="remember" id="remember" />
</div>
</form>
