<?php require_once("./main_components/header.php") ?>
<style>
   @media (min-width: 992px) { /* Large screens (desktop and above) ke liye */
    .dataTables_filter {
        padding-left: 150px !important;
    }
    div#invoiceTable_paginate {
        padding-left: 318px !important;
    }
}

#invoiceTable {
    /* width: 100%; */
    border-collapse: collapse; /* Borders ko properly set karein */
}

@media (max-width: 768px) {
    #invoiceTable {
        display: block; /* Table ko block element banaiye */
        overflow-x: auto; /* Horizontal scroll enable karein */
        white-space: nowrap; /* Text ko wrap hone se rokein */
    }
    #invoiceTable_filter{
        margin-top: 5px;
    }
}

</style>

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
                                            <div class="nk-block-head-sub"><a class="back-to" href="./"><em class="icon ni ni-arrow-left"></em><span>Dashboard</span></a>
                                            </div>
                                            <h2 class="nk-block-title fw-normal">All Created Invoices</h2>

                                        </div>
                                    </div>

                                    <div class="nk-block nk-block-lg">

                                        <div class="card card-bordered card-preview">
                                            <div class="card-inner">
                                            <?php

if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success alert-icon'>
            <em class='icon ni ni-check-circle'></em>
            <strong>{$_SESSION['success']}</strong>
          </div>";
    unset($_SESSION['success']); // Clear success message
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger alert-icon'>
            <em class='icon ni ni-cross-circle'></em>
            <strong>{$_SESSION['error']}</strong>
          </div>";
    unset($_SESSION['error']); // Clear error message
}
?>


                                           <?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-icon"><em class="icon ni ni-cross-circle"></em>
        <strong><?php echo $error; ?> </strong>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success alert-icon"><em class="icon ni ni-cross-circle"></em>
        <strong><?php echo $success; ?> </strong>
    </div>
<?php endif; ?>

                                
                                                <table id="invoiceTable" class="datatable-init-export nowrap table" data-export-title="Export">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Client Name</th>
                                                            <th>Client Email</th>

                                                            <th>Edit</th>
                                                            <th>Delete</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php
require_once 'main_components/configuration.php';

$sql = "SELECT DISTINCT client_email, client_name, id, created_at FROM invoices GROUP BY client_email ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='mt-4'>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td class='mt-4'>" . htmlspecialchars($row['client_name']) . "</td>";
        echo "<td class='mt-4'>" . htmlspecialchars($row['client_email']) . "</td>";

        // Edit button form
        echo "<td>
                <form method='post' action='edit-client'>
                    <input type='hidden' name='clientemail' value='" . htmlspecialchars($row['client_email']) . "'>
                    <button type='submit' name='edit_client' class='btn btn-warning'>Edit</button>
                </form>
              </td>";

        // Delete button form
      echo "<td>
        <form method='post' onsubmit=\"return confirm('Are you sure you want to delete?');\">
            <input type='hidden' name='clientemail' value='" . htmlspecialchars($row['client_email']) . "'>
            <input type='hidden' name='access_token' value='123'>
            <button type='submit' name='delete_client' class='btn btn-danger'>Delete</button>
        </form>
      </td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No invoices found</td></tr>";
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

              
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
    setTimeout(function() {
        if ($.fn.DataTable.isDataTable('#invoiceTable')) {
            $('#invoiceTable').DataTable().destroy();
        }
        
        $('#invoiceTable').DataTable({
            "order": [[0, "desc"]],
            "destroy": true,

        });
    }, 100); // Delay of 100 ms
});

</script>
 <?php require_once("./main_components/footer.php") ?>