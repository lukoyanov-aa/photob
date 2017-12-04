<?php

    if ($do == 'add') {$page_title = LANG_PHOTOBATTLE_ADD;}
    if ($do == 'edit') {$page_title = LANG_PHOTOBATTLE_EDIT;}
    
    $this->setPageTitle($page_title);
    
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, href_to('photobattle', ''));
    $this->addBreadcrumb($page_title);

?>

<h1> <?php echo $page_title; ?></h1>