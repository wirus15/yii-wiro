<fieldset>
    <legend>Export database to CSV</legend>
    
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'export-form',
    )); ?>

    <table id="tables" class="table table-condensed table-bordered">
	<thead>
	    <tr>
		<td width="1"><input type="checkbox"/></td>
		<td></td>
	    </tr>
	</thead>
	<tbody>
	<?php foreach($tables as $table): ?>
	<tr>
	    <td><input type="checkbox" name="tables[]" value="<?= $table; ?>"/></td>
	    <td><?= $table; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
    </table>
    
    <div class="form-actions">
	<?= TbHtml::submitButton('Export', array('color' => 'primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</fieldset>

<script>
$('#tables thead input').change(function() {
    $('#tables tbody input').prop('checked', $(this).prop('checked'));
});  
</script>