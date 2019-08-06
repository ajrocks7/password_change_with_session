<?php 
class Login_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->library('Password');
    }
   
    public function viewdetails()
    {
        $con="status!=2";
        return $this->db->select('*')->from('basicdetails')->where($con)->get()->result();
    }

    public function insertdata($data=array())
    {
        
        $basicdetails['details']['fname'] = $data['fullName'];
          $basicdetails['details']['address1'] = $data['addressLine1'];
             $basicdetails['details']['email'] = $data['email'];
             $basicdetails['details']['phoneNumber'] = $data['phoneNumber'];
          $this->db->insert('basicdetails',$basicdetails['details']);
          $affected_rows = $this->db->affected_rows();
                if($affected_rows == 1){
                        return $this->db->insert_id();
                } else {
                        return;
                }
            }
    
           public function updatedata($data=array(),$id)
           {
             $basicdetails['details']['fname'] = $data['fullName'];
          $basicdetails['details']['address1'] = $data['addressLine1'];
             $basicdetails['details']['email'] = $data['email'];
             $basicdetails['details']['phoneNumber'] = $data['phoneNumber'];
             $this->db->where("id",$id);
          $this->db->update('basicdetails',$basicdetails['details']);
           } 

    public function editdata($id)
    {
        return $this->db->select('*')->from('basicdetails')->where('id',$id)->get()->row();
    }

   public function delete($id)
   {
    $this->db->where("id",$id);
   $res =  $this->db->update("basicdetails",array("status"=>2));
   if($res)
   {
    return 1;
   }else{
    return 2;
   }
   }


   public function getdetails()
   {
    $tr="";
    $con="status!=2";
    $details  = $this->db->select('*')->from('basicdetails')->where($con)->get()->result();
    foreach($details as $det)
    {
    $tr.='<tr id="hidedat'.$det->id.'">
    <td>'.$det->fname.'</td>
    <td>'.$det->address1.'</td>
    <td>'.$det->email.'</td>
    <td>'.$det->phoneNumber.'</td>
    <td><button type="button" class="btn btn-info btn-xs open-AddBookDialog" data-id='.$det->id.' data-toggle="modal" data-target="#myModal">Edit</button></td>
    <td><button type="button" class="btn btn-danger btn-xs" id="delete'.$det->id.'" onclick="deletedata('.$det->id.')">Delete</button></td>
    </tr>';
    }
    return array("values"=>$tr);

   }

   public function geteditdetails($id)
   {
    $tr="";
    $con="id='$id'";
    $details  = $this->db->select('*')->from('basicdetails')->where($con)->get()->result();
    foreach($details as $det)
    {
    $tr.='<form id="editform"><tr>
    <td><input type="hidden" id="editval" value="'.$det->id.'"></td>
    <td><input id="fullName" data-validation="required" name="fullName" placeholder="Full Name" class="form-control" required="true"  type="text" value="'.$det->fname.'"></td>
    <td><input id="addressLine1" data-validation="required" name="addressLine1" placeholder="Address Line 1" class="form-control" required="true" value="'.$det->address1.'" type="text"></td>
    <td><input id="email" data-validation="email" name="email" placeholder="Email" class="form-control" required="true" value="'.$det->email.'" type="text"></td>
    <td><input id="phoneNumber" data-validation="number" name="phoneNumber" placeholder="Phone Number" class="form-control" required="true" value="'.$det->phoneNumber.'" type="text"></td>
    <td><button type="button" class="btn btn-success btn-xs" onclick=updatedata('.$det->id.')>Update</button></td>
    </tr></form>';
    }
    return array("values"=>$tr);

   }
   

   public function savedynamic($data = array())
   {
    $count = count($data['name']);
    for($i=0;$i<$count;$i++)
    {
         $details['dynamic']['name'] = $data['name'][$i];
         $details['dynamic']['addr1'] = $data['addr1'][$i];
         $details['dynamic']['addr2'] = $data['addr2'][$i];
         $details['dynamic']['email'] = $data['email'][$i];
         $details['dynamic']['contact'] = $data['contact'][$i];
         $this->db->insert('extradetails',$details['dynamic']);
    }
   }

   public function generatepasswordforadmin()
   {
    $password =substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
    $hashToStoreInDb = password_hash($password, PASSWORD_BCRYPT);
    $isPasswordCorrect = password_verify($password, $hashToStoreInDb);
    if($isPasswordCorrect)
    {
      $details['login']['password'] = $hashToStoreInDb;
      $details['login']['dummypass'] = $password;
      $details['login']['userrole'] = "Admin";
      $details['login']['usertype'] = "1";
       $this->db->insert('login',$details['login']);
    }
   }

   public function generatepasswordforuser()
   {
    $password =substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
    $hashToStoreInDb = password_hash($password, PASSWORD_BCRYPT);
    $isPasswordCorrect = password_verify($password, $hashToStoreInDb);
    if($isPasswordCorrect)
    {
      $details['login']['password'] = $hashToStoreInDb;
      $details['login']['dummypass'] = $password;
      $details['login']['userrole'] = "User";
      $details['login']['usertype'] = "2";
       $this->db->insert('login',$details['login']);
    }
   }

   public function checklogin($data = array(),$set_session = true)
   {
    $typedpassword = trim($data['password']);
    $username = trim($data['username']);
    $getdetails = $this->db->select('*')->from('login')->where('userrole',$username)->get()->row();

    $dbpasssword = $getdetails->password;

    $validate_password = password_verify($typedpassword, $dbpasssword);
     
    if($validate_password)
    { 
         if ($set_session) {
                    $userdata = $getdetails;
                    $user_data = array("user_role" => $userdata->userrole, "user_type" =>$userdata->usertype);
                    $this->phpsession->save($user_data);
                }
       return 1;
    }else{
        return 2;
    }
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
