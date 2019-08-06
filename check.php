
<?php
if(isset($success[0])){ print_r($success[0]); exit();}

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!------ Include the above in your HEAD tag ---------->

<div class="container">
     
             
                   <form method="post" action="<?php echo base_url("Login/checkpassword");?>" id="myform">
                   	
                     
                         <div class="form-group">
                            <label class="col-md-4 control-label">Username</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
          <input id="fullName" data-validation="required" name="username" placeholder="Full Name" class="form-control" required="true"  type="text" value=""></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="password" data-validation="required" name="password" placeholder="password" class="form-control" required="true" value="" type="text"></div>
                            </div>
                         </div>
                         <p style="color:red;"><?php if(isset($errors[0])){ echo $errors[0]; } ?></p>

                          <center><div class="input-group">
                                <br>  <input id="submit" name="submit"  class="form-control btn btn-success" required="true"  type="submit" >&nbsp;&nbsp;</div></center>
                                <p style="color:green;"><?php if(isset($success[0])){ echo $success[0]; } ?></p>
</form>
</div>