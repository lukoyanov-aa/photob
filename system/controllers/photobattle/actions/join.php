<?php

class actionPhotobattleJoin extends cmsAction{
    
    public function run($battle_id){
        
        if (!$battle_id){
            cmsCore::error404(); //выводим ошибку 404
        }
        
        $battle = $this->model->getBattle($battle_id);
        
        if (!$battle || $battle['status'] != photobattle::STATUS_PENDING){
            
            cmsCore::error404();
        }
        
        $form = $this->getForm('join'); //выводим созданную форму
        
        $errors = false; //переменная для записи ошибок валидации
        $template = cmsTemplate::getInstance();
        $user = cmsUser::getInstance();
        
        // переменная с информацией 
        $is_submitted = $this->request->has('submit'); //has - проверяет наличие переменной submit в запросе
        // переменная для сбора данных формы
        $photo = $form->parse($this->request/* данные введенные пользователем и переданные методом post*/, 
                                $is_submitted/*булевая переменная была ли отправленна форма*/
                              ); 
                              
        if ($is_submitted){
            
            $errors = $form->validate($this, $photo); //валидируем форму
            
            if (!$errors){
                $photo['battle_id'] = $battle_id;
                $photo['user_id'] = $user->id;
                $this->model->addPhoto($photo);
                //после добавлению битвы делаем редирект на экшен созданной битвы
                $this->redirectToAction('battle' //имя экшена
                                        ,array($battle_id) //массив передаваемых параметров
                                        );
            }
            
            if ($errors){
                cmsUser::addSessionMessage(LANG_FORM_ERRORS//стандартная переменная с текстом ошибки
                                            , 'error'// css класс который будет добалвен к сообщению может быть success info error 
                                           );
            }
        }
        
        $template->render('form_join', array( //рендерим шаблон и передаем в него ряд параметров
            'form' => $form, // обект формы form_battle
            'errors' => $errors,
            'photo' => $photo,
            'battle' => $battle
        ));
    }

}