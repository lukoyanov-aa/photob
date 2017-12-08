<?php 

class modelPhotobattle extends cmsModel {
    
    //функция добаления одной битвы в БД
    public function addBattle($battle){
         //метод insert возвращает id вставленной записи если в таблице есть поле id
        return $this->insert('photobattles' //имя таблицы куда будем вставлять без префикса cms_
                                , $battle //массив который будем вставлять
                            );
    }
    
    //функция получения одной битвы по id
    public function getBattle($id){
        
        $battle = $this->getItemById('photobattles', $id);
		
		$this->filterEqual('battle_id', $id);
		
		$this->orderBy('score', 'desc');
		
		$this->join('{users}', 'u', 'u.id = i.user_id');
		
		$this->select('u.nickname', 'user_nickname');
		
		$battle['photos'] = $this->get('photobattles_photos');
		
		return $battle;
        
        return $battle;
    }
    
    //функция одной битвы
    public function updateBattle($id, $battle){
        
        return $this->update('photobattles', $id, $battle);
    }
    
    //функция удаления одной битвы и файлов с картинками
    public function deleteBattle($id){
        
        $config = cmsConfig::getInstance();
        
        $battle = $this->getBattle($id);
        
        $logos = self::yamlToArray($battle['logo']);
        if (is_array($logos)){
            foreach($logos as $path){
                
                unlink( $config->upload_path . $path);
            }
        }
        
        return $this->delete('photobattles', $id);
    }
    
    //функция получения списка битв
    public function getBattles(){
        
        return $this->get('photobattles');
    }
    
    //функция получения количества битв
    public function getBattlesCount(){
        
        return $this->getCount('photobattles');
    }
    
    public function addPhoto($photo){
        
        $photo_id = $this->insert('photobattles_photos' //имя таблицы куда будем вставлять без префикса cms_
                                , $photo //массив который будем вставлять
                            );
        //устанавливаем фильтр перед действием
        $this->filterEqual('id', $photo['battle_id']);
        //увеличиваем поле таблицы на 1
        $this->increment('photobattles', 'users_count', 1);
                            
        return $photo_id;
    }
}

?>