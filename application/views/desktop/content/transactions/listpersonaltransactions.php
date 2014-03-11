<div class="pagination">
	<?php echo $pagination; ?>
</div>
<table>
	<thead>
		<tr>
			<th><?php echo lang(LANG_KEY_FIELD_DATE); ?></th>
			<th><?php echo lang(LANG_KEY_FIELD_EVENT); ?> / <?php echo lang(LANG_KEY_FIELD_DESCRIPTION); ?></th>			
			<th class="alignright"><?php echo lang(LANG_KEY_FIELD_AMOUNT); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="2">Totalt:</td>
			<td class="alignright"><?php echo formatCurrency(($transactionSum->{DB_TOTALSUM} == NULL) ? 0 : $transactionSum->{DB_TOTALSUM}); ?></td>
		</tr>
	</tfoot>
	<tbody>
	<?php foreach($transactionList as $transaction) { ?>
		<tr>
			<td><?php echo formatDateGerman($transaction->{DB_TRANSACTION_TRANSACTIONDATE}); ?></td>
			<td><?php echo $transaction->{DB_EVENT_NAME}; ?><?php echo $transaction->{DB_TRANSACTION_DESCRIPTION}; ?></td>	
			<td class="alignright"><?php echo formatCurrency($transaction->{DB_TRANSACTION_AMOUNT}); ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script>
	$('#mytransactions-body .pagination a').bind('click', function (e) {
		e.preventDefault();
		$('#mytransactions-body').load($(this).attr("href"), function() {
			AKADEMEN.initializeButtons();
		});		
	});
</script>		