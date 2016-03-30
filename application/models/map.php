<?php

class Map extends CI_Model {

	function all_schools() {

	    $sql = "SELECT * FROM school_list s"; 
        $query = $this->db->query($sql);

	    return $query;

	}
	function trainers($miles,$trainer) {
        if(is_null($trainer)):
	        $sql = "SELECT * FROM trainers"; 
            $query = $this->db->query($sql);
        else:
            $sql = "SELECT * FROM trainers WHERE id = ?"; 
            $query = $this->db->query($sql,array($trainer));
        endif;
        
        $schools = array();
        $count = 0;
        foreach($query->result() AS $row):
            $schools[$count] = array('name' => $row->Name,'lat' => $row->Lat,'lng' => $row->Long,'schools' => array());
            $schools[$count]['schools'] = $this->get_closest_schools($row->Lat,$row->Long,$miles)->result();
            
            $count++;
        endforeach;
        
        
	    return $schools;

	}
	function get_closest_schools($lat,$lng,$miles) {

	    $sql = 'SELECT s.*, f.y2010, f.y2011, f.ADDRESS as address, f.TOWNMAIL as town, f.ZIP as zip,f.PHONE as phone, haversine(s.lat,s.lng,?, ?,"MILES") as distance FROM school_list s LEFT JOIN fwni_data f ON f.School_code = s.school_id WHERE (y2011 = 0 OR y2011 IS NULL) HAVING distance < ? ORDER BY distance ASC'; 
        $query = $this->db->query($sql,array($lat,$lng,$miles));

	    return $query;

	}
	function fwni_schools() {

	    $sql = 'SELECT f.`SCHLNAME` as school_name,f.School_code, s.school_id, s.total_enrollment, s.meet_or_exceeds, f.`Lat` as lat, f.`Lon` as lng, f.y2010, f.y2011, f.ADDRESS as address, f.TOWNMAIL as town, f.ZIP as zip,f.PHONE as phone,  trainers.id as trainer_id, trainers.name as trainer_name FROM fwni_data f LEFT JOIN school_list s ON f.School_code = s.school_id LEFT JOIN coord ON coord.school_code = f.School_code LEFT JOIN trainers ON coord.trainer_id = trainers.id WHERE (y2011 = 1)'; 
        $query = $this->db->query($sql);

	    return $query;

	}
	function trainers_schools($trainer_id) {

	    $sql = 'SELECT f.`SCHLNAME` as school_name,f.School_code, s.school_id, s.total_enrollment, s.meet_or_exceeds, f.`Lat` as lat, f.`Lon` as lng, f.y2010, f.y2011, f.ADDRESS as address, f.TOWNMAIL as town, f.ZIP as zip,f.PHONE as phone,  trainers.id as trainer_id, trainers.name as trainer_name FROM fwni_data f LEFT JOIN school_list s ON f.School_code = s.school_id LEFT JOIN coord ON coord.school_code = f.School_code LEFT JOIN trainers ON coord.trainer_id = trainers.id WHERE (y2011 = 1) and trainer_id = ?'; 
        $query = $this->db->query($sql, array($trainer_id));

	    return $query;

	}
	function non_fwni_near($lat,$lng,$enrollment,$miles) {
	    
        $sql = 'SELECT s.*, f.School_code, s.school_id, f.y2010, f.y2011, f.ADDRESS as address, f.TOWNMAIL as town, f.ZIP as zip,f.PHONE as phone, haversine(s.lat,s.lng,'.$lat.', '.$lng.',"MILES") as distance FROM school_list s LEFT JOIN fwni_data f ON f.School_code = s.school_id WHERE total_enrollment < '.$enrollment.'  HAVING (distance < '.$miles.' and distance > .1) ORDER BY distance ASC'; 
        $query = $this->db->query($sql);
        
	    return $query;

	}
	function groupings($miles,$trainer_id,$enrollment = 250) {
	    
	    $fwni_schools = $this->map->trainers_schools($trainer_id);
        
        $fwni_lists = array();
        
        $count = 0;
        
            foreach($fwni_schools->result_array() as $s):

                $subarray = $this->non_fwni_near($s['lat'],(-$s['lng']),$enrollment,$miles);
                if(count($subarray->result_array()) > 0):
                    $fwni_lists[$count] =  $s;
                
                    $fwni_lists[$count]['near'] = $subarray->result_array();
                    $count++;
                endif;
            endforeach;
       return $fwni_lists;
       
	}
	function grouping_all($miles) {
	    
	    $fwni_schools = $this->map->fwni_schools();

        $fwni_lists = array();
        
        $count = 0;
        
            foreach($fwni_schools->result_array() as $s):
            

                $subarray = $this->non_fwni_near($s['lat'],(-$s['lng']),250,$miles);
                
                if(count($subarray->result_array()) > 0):
                    $fwni_lists[$count] =  $s;
                
                    $fwni_lists[$count]['near'] = $subarray->result_array();
                    $count++;
                endif;
                
            endforeach;
            
       return $fwni_lists;
       
	}
}