<?php

	$this->setPageTitle($battle['title']);
	
	$this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, $this->href_to(''));
	$this->addBreadcrumb($battle['title']);
	
	$user = cmsUser::getInstance();
	
	$is_can_edit = $user->is_admin ||
					cmsUser::isAllowed('battles', 'edit', 'all') ||
					(cmsUser::isAllowed('battles', 'edit', 'own') && $battle['user_id']==$user->id);
	
	if ($is_can_edit){	
	
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
		
?>

<h1><?php html($battle['title']); ?></h1>

<h3><?php echo LANG_PHOTOBATTLE_SELECT_VS; ?></h3>

<div class="photobattle-versus">

	<?php $ids = array(array_keys($vote_photos), array_reverse(array_keys($vote_photos))); ?>	
	
	<?php foreach ($vote_photos as $id => $photo) { ?>
	
		<div class="photo">
			<div class="user"><a href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a></div>
			<a href="<?php echo $this->href_to('vote', array_shift($ids)); ?>"><?php echo html_image($photo['image'], 'normal'); ?></a>
			<div class="zoom">
				<a class="ajax-modal" href="<?php echo html_image_src($photo['image'], 'big', true); ?>"><?php echo LANG_PHOTOBATTLE_ZOOM; ?></a>
			</div>
		</div>
	
	<?php } ?>
	
</div>