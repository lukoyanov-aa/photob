<?php 

class formPhotobattleBattle extends cmsForm{
    
    public function init(){
        
        return array(
            
            array(
            
            'type' => 'fieldset',
            'childs' => array(
                
                new fieldString/*fieldТип_поля String - строка*/('title'/*имя поля в базе данных*/, array(
                    'title' => LANG_PHOTOBATTLE_TITLE,
                    'rules' => array(       //правила заполнения
                        array('required'), //обязательно к заполнению
                        array('max_length', 100), //ограничение максимальной длины
                        array('min_length', 10) //ограничение минимальной длины
                    )
                )),
                
                new fieldImage/* Image - картинка */('logo', array(
                    'title' => LANG_PHOTOBATTLE_LOGO,
                    'options' => array(            //опции поля
                        'sizes' => array('small') //ограничиваем размер загружаемой картинки
                    )
                )),
                
                new fieldNumber /* Number - число */('min_users', array(
                    'title' => LANG_PHOTOBATTLE_MIN_USERS,
                    'default' => 10 //значение по умолчанию
                )),
                
                new fieldList /* List - выпадающий список */('status', array(
                    
                    'title' => LANG_PHOTOBATTLE_STATUS,
                    'items' => array( //элементы списка
                        0 => LANG_PHOTOBATTLE_STATUS_PENDING,
                        1 => LANG_PHOTOBATTLE_STATUS_MODERATION,
                        2 => LANG_PHOTOBATTLE_STATUS_OPENED,
                        3 => LANG_PHOTOBATTLE_STATUS_CLOSED,
                    )
                )),
                
                new fieldDate('date_end', array(
                
                    'title' => LANG_PHOTOBATTLE_DATE_END,
                    'rules' => array(
                        array('required')
                    )
                ))
                )
            )
        );
    }
}