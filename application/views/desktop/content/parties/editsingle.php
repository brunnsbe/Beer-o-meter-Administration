<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_PARTIES_SAVESINGLE . (isset($partyId) ? "/" . $partyId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend><?php echo lang(LANG_KEY_HEADER_PARTY_INFORMATION); ?></legend>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_PARTY . '_' .  DB_PARTY_NAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_NAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_PARTY . '_' . DB_PARTY_NAME ?>" id="<?php echo DB_TABLE_PARTY . '_' . DB_PARTY_NAME ?>" value="<?php echo set_value(DB_TABLE_PARTY . '_' . DB_PARTY_NAME, isset($party->{DB_PARTY_NAME}) ? $party->{DB_PARTY_NAME} : "" ); ?>" class="required ui-corner-all long" placeholder="" />	
		</div>		
		
		<div class="single-field" style="clear: both">
			<label for="<?php echo DB_TABLE_PARTY . '_' .  DB_PARTY_COUNTRYID; ?>">
				<?php echo lang(LANG_KEY_FIELD_COUNTRY); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<?php echo form_dropdown(DB_TABLE_PARTY . '_' . DB_PARTY_COUNTRYID, $countryList, set_value(DB_TABLE_PARTY . '_' . DB_PARTY_COUNTRYID, isset($party->{DB_PARTY_COUNTRYID}) ? $party->{DB_PARTY_COUNTRYID} : "" ), 'id="' . DB_TABLE_PARTY . '_' . DB_PARTY_COUNTRYID . '" class="required ui-corner-all short"'); ?>		
		</div>			
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');		
	AKADEMEN.initializeFormValidation();
</script>
