<?php

	$this->setPageTitle($battle['title']);
	
	$this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, $this->href_to(''));
	$this->addBreadcrumb($battle['title']);

	$is_show_names = $this->controller->options['show_names'];
	
	$is_can_join = cmsUser::isAllowed('battles', 'join');
	
	if ($is_can_join && $battle['status'] == photobattle::STATUS_PENDING){
		
		if (!$is_user_in_battle || cmsUser::isAdmin()){
		
			$this->addToolButton(array(
				'class' => 'user_add',
				'title' => LANG_PHOTOBATTLE_JOIN,
				'href' => $this->href_to('join', $battle['id'])
			));		
			
		}
		
	}
	
	$user = cmsUser::getInstance();
	
	$is_can_edit = $user->is_admin ||
					cmsUser::isAllowed('battles', 'edit', 'all') ||
					(cmsUser::isAllowed('battles', 'edit', 'own') && $battle['user_id']==$user->id);
	
	if ($is_can_edit){
		
		if ($battle['status'] != photobattle::STATUS_OPENED){
			$this->addToolButton(array(
				'class' => 'accept',
				'title' => LANG_PHOTOBATTLE_START,
				'href' => $this->href_to('start', $battle['id'])
			));			
		}
		
		if ($battle['status'] == photobattle::STATUS_OPENED){
			$this->addToolButton(array(
				'class' => 'cancel',
				'title' => LANG_PHOTOBATTLE_STOP,
				'href' => $this->href_to('stop', $battle['id'])
			));			
		}
		
		$this->addToolButton(array(
			'class' => 'edit',
			'title' => LANG_PHOTOBATTLE_EDIT,
			'href' => $this->href_to('edit', $battle['id'])
		));
		
		$this->addToolButton(array(
			'class' => 'delete',
			'title' => LANG_PHOTOBATTLE_DELETE,
			'href' => $this->href_to('delete', $battle['id'])
		));
		
	}
	
	$statuses_text = array(
		0 => LANG_PHOTOBATTLE_STATUS_PENDING,
		1 => LANG_PHOTOBATTLE_STATUS_MODERATION,
		2 => LANG_PHOTOBATTLE_STATUS_OPENED,
		3 => LANG_PHOTOBATTLE_STATUS_CLOSED,		
	);	
	
?>

<h1><?php html($battle['title']); ?></h1>

<div class="photobattle-status">
	<strong><?php echo LANG_PHOTOBATTLE_STATUS; ?>:</strong>
	<?php echo $statuses_text[ $battle['status'] ]; ?> 
	<?php if ($battle['status'] == photobattle::STATUS_OPENED) { ?>
		&mdash; <?php echo LANG_PHOTOBATTLE_YOU_VOTED; ?>
	<?php } ?>
</div>

<?php if ($battle['status'] == photobattle::STATUS_CLOSED) { ?>

	<?php
		$winners = array_slice($battle['photos'], 0, 3);
		$battle['photos'] = array_slice($battle['photos'], 3);
	?>

	<h2><?php echo LANG_PHOTOBATTLE_WINNERS; ?></h2>
	
	<div class="photobattle-winners">
		
		<div class="place place-1">
			<?php $photo = array_shift($winners); ?>
			<h3><?php echo LANG_PHOTOBATTLE_1_PLACE; ?></h3>
			<?php if ($is_show_names) { ?>
				<div class="user">
					<a href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a> 
				</div>
			<?php } ?>
			<?php echo html_image($photo['image'], 'big'); ?>			
		</div>
		
		<div class="places-2-3">
			<div class="place place-2">
				<?php $photo = array_shift($winners); ?>
				<h3><?php echo LANG_PHOTOBATTLE_2_PLACE; ?></h3>
				<?php if ($is_show_names) { ?>
					<div class="user">
						<a href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a> 
					</div>
				<?php } ?>
				<a class="ajax-modal" href="<?php echo html_image_src($photo['image'], 'big', true); ?>" title="<?php if ($is_show_names) { echo $photo['user_nickname']; } ?>">
					<?php echo html_image($photo['image'], 'normal'); ?>				
				</a>
			</div>
			<div class="place place-3">
				<?php $photo = array_shift($winners); ?>
				<h3><?php echo LANG_PHOTOBATTLE_3_PLACE; ?></h3>
				<?php if ($is_show_names) { ?>
					<div class="user">
						<a href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a> 
					</div>
				<?php } ?>
				<a class="ajax-modal" href="<?php echo html_image_src($photo['image'], 'big', true); ?>" title="<?php if ($is_show_names) { echo $photo['user_nickname']; } ?>">
					<?php echo html_image($photo['image'], 'normal'); ?>				
				</a>
			</div>
		</div>
		
	</div>

<?php } ?>

<?php if ($battle['photos']) { ?>

	<div class="photobattle-images">
		<ul>
			<?php foreach($battle['photos'] as $photo) { ?>
				<li>
					<a class="image" href="<?php echo html_image_src($photo['image'], 'big', true); ?>" title="<?php if ($is_show_names) { echo $photo['user_nickname']; } ?>">
						<?php echo html_image($photo['image'], 'small'); ?>
					</a>
					<div class="details">
						<?php if ($is_show_names) { ?>
							<a class="user" href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a> 
						<?php } ?>
						<a class="delete" title="<?php echo LANG_PHOTOBATTLE_PHOTO_DELETE; ?>" href="<?php echo $this->href_to('delete_photo', $photo['id']); ?>">X</a>
						<?php if ($battle['status'] == photobattle::STATUS_CLOSED) { ?>
							<div class="result">
								<?php echo LANG_PHOTOBATTLE_WINS . ': ' . $photo['score']; ?>
							</div>
						<?php } ?>
					</div>
				</li>
			<?php } ?>
		</ul>
		<script>
			$(document).ready(function(){
				icms.modal.bindGallery('.photobattle-images .image');
			})
		</script>
	</div>

<?php } ?>
