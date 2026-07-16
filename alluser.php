<?php 
include('header.php');
include('config/db.php');
$stmt = $conn->prepare("SELECT id, name, email, description, experience,
 project, image_name, image_url FROM users WHERE 1");
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

?>
<div class = "container">
    <div class = "card col-md-8 mx-auto mt-3">
        <div class = "card-header">
            <h3 class="text-center">All Users</h3>
        </div>
        <div class = "card-body">
            <table class="table">
                <thead>
                    
                        <th>SL</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                        
                <tbody>

                    <?php
                     foreach($users as $key=>$user){ ?>    
                    <tr>
                        <td> <?=  ++$key ?> </td>
                        <td>
                            <img src=" <?= $user['image_url'] ?> " alt="" height="50px" width="50px"
                             class = "rounded-circle">
                    </td>
                        <td> <?= $user['name'] ?> </td>
                        <td> <?= $user['email'] ?> </td>
                        
                        <td>
                            <div class="btn btn-group">
                                <a href="" class="btn btn-sm btn-primary">View</a>
                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                <a href="" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                         </td>
                    </tr>

                    <?php } 
                    ?>