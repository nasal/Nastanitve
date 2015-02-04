<header>
	<div class="row">
        <div class="small-12 large-12 columns">
            <h3>Iskanje nastanitve</h3>
        </div>
	</div>
	</header>
<div class="row">
	<form method="post" class="custom">
		<div class="small-12 large-12 columns">
			<label>Kraj</label>
			<select name="mesto">
				<option selected disabled>Izberi</option>
				<?php
				$q = pg_query('select mesto from projekt.nastanitev group by mesto order by mesto asc');
				while ($f = pg_fetch_assoc($q)) {
					echo '<option value="' . $f['mesto'] . '">' . $f['mesto'] . '</option>' . "\n";
				}
				pg_free_result($q);
				?>
			</select>

			<label for="drustvo">Datum od</label>
			<div class="row">
				<div class="large-2 columns">
					<select name="dan-od"><?php for ($i = 1; $i <= 31; $i++) { echo '<option value="' . $i . '">' . $i . '</option>'; } ?></select>
				</div>
				<div class="large-3 columns">
					<select name="mesec-od"><?php for ($i = 1; $i <= 12; $i++) { echo '<option value="' . $i . '">' . date('F', mktime(0, 0, 0, $i, 1, 2013)) . '</option>'; } ?></select>
				</div>
				<div class="large-2 columns">
					<select name="leto-od"><?php for ($i = 2013; $i <= 2016; $i++) { echo '<option value="' . $i . '">' . $i . '</option>'; } ?></select>
				</div>
				<div class="large-5 columns">&nbsp;</div>
			</div>
			<label for="drustvo">Datum do</label>
			<div class="row">
				<div class="large-2 columns">
					<select name="dan-do"><?php for ($i = 1; $i <= 31; $i++) { echo '<option value="' . $i . '">' . $i . '</option>'; } ?></select>
				</div>
				<div class="large-3 columns">
					<select name="mesec-do"><?php for ($i = 1; $i <= 12; $i++) { echo '<option value="' . $i . '">' . date('F', mktime(0, 0, 0, $i, 1, 2013)) . '</option>'; } ?></select>
				</div>
				<div class="large-2 columns">
					<select name="leto-do"><?php for ($i = 2013; $i <= 2016; $i++) { echo '<option value="' . $i . '">' . $i . '</option>'; } ?></select>
				</div>
				<div class="large-5 columns">&nbsp;</div>
			</div>

			<label>Velikost</label>
			<select name="velikost">
				<option selected disabled>Izberi</option>
				<option value="<30">&lt; 30m2</option>
				<option value="=30">30m2</option>
				<option value="between 30 and 50">30 - 50 m2</option>
				<option value=">50">&gt; 50 m2</option>
			</select>

			<label>Cena</label>
			<select name="cena">
				<option selected disabled>Izberi</option>
				<option value="<30">&lt; 30 &euro;/noč</option>
				<option value="=30">30 &euro;/noč</option>
				<option value="between 30 and 50">30 - 50 &euro;/noč</option>
				<option value=">50">&gt; 50 &euro;/noč</option>
			</select>

			<label>Tip nastanitve</label>
			<select name="tip">
				<option selected disabled>Izberi</option>
				<?php
				$q = pg_query('select tip from projekt.nastanitev group by tip order by tip asc');
				while ($f = pg_fetch_assoc($q)) {
					echo '<option value="' . $f['tip'] . '">' . $f['tip'] . '</option>' . "\n";
				}
				pg_free_result($q);
				?>
			</select>

			<input type="submit" class="small success button" style="margin-right: 10px;" name="search" value="Poišči ustrezne nastanitve" /> 
			<input type="button" class="small secondary button" value="Začni znova" onclick="this.form.reset()" />

			<?php
			if (isset($_POST['search'])) {
				echo '<h3>Rezultati iskanja</h3>';
				$iskanje = '';
				if ($_POST['velikost'] != '') $iskanje .= ' and velikost ' . $_POST['velikost'];
				if ($_POST['cena'] != '') $iskanje .= ' and cena ' . $_POST['cena'];
				if ($_POST['tip'] != '') $iskanje .= ' and tip = \'' . $_POST['tip'] . '\'';
				$q = pg_query("select * from projekt.nastanitev where mesto = '" . $_POST['mesto'] . "' " . $iskanje . " and datum_od <= '" . date('Y-m-d', strtotime($_POST['leto-od'] . '-' . $_POST['mesec-od'] . '-' . $_POST['dan-od'])) . "'::DATE and datum_do >= '" . date('Y-m-d', strtotime($_POST['leto-do'] . '-' . $_POST['mesec-do'] . '-' . $_POST['dan-do'])) . "'::DATE order by a_id desc");
				if (pg_num_rows($q)) {
					while ($f = pg_fetch_assoc($q)) {
						echo '<div style="overflow: auto; padding: 10px 0; line-height: 1.4em; border-bottom: solid 1px #ddd;">' .
							 '<span style="width: 100px; display: inline-block;"><strong>Tip:</strong></span>' . $f['tip'] . '<br>' .
							 '<span style="width: 100px; display: inline-block;"><strong>Naslov:</strong></span>' . $f['naslov'] . '<br>' . 
							 '<span style="width: 100px; display: inline-block;"><strong>Mesto:</strong></span>' . $f['mesto'] . '<br>' .
							 '<span style="width: 100px; display: inline-block;"><strong>Velikost:</strong></span>' . $f['velikost'] . 'm<sup>2</sup><br>' . 
							 '<span style="width: 100px; display: inline-block;"><strong>Cena:</strong></span>' . $f['cena'] . '&euro;<br>' .
							 '<span style="width: 100px; display: inline-block;"><strong>Opis:</strong></span>' . nl2br($f['opis']) . 
							 '</div>';
					} 
				} else {
					echo '<div class="alert-box info radius">
						<p><strong>Ni zadetkov</strong>.</p>
						<p style="margin-bottom: 0;">Poskusite znova z drugimi iskalnimi parametri.</p>
					</div>';
				}
				pg_free_result($q);
			}
			?>
		</div>
	</form>
</div>