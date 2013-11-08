


<h2>Actions</h2>
<ul>
	<li>
		<a href="<?php echo Route::url('multifiletree/edit', array('id'=>$item->id)) ?>">
			Edit
		</a>
	</li>
	<li>
		<a href="<?php echo Route::url('multifiletree/render', array('id'=>$item->id, 'ext'=>$item->get_ext())) ?>">
			Download
		</a>
	</li>
</ul>

<h2>Data Log</h2>
<?php echo $datalog ?>
