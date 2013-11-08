<!DOCTYPE html>
<html lang="en" dir="ltr" class="client-nojs">

	<head>
		<?php echo View::factory('multifiletree/head')->bind('title', $title)->render() ?>
	</head>

	<body class="<?php echo $action ?>-action">

		<div id="topbar">
			<h1>
				<a href="<?php echo Route::url('multifiletree') ?>">
					<?php echo $sitetitle ?>
				</a>
			</h1>
			<ul>
				<li><a href="<?php echo Route::url('multifiletree/new') ?>">New</a></li>
				<li>
					<?php if (Auth::instance()->logged_in()): ?>
					You are logged in as
					<a href="<?php echo Route::url('multifiletree') ?>">
						<?php echo Auth::instance()->get_user() ?>
					</a>
					<?php else: ?>
					<a href="<?php echo Route::url('multifiletree') ?>">
						<?php echo __('Login') ?>
					</a>
					<?php endif ?>
				</li>
			</ul>
		</div>

		<div id="main">
			<h1><?php echo $title ?></h1>
			<?php echo $main->render() ?>
		</div>

		<div id="menu">
			<ol>
				<?php foreach ($roots as $root): ?>
					<li>
						<a class="ui-icon ui-icon-folder-collapsed"></a>
						<a href="<?= Route::url('multifiletree', array('id'=>$root->id)) ?>" data-id="<?= $root->id ?>">
							<?= $root->name ?>
						</a>
					</li>
				<?php endforeach ?>
			</ol>
		</div>

		<div id="footer" class="noprint">
			<ol>
				<li>
					This is <a href="https://github.com/samwilson/multifiletree">Multifiletree</a>.
				</li>
				<li>
					Please report any
					<a href="https://github.com/samwilson/multifiletree/issues" title="Click here to report a bug">issues</a>.
				</li>
				<li>
					Built on <a href="http://kohanaframework.org">Kohana</a>
					<?php echo Kohana::VERSION ?>
					(<dfn title="Kohana codename"><?php echo Kohana::CODENAME ?></dfn>).
					<?php if (Kohana::$environment != Kohana::PRODUCTION): ?>
						Currently in <?php echo KOHANA_ENVIRONMENT ?> mode.
					<?php endif ?>
				</li>
			</ol>

			<?php if (Kohana::$profiling): ?>
				<div id="kohana-profiler">
					<?php echo View::factory('profiler/stats') ?>
				</div>
			<?php endif ?>

		</div>

		<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script src="<?php echo Media::url('js/scripts.js') ?>"></script>

	</body>
</html>
