<?php
require_once 'controller.php';
require_once 'validation.php';
class Users extends Controller
{
    public function __construct()
    {

        echo "<h1>inside users controller construct</h1>";
    }
    function index()
    {

        echo "<h1>index of users</h1>";
    }
    function show($id)
    {


        $user = $this->model('user');
        $userName = $user->select($id);
        $this->view('user_view', $userName);
    }

    function add_user()
    {
        if(isset($_POST['submit']))
        {
            $userName=$_POST['name'];
            $password=$_POST['password'];
            $password2=$_POST['retype_password'];
            $email=$_POST['email'];
            if (isset($_POST['checkBox'])) {
                $check = true ;
            }
            else {
                $check = 0 ;
            }

            $validation = new Validation($userName,$password,$password2,$email , $check );

           //check not Null 
           if ($validation->checkNull()) 
           { 
               //check email
                if ($validation->checkEmail()){
                   // check password
                   if ($validation->checkPass()){
                       // check length
                       if ($validation->checkLength()){
                           // check Remember Me 
                           if ($validation->checkRequired())
                           {
                               //   NOW WE WILL INSERT DATA TO DB
                               $user_data =array(
                                'name'=>$userName,
                                'password'=>md5($password),
                                'email'=>$email
                            );
                            $u=$this->model('user');
                            $message="";

                            if(strcmp($user_data , $u->select()) == 0 ){
                               // print_r($user_data);
                                // print_r($u->select());
                                // Here I want to check if user is unique in DB But there is a small mistake in strcmp :3 >> I'm gonna search it in another time 
                                $type='danger';
                                 $message=" There are Same Data in DB !!";
                                 $this->view('feedback',array('type'=>$type,'message'=>$message));
                             }
                             else{
                                $u->insert($user_data) ;
                                $type='success';
                                 $message="USER CREATED SUCCESSFULLY ^_^ ";
                                 $this->view('feedback',array('type'=>$type,'message'=>$message));
                             }
                           }

                           else {
                            $type='danger';
                            $message="We have to remember your data.";
                        
                            $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));
                           }
                       }
                       else {
                        $type='danger';
                        $message="enter correct data !!";
                    
                        $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));
                       }
                   }
                   
                   else {
                    $type='danger';
                    $message="enter correct data !!";
                
                    $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));
                   }
                }
                else 
                { 
                    $type='danger';
                    $message="Email is not correct !!";
                
                    $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));
                 }
            } 
            else 
           { 
            $type='danger';
            $message="values can not be null";
        
            $this->view('register',array('type'=>$type,'message'=>$message,'form_values'=>$_POST));
            }


        }
        
    }
    function register()
    {
        $this->view('register');
    }

    function list_all()
    { $users=$this->model("user");
        $result=$users->select();
        $this->view('users_table',$result);

    }
    function status($id){
    $user=$this->model("user");
        $user->changeStatus($id);
        $this->list_all();

//        header('location:users/list_all');


        
    }
}
