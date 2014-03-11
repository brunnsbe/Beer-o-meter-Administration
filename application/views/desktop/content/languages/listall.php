	<form class="form-inline" role="form">
		<div class="form-group">	
			<?php echo lang(LANG_KEY_FIELD_SEARCH); ?>:&nbsp;<input maxlength="50" type="text" name="<?php echo HTTP_WILDCARDSEARCH; ?>" id="<?php echo HTTP_WILDCARDSEARCH; ?>" value="<?php echo set_value(HTTP_WILDCARDSEARCH, isset($wildCardSearch) ? $wildCardSearch : "" ); ?>" class="required ui-corner-all short" placeholder="<?php echo lang(LANG_KEY_FIELD_SEARCH); ?>" />	
		</div>
		<div class="form-group">	
			<?php echo lang(LANG_KEY_FIELD_LANGUAGECODE); ?>:&nbsp;<?php echo form_dropdown(DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGECODE, $languageKeys, set_value(DB_TABLE_LANGUAGE . "_" . DB_LANGUAGE_LANGUAGECODE, isset($languageCode) ? $languageCode : "" ), 'id="' . DB_TABLE_LANGUAGE . '_' . DB_LANGUAGE_LANGUAGECODE . '" class="required ui-corner-all short"'); ?>		
		</div>
	</div>	
	</form>
	<div class="btn-group">
		<a href="<?php echo CONTROLLER_LANGUAGES_EDITSINGLE ?>" class="btn btn-primary" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_LANGUAGE); ?></a>
	</div>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<colgroup>
				<col style="width: 27px" />
				<col style="width: 27px" />
				<col />
				<col />
				<col />
			</colgroup>	
			<thead>
				<tr>
					<th><span class="glyphicon glyphicon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_LANGUAGE); ?>"></span></th>
					<th><span class="glyphicon glyphicon-remove" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_LANGUAGE); ?>"></span></th>
					<th><?php echo lang(LANG_KEY_FIELD_KEY); ?></th>
					<th><?php echo lang(LANG_KEY_FIELD_LANGUAGECODE); ?></th>
					<th><?php echo lang(LANG_KEY_FIELD_DATA); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($languageList as $key => $language): ?>
				<tr>
					<td>
						<a href="<?php echo site_url() . CONTROLLER_LANGUAGES_EDITSINGLE . '/' . $language->{DB_LANGUAGE_ID}; ?>" class="btn btn-primary btn-sm glyphicon glyphicon-pencil" data-text="false" data-formdialog="true" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_LANGUAGE); ?>"></a>						
					</td>
					<td>
						<a href="<?php echo site_url() . CONTROLLER_LANGUAGES_DELETESINGLE . '/' . $language->{DB_LANGUAGE_ID}; ?>" class="btn btn-danger btn-sm glyphicon glyphicon-remove" data-text="false" data-confirmdialog="true" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_LANGUAGE); ?>"></a>
					</td>
					<td><?php echo $language->{DB_LANGUAGE_LANGUAGEKEY}; ?></td>			
					<td><?php echo $language->{DB_LANGUAGE_LANGUAGECODE}; ?></td>
					<td><?php echo $language->{DB_LANGUAGE_DATA}; ?></td>
				</tr>
			<?php endforeach; ?>		
			</tbody>
		</table>
	</div>
<script>
	$('.pagination a')
		.bind('click', function() {
			var selectedTab = $('#header_navitabs').tabs('option', 'active'),
				url = $(this).attr('href');

			$('#ui-tabs-' + (selectedTab + 1)).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;
		});
		
	var $filters = $('#maindiv').find('input, select');
	$filters.bind('change', function() {
				var url = "<?php echo site_url() . CONTROLLER_LANGUAGES_LISTALL . '?'; ?>";
				url += $filters.serialize();
				$('ul.navbar-nav li.active a').data("link", url).trigger('click');
			return false;		
		});
</script>
