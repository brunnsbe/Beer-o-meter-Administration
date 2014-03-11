<div class="overflowscroll">
	<div class="tools">
		<a href="<?php echo CONTROLLER_DISTRICTS_EDITSINGLE ?>" class="button" data-icon="ui-icon-plus" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_CREATE_NEW_DISTRICT); ?></a>
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
				<th><span class="ui-icon ui-icon-pencil" title="<?php echo lang(LANG_KEY_BUTTON_EDIT_DISTRICT); ?>"></span></th>
				<th><span class="ui-icon ui-icon-trash" title="<?php echo lang(LANG_KEY_BUTTON_DELETE_DISTRICT); ?>"></span></th>
				<th><?php echo lang(LANG_KEY_FIELD_NAME); ?></th>
				<th><?php echo lang(LANG_KEY_FIELD_COUNTRY); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($districtList as $key => $district): ?>
			<tr>
				<td>
					<a href="<?php echo site_url() . CONTROLLER_DISTRICTS_EDITSINGLE . '/' . $district->{DB_DISTRICT_ID}; ?>" class="button" data-icon="ui-icon-pencil" data-text="false" data-formdialog="true"><?php echo lang(LANG_KEY_BUTTON_EDIT_DISTRICT); ?></a>						
				</td>
				<td>
					<a href="<?php echo site_url() . CONTROLLER_DISTRICTS_DELETESINGLE . '/' . $district->{DB_DISTRICT_ID}; ?>" class="button" data-icon="ui-icon-trash" data-text="false" data-confirmdialog="true"><?php echo lang(LANG_KEY_BUTTON_DELETE_DISTRICT); ?></a>
				</td>
				<td><?php echo $district->{DB_DISTRICT_NAME}; ?></td>			
				<td><?php echo $district->{DB_TABLE_COUNTRY . DB_COUNTRY_NAME}; ?></td>			
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
				url = "<?php echo site_url() . CONTROLLER_DISTRICTS_LISTALL . '?'; ?>";
				url += $filters.serialize();
				
			$('#ui-tabs-' + (selectedTab + 1)).load(url, function() {
				AKADEMEN.initializeButtons();
				//Change tab-link to point to selected page
				$('.ui-tabs-active a').attr('href', url);
			});
			return false;		
		});
</script>
