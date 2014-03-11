<label class="error">
	<?php echo validation_errors(); ?>
</label>
<?php echo form_open(CONTROLLER_DISTRICTS_SAVESINGLE . (isset($districtId) ? "/" . $districtId : ""), array('id' => 'form_editobject')); ?>
	<p>
		<legend><span class="requiredsymbol">*</span> <?php echo lang(LANG_KEY_MISC_REQUIRED_FIELD); ?></legend> 
	</p>
	<fieldset class="ui-corner-all">
		<legend><?php echo lang(LANG_KEY_HEADER_DISTRICT_INFORMATION); ?></legend>

		<div class="single-field">
			<label for="<?php echo DB_TABLE_DISTRICT . '_' .  DB_DISTRICT_NAME; ?>">
				<?php echo lang(LANG_KEY_FIELD_NAME); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<input maxlength="255" type="text" name="<?php echo DB_TABLE_DISTRICT . '_' . DB_DISTRICT_NAME ?>" id="<?php echo DB_TABLE_DISTRICT . '_' . DB_DISTRICT_NAME ?>" value="<?php echo set_value(DB_TABLE_DISTRICT . '_' . DB_DISTRICT_NAME, isset($district->{DB_DISTRICT_NAME}) ? $district->{DB_DISTRICT_NAME} : "" ); ?>" class="required ui-corner-all long" placeholder="" />	
		</div>		
		
		<div class="single-field" style="clear: both">
			<label for="<?php echo DB_TABLE_DISTRICT . '_' .  DB_DISTRICT_COUNTRYID; ?>">
				<?php echo lang(LANG_KEY_FIELD_COUNTRY); ?>
			</label>
			<span class="requiredsymbol">*</span>
			<br/>
			<?php echo form_dropdown(DB_TABLE_DISTRICT . '_' . DB_DISTRICT_COUNTRYID, $countryList, set_value(DB_TABLE_DISTRICT . '_' . DB_DISTRICT_COUNTRYID, isset($party->{DB_DISTRICT_COUNTRYID}) ? $party->{DB_DISTRICT_COUNTRYID} : "" ), 'id="' . DB_TABLE_DISTRICT . '_' . DB_DISTRICT_COUNTRYID . '" class="required ui-corner-all short"'); ?>		
		</div>			
		
	</fieldset>
	
</form>

<script>
	AKADEMEN.initializeButtons('#dialog_form');		
	AKADEMEN.initializeFormValidation();
</script>
