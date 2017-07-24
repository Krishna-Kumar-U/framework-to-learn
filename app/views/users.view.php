<?php require('partials/head.php'); ?>

    <h1>All Users</h1>

<?php foreach ($users as $user) : ?>
    <li><?= $user->firstname.' '.$user->lastname; ?></li>
<?php endforeach; ?>

<h1>Submit Your Name</h1>

<form action="/users" method="POST" action="/users">
	<ul>
		<li>
			<input name="firstname" placeholder="First Name"></input>
		</li>
		<li>
			<input name="lastname" placeholder="Last Name"></input>
		</li>
		<li>
			<input type="email" required="required" placeholder="Email ID" name="email"></input>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password" required="required"></input>
		</li>
		<li>
			<button type="submit">Submit</button>
		</li>
	</ul>
</form>

<?php require('partials/footer.php'); ?>
