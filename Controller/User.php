<?php

    Class User extends CI_Controller{
        public function __construct(){

            parent ::__construct();

            $this->load->model('User_model');

        }
        public function index(){
             //tunggu front end
            //$this->load->view('coba');
        }

        public function login(){
            if($this->session->userdata('logged_in')){
                if($dataLogin['level'] == 'admin'){
                    //redirect(base_url('admin'));
                }else{
                    
                }
            }
        }
        public function register(){
            //tunggu front end
            //$this->load->view('register');
        }
        public function Lupa(){
            //nunggu front end duls
            //$this->load->view('reset');
        }
        public function prosesRegister(){
            if($this->session->userdata('logged_in')){
                //redirect();
            }
            $this->form_validation->set_rules('nama','Full Name','required');
            $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('memes','Favorite Meme','required');
            $this->form_validation->set_rules('password','Password','required|min_length[6]');
            $this->form_validation->set_rules('konfirmasi_password','Konfirmasi Password','required|matches[password]');

            if($this->form_validation->run() == FALSE){

                //$this->register();
                
            }else{
                $password = $this->input->post('password');
                $md5 = md5($password);
                $dataRegister = [ 'user_id' => NULL,
                                  'level' => 'user',
                                  'nama'  => $this->input->post('nama'),
                                  'email' => $this->input->post('email'),
                                  'password' => $md5,
                                  'memes'   => $this->input->post('memes')
                                ];

                $this->User_model->create($dataRegister);

                $dataPesan = ['alert' => 'alert-success',
                              'pesan' => 'Akun berhasil dibuat'
                             ];
                
                $this->session->set_flashdata($dataPesan);
                 //file front end            
                //redirect('User/index');
            }

        }

        public function prosesLogin(){

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->User_model->login($email,$password)->row_array();
            if($user > 0){
                $dataLogin = array('user_id' => $user['user_id'],
                              'level'   => $user['level'],
                              'logged_in' => TRUE
                            );
                $this->session->set_userdata($dataLogin);

                if($this->session->userdata('level') == 'admin'){
                    //redirect(site_url('Admin'));
                }else{
                    //tunggu file front end
                    //redirect(site_url('Admin'));
                }
                
            }else{
                $dataPesan = ['alert' => 'alert-danger',
                              'pesan' => 'Email atau Password Anda salah'
                            ];
                $this->session->set_flashdata($dataPesan);
                //$this->login();
            }

            
        }
        
        public function lupaPassword(){
            $email = $this->input->post('email');
            $memes = $this->input->post('memes');

            $query = $this->User_model->lupa($email,$memes)->row_array();
            if($query > 0){
                $password = $this->input->post('password');
                
                $this->User_model->update_Password($query,$password);

                //redirect('User/index');
               
            }

        }

        public function logout(){
            $dataLogin = ['user_id','level','logged_in'];

            $this->session->unset_userdata($dataLogin);
            
            //redirect('user/index');
        }
    }



?>