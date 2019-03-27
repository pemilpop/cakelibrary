<div class="actions">
	<h3><?= __('Recent Books') ?></h3>
	<ul>
		<li><strong>You have <?= $total_posts ?> posts total</strong></li>
		<?php 
		foreach ($recent_posts as $post) {
			echo "<li>".$post['title']."</li>";
		}
		?>
	</ul>
</div>