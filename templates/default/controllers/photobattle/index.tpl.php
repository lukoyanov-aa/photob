<?php
    $this->setPageTitle(LANG_PHOTOBATTLE_CONTROLLER);
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER);
    
    if (cmsUser::isAdmin()/*проверяем что текущий пользователь Администратор*/){
    
        $this->addToolButton(array(
            'class' => 'add',
            'title' => LANG_PHOTOBATTLE_ADD,
            'href' => href_to('photobattle', 'add')
        ));
    }
?>

<h1> <?php echo LANG_PHOTOBATTLE_CONTROLLER; ?></h1>

<?php if (!$battles) { ?>
    <p><?php echo LANG_PHOTOBATTLE_NONE; ?></p>
    <?php return; ?>
<?php } ?>