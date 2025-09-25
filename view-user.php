<?php require_once("./main_components/header.php") ?>


<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <?php require_once("./main_components/sidebar.php"); ?>
            <div class="nk-wrap ">
                <?php require_once("./main_components/navbar.php") ?>

                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="components-preview wide-md mx-auto">
                                    <div class="nk-block-head nk-block-head-lg wide-sm">
                                        <div class="nk-block-head-content">
                                            <div class="nk-block-head-sub"><a class="back-to" href="./"><em
                                                        class="icon ni ni-arrow-left"></em><span>Dashboard</span></a>
                                            </div>
                                            <h2 class="nk-block-title fw-normal">All Users</h2>

                                        </div>
                                    </div>

                                    <div class="nk-block nk-block-lg">

                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                                <table class="datatable-init-export nowrap table"
                                                    data-export-title="Export">
                                                    <thead>
                                                        <tr>
                                                            <th>User ID</th>
                                                            <th>Username</th>
                                                            <th>User Email</th>
                                                            <!-- <th>User Role</th> -->
                                                            <th>Edit</th>
                                                            <th>Delete</th>
                                                          

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php

                                                        $sql = "SELECT * FROM users";
                                                        $result = $conn->query($sql);


                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td>" . $row['id'] . "</td>";
                                                            echo "<td>" . $row['full_name'] . "</td>";
                                                            echo "<td>" . $row['email'] . "</td>";

                                                            
                                                            if($row['email'] == "support@gogrades.org") {
                                                          echo "<td>You Can't Edit OR Delete The Admin User</td>";
                                                       }
                                                       else {
                                                       
                                                                $user_id = $row['id'];
                                                                $password = $row['password'];
                                                                echo "<td><form method='post' action='edit-user'>
                                                                <input type='hidden' name='user_id' value='$user_id'>
                                                                <button type='submit' name='edit_user' class='btn btn-warning'>Edit</button>
                                                                </form>" . '</td>';

                                                                echo "<td><form method='post' action='delete_user'>
                                                                <input type='hidden' name='user_id' value='$user_id'>
                                                                <input type='hidden' name='access_token' value='123'>
                                                                <button type='submit' name='delete_user' class='btn btn-danger'>Delete</button>
                                                                </form>" . '</td>';

                                                                echo "</tr>";
                                                       }
                                                       
                                                               
                                                            }


                                                     
                                                        ?>



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require_once("./main_components/footer.php") ?>