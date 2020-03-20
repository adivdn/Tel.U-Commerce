<?php
    Class User_model extends CI_Model{

        public function create($data){
            $this->db->insert('user', $data);
        }

        public function login($email,$password){

            return $this->db->get_where('user',array('email' => $email,'password' => md5($password)));

            
        }

        public function lupa($email,$memes){
            return $this->db->get_where('user',array('email' => $email, 'memes' => $memes));
        }
        
        public function update_password($query,$password){
            $this->db->where(array('user_id' => $query['user_id']));
            $this->db->update('user', array('password' => md5($password)));
        }
    }



?>