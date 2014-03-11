<div class="overflowscroll">
	<div class="tools">
		<a href="<?php echo CONTROLLER_COUNTRIES_EDITSINGLE ?>" class="button" data-icon="ui-icon-plus" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_COUNTRY); ?></a>
	</div>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<table>
		<colgroup>
			<col style="width: 27px" />
			<col style="width: 27px" />
			<col />
			<col />
		</colgroup>	
		<thead>
			<tr>
				<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_COUNTRY); ?>"></span></th>
				<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_COUNTRY); ?>"></span></th>
				<th><?php echo lang(LANG_KEY_FIELD_NAME); ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_DISTRICTS); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($countryList as $key => $country): ?>
			<tr>
				<td>
					<a href="<?php echo site_url() . CONTROLLER_COUNTRIES_EDITSINGLE . '/' . $country->{DB_COUNTRY_ID}; ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_COUNTRY); ?></a>						
				</td>
				<td>
					<a href="<?php echo site_url() . CONTROLLER_COUNTRIES_DELETESINGLE . '/' . $country->{DB_COUNTRY_ID}; ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_COUNTRY); ?></a>
				</td>
				<td><?php echo $country->{DB_COUNTRY_NAME}; ?></td>			
				<td><?php echo $country->{DB_TOTALCOUNT}; ?></td>
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
		
	$filters = $('.filters').find('input, select');
	$filters.bind('change', function() {
			var selectedTab = $('#header_navitabs').tabs('option', 'active'),
				url = "<?php echo site_url() . CONTROLLER_COUNTRIES_LISTALL . '?'; ?>";
				url += $filters.serialize();
				
			$('#ui-tabs-' + (selectedTab + 1)).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;		
		});
</script>
