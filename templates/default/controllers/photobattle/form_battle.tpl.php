<?php

    if ($do == 'add') {$page_title = LANG_PHOTOBATTLE_ADD;}
    if ($do == 'edit') {$page_title = LANG_PHOTOBATTLE_EDIT;}
    
    $this->setPageTitle($page_title);
    //добавляем глубиномер самого компонента
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, href_to('photobattle', ''));
    //добавляем глубиномер действия
    $this->addBreadcrumb($page_title);

?>

<h1> <?php echo $page_title; ?></h1>

<?php 

    $this->renderForm($form, //сама форма
                        $battle, //масив данных формы, на случай если что то уже заполнили и вылезла ошибка что бы не заполнять по новой
                        array(
                            'action' => '',
                            'method' => 'post',
                            'toolbar' => false
                        ), //массив настроке
                        $errors //ошибки
                        ); //выыодим форму
?>