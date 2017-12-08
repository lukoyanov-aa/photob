<?php 
    
    //добавляем заголовок странициы
    $this->setPageTitle($battle['title']);
    
    //добавляем глубиномер самого компонента
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, href_to('photobattle', ''));
    //добавляем глубиномер действия
    $this->addBreadcrumb($battle['title']);
    
    
    $is_show_names = $this->controller->options['show_names'];
    
    if ($battle['status'] == photobattle::STATUS_PENDING ){
        
        //добавляем кнопку
        $this->addToolButton(array(
            'class' => 'user_add',
            'title' => LANG_PHOTOBATTLE_JOIN,
            'href' => href_to('photobattle', 'join', $battle['id'])
        ));
    }
    
    if (cmsUser::isAdmin()){
        
        //добавляем кнопку
        $this->addToolButton(array(
            'class' => 'edit',
            'title' => LANG_PHOTOBATTLE_EDIT,
            'href' => href_to('photobattle', 'edit', $battle['id'])
        ));
        
        $this->addToolButton(array(
            'class' => 'delete',
            'title' => LANG_PHOTOBATTLE_DELETE,
            'href' => href_to('photobattle', 'delete', $battle['id'])
        ));
    }

?>

<h1>
    <?php 
        html($battle['title']);//выводим элемент массива и экранируем его 
    ?>
</h1>

<?php if ($battle['photos']) { ?>

	<div class="photobattle-images">
		<ul>
			<?php foreach($battle['photos'] as $photo) { ?>
				<li>
					<a class="image" href="<?php echo html_image_src($photo['image'], 'big', true); ?>" title="<?php if ($is_show_names) { echo $photo['user_nickname']; } ?>">
						<?php echo html_image($photo['image'], 'small'); ?>
					</a>
					<div class="details">
						<?php /*if ($is_show_names) { */?>
							<a class="user" href="<?php echo href_to('users', $photo['user_id']); ?>"><?php echo $photo['user_nickname']; ?></a> 
						<?php /*} */?>
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