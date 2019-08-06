<?php 
class Login_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Password');
    }
   
   
   public function checkoldpass($oldpass,$role)
   {
    $con ="userrole='$role' and dummypass='$oldpass'";
    $query = $this->db->select('*')->from('login')->where($con)->get();
    if($query->num_rows() >0)
    {
       return 1; 
      }else{
        return 2;
      }
    }

    public function confirmpassword($password,$role)
    {

        $hashToStoreInDb = password_hash($password, PASSWORD_BCRYPT);
        $isPasswordCorrect = password_verify($password, $hashToStoreInDb);
        if($isPasswordCorrect){
        $this->db->where('userrole',$role);
        $this->db->update('login',array('password'=>$hashToStoreInDb,'dummypass'=>$password));
        return 1;
        }
    }


}
