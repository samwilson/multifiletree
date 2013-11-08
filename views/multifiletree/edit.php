
<form id="edit-form" action="<?php echo Route::url('multifiletree/save', array('id' => $item->id,)) ?>" method="post" enctype="multipart/form-data">

	<p>
		<label for="name">Name:</label>
		<?php echo Form::input('name', $item->name, array('id'=>'name', 'size'=>100)) ?>
	</p>

	<p>
		<label for="file">Upload file:</label>
		<?php echo Form::file('file', array('size'=>100)) ?>
	</p>

	<p>
		<?php if ($item->id) echo Form::hidden('id', $item->id) ?>
		<?php echo Form::submit(null, 'Save') ?>
	</p>

</form>

<?php echo $datalog ?>

