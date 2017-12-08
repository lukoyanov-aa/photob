<?php
    $this->setPageTitle(LANG_PHOTOBATTLE_CONTROLLER);
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER);
    
    if (cmsUser::isAdmin()/*проверяем что текущий пользователь Администратор*/){
        //добавляем кнопку
        $this->addToolButton(array(
            'class' => 'add',
            'title' => LANG_PHOTOBATTLE_ADD,
            'href' => href_to('photobattle', 'add')
        ));
    }
    
    $statuses_text = array(
		0 => LANG_PHOTOBATTLE_STATUS_PENDING,
		1 => LANG_PHOTOBATTLE_STATUS_MODERATION,
		2 => LANG_PHOTOBATTLE_STATUS_OPENED,
		3 => LANG_PHOTOBATTLE_STATUS_CLOSED,		
	);
?>

<h1> <?php echo LANG_PHOTOBATTLE_CONTROLLER; ?></h1>

<?php if (!$battles) { ?>
    <p><?php echo LANG_PHOTOBATTLE_NONE; ?></p>
    <?php return; ?>
<?php } ?>

<div class="photobattles-list">
	<?php foreach($battles as $battle) { ?>
		<div class="item">
			<div class="logo"><?php echo html_image($battle['logo'], 'small') ?></div>
			<div class="details">
				<a href="<?php echo $this->href_to('battle', $battle['id']); ?>" class="title"><?php html($battle['title']); ?></a>
				<div class="info">
					<span class="status status-<?php echo $battle['status']; ?>">
						<?php echo $statuses_text[ $battle['status'] ]; ?>
					</span>
					<span class="users_count">
						<?php echo html_spellcount($battle['users_count'], LANG_PHOTOBATTLE_SPELLCOUNT); ?>
					</span>
				</div>
			</div>
		</div>
	<?php } ?>
</div>