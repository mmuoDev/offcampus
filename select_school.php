<?php
ob_start();
//session_start();
require_once "includes/header.php";
require_once "includes/admin_check.php";
//require_once "includes/manager_check.php";
require_once "db/db_handle.php";
?>
<title>Admin | Select School</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
              
            <form class="form-inline" role="form" method="get" action="agents_or_properties.php">
                        <div class="form-group"> 
                            <select class="form-control  input-lg form-size" name="school" placeholder="">
                                
                                <option value="Lagos State University">Lagos State University</option>
                                <option value="University of Lagos">University of Lagos</option>
                                <option value="Federal University of Technology, Owerri">Federal University of Technology, Owerri</option>
                            </select>
                        </div>
                        <div class="form-group"> 
                            <select class="form-control  input-lg form-size" name="category" placeholder="">         
                                <option value="agents">Agents</option>
                                <option value="properties">Properties</option>
                                <option value="roommates">Roommates</option>
                                <option value="requests">Accommodation Requests</option>
                            </select>
                        </div>
                       
                        <div class="form-group">
                            <div class="text-center">
                                <input type="submit" name="submit" value="GO" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </form>
               
            
        </div>
    </div>
</div>


