<header>
	<div class="row">
        <div class="small-12 large-12 columns">
            <h3>Prijava - najemodajalec</h3>
        </div>
	</div>
</header>
<?php if ($error): ?>
<div class="row">
	<div class="small-12 large-12 columns">
		<div class="alert-box alert radius">
			<p>Prišlo je do napake pri prijavi.</p>
			<p style="margin-bottom: 0;">Prosimo vas, da obrazec ponovno izpolnite.</p>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="row">
	<form method="post" class="custom">
		<div class="small-12 large-12 columns">
				<label>Uporabniško ime:</label>
				<input type="text" name="uname" placeholder="Up. ime">
				<label>Geslo:</label>
				<input type="password" name="password" placeholder="Geslo">
				<input type="submit" name="login" value="Vstopi" class="small success button">
			Še nisi registriran? <a href="./?najemodajalec=registracija">Ustvari nov račun</a>.
		</div>
	</form>
</div>