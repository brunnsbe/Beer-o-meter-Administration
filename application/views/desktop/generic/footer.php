		</div>
		<div id="ajaxloading"></div>		
		
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>		

		<script src="<?php echo base_url()?>js/desktop/main.js"></script>
		<script>
			$(function() {
				//AKADEMEN.initializeFormDialog("<?php echo lang(LANG_KEY_BUTTON_SAVE); ?>", "<?php echo lang(LANG_KEY_BUTTON_CANCEL); ?>");
				//AKADEMEN.initializeConfirmDialog("<?php echo lang(LANG_KEY_BUTTON_CONFIRM); ?>", "<?php echo lang(LANG_KEY_BUTTON_OK); ?>", "<?php echo lang(LANG_KEY_BUTTON_CANCEL); ?>");
				//AKADEMEN.initializeAlertDialog("<?php echo lang(LANG_KEY_BUTTON_OK); ?>");
				//AKADEMEN.initializeListDialog();
				//AKADEMEN.initializeButtons();
				AKADEMEN.initializeTabs();	
				//AKADEMEN.initializeDatepicker();
				//AKADEMEN.initializeAjaxLoading();				
			});				
		
			//Check and execute executeOnStart if found
			if (typeof window.executeOnStart === 'function') {
				$(executeOnStart($));
			}
		</script>
	</body>
</html>