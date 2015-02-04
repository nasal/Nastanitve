<header>
	<div class="row">
        <div class="small-12 large-12 columns">
            <h3>Dodajanje nastanitve</h3>
        </div>
	</div>
</header>
<div class="row">
	<form method="post" class="custom">
		<div class="small-12 large-12 columns">
				<label>Najemodajalec:</label><select name="n_id"><option value="-">Izberi</option><? $q = pg_query('select n_id, ime, priimek from projekt.najemodajalec order by ime asc'); while ($pg = pg_fetch_assoc($q)) { echo '<option value="' . $pg['n_id'] . '">' . $pg['ime'] . ' ' . $pg['priimek'] . '</option>'; } ?></select>
				<label>Naslov:</label><input type="text" name="naslov" placeholder="Naslov">
				<label>Mesto:</label><input type="text" name="mesto" placeholder="Mesto">
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
				<label>Cena:</label><input type="text" name="cena" placeholder="EUR na dan">
				<label>Tip:</label><input type="text" name="tip" placeholder="Apartma / stanovanje / bungalov">
				<label>Velikost:</label><input type="text" name="velikost" placeholder="m2">
				<label>Opis:</label><textarea name="opis" style="height: 100px;" placeholder="Opis nastanitve"></textarea>
				<input type="submit" name="dodaj_nastanitev" value="Vpiši nastanitev" class="small success button">
		</div>
	</form>
</div>