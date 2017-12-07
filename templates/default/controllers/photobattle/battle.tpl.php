<?php 
    
    //добавляем заголовок странициы
    $this->setPageTitle($battle['title']);
    
    //добавляем глубиномер самого компонента
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, href_to('photobattle', ''));
    //добавляем глубиномер действия
    $this->addBreadcrumb($battle['title']);
    
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