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
    
    
    public function isUserInBattle($user_id, $battle_id){
        
        $this->filterEqual('user_id', $user_id);
        $this->filterEqual('battle_id', $battle_id);
        
        $result = (bool)$this->getCount('photobattles_photos'); // 
        
        $this->resetFilters(); //сбрасываем фильтр, т.к. getCount их не сбрасывает
        
        return $result;
        
    }
    
    public function setBattleStatus($battle_id, $status){
		
		return $this->update('photobattles', $battle_id, array(
			'status' => $status
		));
		
	}
    
    	public function getUserPhotosCount($user_id, $battle_id){
		
		$this->filterEqual('user_id', $user_id);
		$this->filterEqual('battle_id', $battle_id);
		
		$result = $this->getCount('photobattles_photos');
		
		$this->resetFilters();
		
		return $result;
		
	}
    
    public function getPhoto($id){
        
		return $this->getItemById('photobattles_photos', $id);
	}
	
	public function deletePhoto($id){
		
		$config = cmsConfig::getInstance();
		
		$photo = $this->getPhoto($id);
		
		$images = self::yamlToArray($photo['image']);
		
		if (is_array($images)){
			foreach($images as $path){
				@unlink( $config->upload_path . $path );
			}
		}
		
		$this->delete('photobattles_photos', $id);
		
		$this->filterEqual('id', $photo['battle_id']);		
		$this->decrement('photobattles', 'users_count');
		
		$battle = $this->getBattle($photo['battle_id']);
		
		if ($battle['status'] == photobattle::STATUS_MODERATION){
			if ($battle['users_count'] < $battle['min_users']){
				$this->setBattleStatus($battle['id'], photobattle::STATUS_PENDING);
			}
		}
		
	}
    
    
    	public function getPhotosForVoting($battle_id, $user_id){
		
		$user = cmsUser::getInstance();
		
		$this->filterEqual('battle_id', $battle_id);
		
		$this->join('{users}', 'u', 'u.id = i.user_id');
		$this->select('u.nickname', 'user_nickname');
		
		$this->joinLeft('photobattles_votes', 'v', "v.user_id = '{$user->id}' AND v.photo_id = i.id");
		$this->filterIsNull('v.id');
		
		$this->order_by = "RAND()";
		
		$this->limit(2);
		
		return $this->get('photobattles_photos');
		
	}
	
	public function addVote($vote){
		
		if ($vote['score'] > 0){
			
			$this->
				filterEqual('id', $vote['photo_id'])->
				increment('photobattles_photos', 'score', $vote['score']);
			
		}
		
		return $this->insert('photobattles_votes', $vote);
		
	}
	
	public function closeExpiredBattles(){
		
		$this->filterDateOlder('date_end', 1, 'DAY');
		
		$this->updateFiltered('photobattles', array(
			'status' => photobattle::STATUS_CLOSED
		));
		
	}
}

?>