<?php

class actionPhotobattleEdit extends cmsAction{
    
    public function run($id = false){
        
        if (!cmsUser::isAdmin()/*проверяем если текущий пользователь НЕ Администратор*/){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        if (!$id){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $battle = $this->model->getBattle($id);
        
        $form = $this->getForm('battle'); //выводим созданную форму form_battle
        
        $errors = false; //переменная для записи ошибок валидации
        $template = cmsTemplate::getInstance();
        
        // переменная с информацией 
        $is_submitted = $this->request->has('submit'); //has - проверяет наличие переменной submit в запросе
                              
        if ($is_submitted){
            
             // переменная для сбора данных формы
            $battle = $form->parse($this->request/* данные введенные пользователем и переданные методом post*/, 
                                $is_submitted/*булевая переменная была ли отправленна форма*/
                              ); 
            
            $errors = $form->validate($this, $battle); //валидируем форму
            
            if (!$errors){
                //обновляем данные в БД с помощью модели updateBattle
                $this->model->updateBattle($id, $battle);
                //после добавлению битвы делаем редирект на экшен созданной битвы
                $this->redirectToAction('battle' //имя экшена
                                        ,array($id) //массив передаваемых параметров
                                        );
            }
            
            if ($errors){
                cmsUser::addSessionMessage(LANG_FORM_ERRORS//стандартная переменная с текстом ошибки
                                            , 'error'// css класс который будет добалвен к сообщению может быть success info error 
                                           );
            }
        }
        
        $template->render('form_battle', array( //рендерим шаблон и передаем в него ряд параметров
            'do' => 'edit', // параметр с информацией о действии add - добавление, edit - редактирование
            'form' => $form, // обект формы form_battle
            'errors' => $errors,
            'battle' => $battle
        ));
    }

}