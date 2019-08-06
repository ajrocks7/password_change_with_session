<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->

<div class="container">
     
             
                   <form method="post" action="<?php echo base_url("Login/passwordconfirm");?>" id="myform">
                   	
                     <input type="hidden" name="userrole" id="userrole" value="<?php echo $this->phpsession->get('user_role');?>">
                         <div class="form-group">
                            <label class="col-md-4 control-label">Old Password</label>
                           
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input id="oldp" data-validation="required" name="oldpass" onchange="getoldpass(this.value)" placeholder="oldpass" class="form-control" required="true"  type="text" value=""></div>
                          
                         </div>
<p style="color:red;display:none;" id="error">Password entered is wrong</p>

                        <div class="form-group">
                            <label class="col-md-4 control-label">New Password</label>
                         
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="newpass" data-validation="required" name="newpass" placeholder="new pass" class="form-control" required="true" value="" type="text"></div>
                            </div>
                       

                         <div class="form-group">
                            <label class="col-md-4 control-label">Confirm Password</label>
                        
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="confirmpass" data-validation="required" onchange="confirmpasswrd(this.value)" name="confirmpass" placeholder="password" class="form-control" required="true" value="" type="text"></div>
                          
                         </div>
                    <p id="cmppass" style="color:red;display:none;">Passwords do not match</p>
                        
                          <center><div class="input-group">
                                <br>  <input id="submit" name="submit"  class="form-control btn btn-success" required="true"  type="submit" >&nbsp;&nbsp;</div></center>
</form>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
function getoldpass(val)
{
  var role = $("#userrole").val();
$.ajax({
type:'POST',
url:'<?php echo base_url();?>Login/oldpasscheck',
data:{
  vals:val,
  role:role,
},
success:function(data){
if(data == 1)
{
$("#oldp").val();
$("#error").hide();
}else if(data == 2)
{
$("#oldp").val(' ');
$("#error").show();
}
},
});
}

function confirmpasswrd(val)
{
  var confirmpass = val;
  var newpass = $("#newpass").val();
  if(confirmpass == newpass)
  {
$("#cmppass").hide();
  }else{
$("#cmppass").show();
$("#newpass").val(' ');
$("#confirmpass").val(' ');
  }
}

 </script> 