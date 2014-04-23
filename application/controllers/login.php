<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();  
        $this->load->library('session');
        $this->load->model('dbmodel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library("pagination");
      
 }

 public function registrationForm()
 {
     $this->load->library('session');
        $this->load->view('login/register');
 }
 
 public function register(){
     $this->load->library('form_validation');
                $this->form_validation->set_rules('userName', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('userFirstName', 'First name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('userLastName', 'Last name', 'trim|required|xss_clean');
                $this->form_validation->set_rules('userEmail', 'Email', 'trim|required|xss_clean');
                $this->form_validation->set_rules('userPass', 'Password', 'trim|required|xss_clean|md5|callback_check_database');
                if($this->form_validation->run() == FALSE)
                     {
                        $this->registrationForm();
                     }
                else
                {                  
            $user_name = $this->input->post('userName');
            $userfname = $this->input->post('userFirstName');   
            $userlname = $this->input->post('userLastName');
            $useremail = $this->input->post('userEmail');
            $userpass = $this->input->post('userPass');
             
            $this->dbmodel->add_new_user($user_name, $userfname, $userlname, $useremail, $userpass);
            
            echo '<h3>Hurray! Successfully Regisered</h3>';
                }
                
 }
 
 public function loginForm()
 {
     $this->load->library('session');
     if(!$this->session->userdata('logged_in'))
     {
        $this->load->view('login/login');
     }
     else{
         
     }
 }
 
 public function validate_user()
     
{$this->load->library('session');
    if(isset($_POST['checkMe']))
    {
    
   $this->session->sess_expiration = 60*60*24*7;
   $this->session->sess_expire_on_close = FALSE;
   
}
else
{
   $this->session->sess_expiration = 60*60;
   $this->session->sess_expire_on_close = FALSE;
}  
   
                $this->load->library('form_validation');
                $this->form_validation->set_rules('userEmail', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('userPass', 'Password', 'trim|required|xss_clean|md5|callback_check_database');
                if($this->form_validation->run() == FALSE)
                     {
                        $this->loginForm();
                       
                     }
                else
                    {
                    
                $email= $this->input->post('userEmail');
                $pass= $this->input->post('userPass');
		
		$query = $this->dbmodel->validate($email, $pass);
		if($query) // if the user's credentials validated...   
		{
			$data = array(
				'username' => $this->input->post('userEmail'),
				'logged_in' => true);
			echo'<h3>Hurray Login sucessful</h3>';
			
		}
		else // incorrect username or password
                    {
                        $this->session->set_flashdata('message', 'Username or password incorrect');
                       redirect('login/loginForm');
                        
                    }
                    }
	}
 
 public function forgotPassword(){
        $this->load->view('login/forgotPassword');            
   
       
    }
 
 
 
 
 
}