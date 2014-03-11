<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_COUNTRIES_SAVESINGLE . (isset($countryId) ? "/" . $countryId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend><?php echo lang(LANG_KEY_HEADER_COUNTRY_INFORMATION); ?></legend>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_COUNTRY . '_' .  DB_COUNTRY_NAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_NAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_COUNTRY . '_' . DB_COUNTRY_NAME ?>" id="<?php echo DB_TABLE_COUNTRY . '_' . DB_COUNTRY_NAME ?>" value="<?php echo set_value(DB_TABLE_COUNTRY . '_' . DB_COUNTRY_NAME, isset($country->{DB_COUNTRY_NAME}) ? $country->{DB_COUNTRY_NAME} : "" ); ?>" class="required ui-corner-all long" placeholder="e.g. General.Question.Bla bla" />	
		</div>		
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');		
	AKADEMEN.initializeFormValidation();
</script>
