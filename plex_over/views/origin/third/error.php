<?php foreach ($items as $key => $object): ?>
	<?php if (! is_array($object)): ?>
	<div>
		<p><?= $object ?></p>
	</div>
	<?php endif ?>
<?php endforeach ?>