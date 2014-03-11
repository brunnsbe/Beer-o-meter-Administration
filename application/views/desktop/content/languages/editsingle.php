<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_LANGUAGES_SAVESINGLE . (isset($languageId) ? "/" . $languageId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend><?php echo lang(LANG_KEY_HEADER_LANGUAGE_INFORMATION); ?></legend>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_LANGUAGE . '_' .  DB_LANGUAGE_LANGUAGEKEY; ?>">
				<?php echo lang(LANG_KEY_FIELD_KEY); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGEKEY ?>" id="<?php echo DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGEKEY ?>" value="<?php echo set_value(DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGEKEY, isset($language->{DB_LANGUAGE_LANGUAGEKEY}) ? $language->{DB_LANGUAGE_LANGUAGEKEY} : "" ); ?>" class="required ui-corner-all long" placeholder="e.g. General.Question.Bla bla" />	
		</div>	
	
		<div class="single-field" style="clear: both">
			<label for="<?php echo DB_TABLE_LANGUAGE . '_' .  DB_LANGUAGE_LANGUAGECODE; ?>">
				<?php echo lang(LANG_KEY_FIELD_LANGUAGECODE); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<?php echo form_dropdown(DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGECODE, $languageCodes, set_value(DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGECODE, isset($language->{DB_LANGUAGE_LANGUAGECODE}) ? $language->{DB_LANGUAGE_LANGUAGECODE} : "" ), 'id="' . DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGECODE . '" class="required ui-corner-all short"'); ?>		
		</div>		
	
		<div class="single-field" style="clear: both">
			<label for="<?php echo DB_TABLE_LANGUAGE . '_' .  DB_LANGUAGE_DATA; ?>">
				<?php echo lang(LANG_KEY_FIELD_DATA); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<textarea name="<?php echo DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_DATA ?>" id="<?php echo DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_DATA ?>" class="required ui-corner-all"><?php echo set_value(DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_DATA, isset($language->{DB_LANGUAGE_DATA}) ? $language->{DB_LANGUAGE_DATA} : "" ); ?></textarea>
		</div>				
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');		
	AKADEMEN.initializeFormValidation();
</script>
