<?php
    
    //добавляем глубиномер самого компонента
    $this->addBreadcrumb(LANG_PHOTOBATTLE_CONTROLLER, href_to('photobattle', ''));
    $this->addBreadcrumb($battle['title'], $this->href_to('battle', $battle['id']));
    $this->addBreadcrumb(LANG_PHOTOBATTLE_JOIN);
    
    $this->setPageTitle(LANG_PHOTOBATTLE_JOIN);

    

?>

<h1> <?php echo LANG_PHOTOBATTLE_JOIN ?></h1>

<?php 

    $this->renderForm($form, //сама форма
                        $photo, //масив данных формы, на случай если что то уже заполнили и вылезла ошибка что бы не заполнять по новой
                        array(
                            'action' => '',
                            'method' => 'post',
                            'toolbar' => false
                        ), //массив настроке
                        $errors //ошибки
                        ); //выыодим форму
?>