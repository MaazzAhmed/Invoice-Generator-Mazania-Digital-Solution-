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
                                                <table id="invoiceTable" class="datatable-init-export nowrap table" data-export-title="Export">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Client Name</th>
                                                            <th>Client Email</th>

                                                            <th>View Invoice</th>
                                                            <th>Created Date</th>
                                                            <th>Send Email</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        $sql = "SELECT * FROM invoices ORDER BY id DESC";
                                                        $result = $conn->query($sql);

                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td class='mt-4'>" . $row['id'] . "</td>";
                                                            echo "<td class='mt-4'>" . htmlspecialchars($row['client_name']) . "</td>";
                                                            echo "<td class='mt-4'>" . htmlspecialchars($row['client_email']) . "</td>";
                                                            
                                                            // Display the PDF file as a thumbnail image or a link
                                                            echo "<td> <a href='" . htmlspecialchars($row['pdf_path']) . "' target='_blank'>
                                                                  Open Invoice </a></td>";
                                                                  

                                                            echo "<td class='mt-4'>" . date('d-M-Y', strtotime($row['created_at'])) . "</td>";
                                                            
                                                            // Send email link with ID parameter
                                                            echo "<td class='mt-4'><a href='#' class='open-invoice' data-invoice-id=" .$row['id']."'>Send Email</a></td>";
                                                            echo "</tr>";
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

                <div class="modal fade" id="emailConfirmationModal" tabindex="-1" aria-labelledby="emailConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailConfirmationModalLabel">Confirm Email Send</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send this email?</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="additionalRecipientCheckbox">
                    <label class="form-check-label" for="additionalRecipientCheckbox">
                        Send to an additional email address
                    </label>
                </div>
                <input type="email" id="additionalEmail" class="form-control mt-3" placeholder="Enter additional email" style="display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmSendEmail" class="btn btn-primary">Yes, Send Email</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Modal and Send Email via AJAX -->
<script>
// Open modal on "Send Email" link click
document.querySelectorAll('.open-invoice').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const invoiceId = this.getAttribute('data-invoice-id');
        document.getElementById('confirmSendEmail').setAttribute('data-invoice-id', invoiceId);
        new bootstrap.Modal(document.getElementById('emailConfirmationModal')).show();
    });
});

// Show/hide additional email input based on checkbox
document.getElementById('additionalRecipientCheckbox').addEventListener('change', function() {
    const additionalEmailInput = document.getElementById('additionalEmail');
    additionalEmailInput.style.display = this.checked ? 'block' : 'none';
});

// Confirm send and make AJAX call
document.getElementById('confirmSendEmail').addEventListener('click', async function() {
    const invoiceId = this.getAttribute('data-invoice-id');
    const additionalEmail = document.getElementById('additionalRecipientCheckbox').checked ?
        document.getElementById('additionalEmail').value : '';

    // Disable the "Yes, Send Email" button and show a loading message
    this.disabled = true;
    this.textContent = "Sending...";

    try {
        const response = await fetch(`main_components/email_sender.php?id=${invoiceId}&additionalEmail=${additionalEmail}`, {
            method: 'GET'
        });
        
        const responseText = await response.text();
        console.log("Server response:", responseText);

        // Show success alert with SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Email Sent!',
            text: 'The email was sent successfully.',
            confirmButtonText: 'OK'
        }).then(() => {
            // Reload the page or perform another action after success
            window.location.reload();
        });
    } catch (error) {
        console.error("Error sending email:", error);
        // Show error alert with SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Email Failed!',
            text: 'There was an error sending the email. Please try again.',
            confirmButtonText: 'OK'
        });
    } finally {
        // Re-enable the button and reset text
        this.disabled = false;
        this.textContent = "Yes, Send Email";
    }
});
</script>
<script>
$(document).ready(function() {
    setTimeout(function() {
        if ($.fn.DataTable.isDataTable('#invoiceTable')) {
            $('#invoiceTable').DataTable().destroy();
        }
        
        $('#invoiceTable').DataTable({
            "order": [[0, "desc"]],
            "destroy": true,
            "responsive": true

        });
    }, 100); // Delay of 100 ms
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

$status = isset($_SESSION['invoice_creation_status']) ? $_SESSION['invoice_creation_status'] : null;
$message = isset($_SESSION['invoice_creation_message']) ? $_SESSION['invoice_creation_message'] : null;

unset($_SESSION['invoice_creation_status']);
unset($_SESSION['invoice_creation_message']);
?>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            // PHP variables to JavaScript
            let status = "<?php echo $status; ?>";
            let message = "<?php echo $message; ?>";

            // Check if status exists and show SweetAlert
            if (status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: message,
                });
            } else if (status === "error") {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: message,
                });
            }
        });
    </script>

     
 <?php require_once("./main_components/footer.php") ?>