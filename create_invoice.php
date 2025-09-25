<?php require_once("./main_components/header.php") ?>

<style>
   input[type="file"] {

      display: inline-block !important;

      width: auto !important;

   }
</style>



<body class="nk-body bg-lighter npc-default has-sidebar ">

   <div class="nk-app-root">

      <div class="nk-main ">

         <?php require_once("./main_components/sidebar.php") ?>



         <div class="nk-wrap ">

            <?php require_once("./main_components/navbar.php") ?>



            <div class="nk-content ">

               <div class="container-fluid">

                  <div class="nk-content-inner">

                     <div class="nk-content-body">

                        <!-- <div class="nk-block-head nk-block-head-sm">

                           <div class="nk-block-between">

                              <div class="nk-block-head-content">

                                 <h3 class="nk-block-title page-title">Dashboard</h3>

                              </div>



                           </div>

                        </div> -->





                        <div class="nk-block">

                           <div class="row g-gs" style="padding : 20px;">



                              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"

                                 integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="

                                 crossorigin="anonymous" referrerpolicy="no-referrer" />

                              <link rel="preconnect" href="https://fonts.googleapis.com">

                              <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

                              <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

                              <link rel="stylesheet" href="invoice.css">

                              <link rel="stylesheet" href="media.css">

                              <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"> </script>

                              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



                              <?php

                              $logoPath = 'logo/weblogo.png';



                              ?>



                              <button type="button" id="clear-form-btn">Clear Form</button>

                              <div class="Invoice">



                                 <?php if (isset($_SESSION['invoice_creation_status']) && $_SESSION['invoice_creation_status'] === 'error'): ?>

                                    <div class="error-message alert alert-danger">

                                       <?= htmlspecialchars($_SESSION['invoice_creation_message']) ?>

                                    </div>

                                 <?php

                                    unset($_SESSION['invoice_creation_status'], $_SESSION['invoice_creation_message']);

                                 endif; ?>

                                 <form id="invoiceForm" action="generated" method="post" enctype="multipart/form-data">

                                    <input type="hidden" name="invoice_html" id="invoice_html">

                                    <?php

                                    require_once 'main_components/configuration.php';



                                    $sql = "SELECT DISTINCT client_email, client_name, id FROM invoices GROUP BY client_email ORDER BY id DESC";

                                    $result = $conn->query($sql);



                                    $invoices = [];

                                    if ($result->num_rows > 0) {

                                       while ($row = $result->fetch_assoc()) {

                                          $invoices[] = $row;
                                       }
                                    }

                                    ?>

                                    <div class="row  align-items-center mt-4 mb-3">

                                       <div class="col-md-4 mt-2">

                                          <select id="existingClients" class="form-select">

                                             <option value="">Select an existing client or enter new details</option>

                                             <?php foreach ($invoices as $invoice): ?>

                                                <option value="<?php echo $invoice['id']; ?>"

                                                   data-name="<?php echo $invoice['client_name']; ?>"

                                                   data-email="<?php echo $invoice['client_email']; ?>">

                                                   <?php echo htmlspecialchars($invoice['client_name']) . ' (' . htmlspecialchars($invoice['client_email']) . ')'; ?>

                                                </option>

                                             <?php endforeach; ?>

                                          </select>

                                       </div>

                                       <div class="col-md-4 mt-2">

                                          <input type="text" id="clientName" class="form-control" placeholder="Client Name" name="clientName" required>

                                       </div>

                                       <div class="col-md-4 mt-2">

                                          <input type="email" required id="clientEmail" class="form-control" placeholder="Client Email" name="clientEmail">

                                       </div>

                                    </div>





                                    <div class="container">

                                       <div class="row first-row">

                                          <div class="col-md-10">

                                             <div class="invoice-div" id="invoice_section">

                                                <div class="row align-items-end">

                                                   <div class="col-md-6 text-start">



                                                      <div class="col-md-4 mt-2">

                                                         <input type="file" id="logoUpload" class="form-control" name="logoUpload" accept="image/*" onchange="previewImage(event)">

                                                      </div>



                                                      <div class="Img-Invoice-Name d-flex align-items-center justify-content-between">

                                                         <img id="logo_img" style="width: 40%; object-fit: contain;" alt="logo_img" src="<?php echo isset($logoPath) ? $logoPath : ''; ?>">



                                                      </div>



                                                      <div class="d-flex justify-content-start gap-2 mt-2">

                                                         <textarea placeholder="Who is this invoice from? (required)" id="invoice-from" name="Invoice_From" oninput="saveTextarea(this)" rows="2" cols="40" required>Gogrades.org</textarea>

                                                      </div>

                                                      <div class="row pt-5 pt-sm-5 pt-md-5 pt-lg-4 pt-xl-0 pt-xxl-0 mt-4 mt-sm-4 mt-lg-4 mt-xl-4 mt-xxl-4">

                                                         <div class="col-md-6">

                                                            <div class="mt-1 d-flex flex-column ">

                                                               <input type="text" value="Bill To" id="bill-label" class="width-fit-content" oninput="saveLabel(this)" name="Billto-label">

                                                               <textarea placeholder="Who is this invoice to? (required)" id="invoice-to" oninput="saveTextarea(this)" rows="2" required cols="20" name="Bill_To">John William</textarea>

                                                            </div>

                                                         </div>

                                                         <div class="col-md-6">

                                                            <div class="mt-1 d-flex flex-column ">

                                                               <input type="text" value="Ship To" id="ship-label" class="width-fit-content" oninput="saveLabel(this)" name="shipto-label">

                                                               <textarea placeholder="(optional)" id="ship-to" oninput="saveTextarea(this)" rows="2" name="ship_to" cols="20">California, Usa</textarea>

                                                            </div>

                                                         </div>

                                                      </div>

                                                   </div>

                                                   <div class="col-md-6 text-end">

                                                      <div class="d-flex justify-content-end gap-2 mt-1">

                                                         <input type="text" value="Payment Invoice" name="inovoice-label" style="font-size: 20px; text-align: center;" id="Invoice-label" class="width-fit-content" oninput="saveLabel(this)">

                                                      </div>

                                                      <div class="d-flex justify-content-end mt-1 Invoice-No mt-4">

                                                         <span>#</span>

                                                         <input type="text" value="1" name="invoice-number" id="invoice-no-label" oninput="saveLabel(this)">

                                                      </div>

                                                      <div class="d-flex justify-content-end gap-2 mt-5">

                                                         <input type="text" value="Date" id="date-label" name="date-label" class="width-fit-content" oninput="saveLabel(this)">

                                                         <input type="date" name="date" id="date" oninput="price()">

                                                      </div>

                                                      <div class="d-flex justify-content-end gap-2 mt-1">

                                                         <input type="text" value="Payment Terms" name="paymentterms-label" id="payment-label" class="width-fit-content"

                                                            oninput="saveLabel(this)">

                                                         <input type="text" value="One Time" name="payment-terms" id="payment-input" oninput="saveLabel(this)">

                                                      </div>

                                                      <div class="d-flex justify-content-end gap-2 mt-1">

                                                         <input type="text" value="Due Date" id="due-date-label" name="due-date-label" class="width-fit-content" oninput="saveLabel(this)">

                                                         <input type="date" name="duedate" id="duedate" data-date="" data-date-format="DD MM YYYY" oninput="price()">

                                                      </div>

                                                      <div class="d-flex justify-content-end gap-2 mt-1">

                                                         <input type="text" value="PO Number" name="ponumber-label" id="po-label" class="width-fit-content" oninput="saveLabel(this)">
                                                         <?php
                                                         $po_number = '' . date('md-His') . '-' . rand(100, 999);

                                                         ?>
                                                         <input type="text" id="po-input" name="po-number" value="<?php echo $po_number ?>" oninput="saveLabel(this)">

                                                      </div>

                                                   </div>

                                                </div>

                                                <div class="append-table">

                                                   <div>

                                                      <input type="text" value="Item" name="itemlabel" id="item-label" class="width-fit-content text-black" oninput="saveLabel(this)">

                                                   </div>

                                                   <div>

                                                      <input type="text" value="Quantity" name="quantitylabel" id="quantity-label" class="width-fit-content text-black" oninput="saveLabel(this)">

                                                   </div>

                                                   <div>

                                                      <input type="text" value="Rate" id="rate-label" name="ratelabel" class="width-fit-content text-black" oninput="saveLabel(this)">

                                                   </div>

                                                   <div>

                                                      <input type="text" value="Amount" name="amountlabel" id="amount-label" class="width-fit-content text-black" oninput="saveLabel(this)">

                                                   </div>

                                                </div>

                                                <div id="append-container" class="append-container">

                                                   <div class="append" id="field-1">

                                                      <div>

                                                         <input data-id="1" type="text" name="item-des[]" id="item-des-1"

                                                            placeholder="Description of service or product..." value="Digital Services">

                                                      </div>

                                                      <div>

                                                         <input data-id="1" type="number" name="quantity[]" id="quantity-1" value="1" oninput="updatePrice(this)">

                                                      </div>

                                                      <div>

                                                         <span class="Rate">

                                                            <span class="currencySymbol"></span>

                                                            <input type="number" value="1" data-id="1" name="rate[]" id="rate-1" oninput="updatePrice(this)">

                                                         </span>

                                                      </div>

                                                      <p class="Amount"><span class="currencySymbol"></span>

                                                         <span class="amount" id="currency-1">0</span>

                                                      </p>

                                                      <i class="remove-btn icon ni ni-cross-round" data-id="1" onclick="removeLine(this)"></i>

                                                   </div>

                                                </div>



                                                <button id="append-btn">+ Line Item</button>



                                                <div class="row mt-4">

                                                   <div class="col-md-6">

                                                      <div class="mt-2 d-flex flex-column ">

                                                         <input type="text" value="Notes" name="notes-label" id="notes-label" class="width-fit-content" oninput="saveLabel(this)">

                                                         <textarea placeholder="Notes - any relevant information not already covered" id="notes" oninput="saveTextarea(this)" rows="2" cols="40" required="" name="notes">Please Pay This invoice with in a due date</textarea>

                                                      </div>

                                                      <div class="mt-3 d-flex flex-column ">

                                                         <input type="text" value="Terms" name="terms-label" id="terms-label" class="width-fit-content" oninput="saveLabel(this)">

                                                         <textarea placeholder="Terms and conditions - late fees, payment methods, delivery schedule" id="terms" oninput="saveTextarea(this)" rows="2" cols="40" required="" name="terms">This payment will not be refundable or adjustable in another invoice</textarea>

                                                      </div>





                                                      <div class="mt-2 d-flex flex-column ">

                                                         <label for="waterMark">Water Mark:</label>

                                                         <input type="file" id="watermarkUpload" class="form-control" name="watermarkUpload" accept="image/*" onchange="previewWatermark(event)">

                                                      </div>

                                                      <!-- The watermark image will change dynamically -->

                                                      <div class="mt-3 d-flex flex-column ">



                                                         <img id="watermark_img" style="width: 40%; object-fit: contain;" alt="watermark_img" src="<?php echo $logoPath ?>" />

                                                      </div>

                                                   </div>

                                                   <div class="col-md-6 text-end">

                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-1">

                                                         <input type="text" value="Subtotal" id="subtotal-label" class="width-fit-content">

                                                         <div>

                                                            <span class="currencySymbol"></span> <span id="subtotal">0.00</span>

                                                         </div>

                                                      </div>





                                                      <div class="toggleDiv">

                                                         <span class="justify-content-end align-items-center gap-2 mt-2" style="display: flex;" id="taxDiv">

                                                            <input type="text" value="Tax" name="taxlabel" id="tax-label" class="width-fit-content" oninput="saveLabel(this)">

                                                            <div>

                                                               <span class="Tax">

                                                                  <span class="currencySymbol">$</span>

                                                                  <input type="number" name="tax" id="tax" value="0" oninput="price()" onchange="price()">





                                                               </span>

                                                            </div>

                                                         </span>





                                                      </div>











                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-2">

                                                         <input type="text" value="Discount" id="balance-due-label" name="balancelabel" class="width-fit-content"

                                                            oninput="saveLabel(this)">

                                                         <div>

                                                            <input type="text" name="discount" id="discount" value="0" oninput="price()">

                                                         </div>

                                                      </div>



                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-2">

                                                         <input type="text" value="Total" id="total-label" class="width-fit-content">

                                                         <div>

                                                            <span class="currencySymbol"></span> <span id="total">0.00</span>

                                                         </div>

                                                      </div>

                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-2">

                                                         <input type="text" value="Amount Paid" id="amount-paid-label" class="width-fit-content"

                                                            oninput="saveLabel(this)" name="amountpaidlabel">

                                                         <span class="Paid">

                                                            <input type="number" name="amountpaid" id="paid" value="0" oninput="price()">

                                                            <span class="currencySymbol"></span>

                                                         </span>

                                                      </div>

                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-2">
                                                         <input type="text" value="Balance Due" id="balance-due-label" class="width-fit-content" name="balanceduelabel">
                                                         <div>
                                                            <span class="currencySymbol"></span> <span id="balancedue">0.00</span>
                                                         </div>
                                                      </div>



                                                      <div class="d-flex justify-content-end align-items-center gap-2 mt-2">

                                                         <input type="text" value="Pay Link" id="pay_link" class="width-fit-content" oninput="saveLabel(this)">

                                                         <div id="url_container">

                                                            <textarea type="text" name="url" id="urlTextarea" oninput="saveTextarea(this)"></textarea>

                                                         </div>



                                                      </div>



                                                   </div>

                                                </div>

                                                <footer>

                                                   <hr style="color: black !important;border-top: 4px solid !important;">

                                                   <div class="col-md-12">

                                                      <div class="mt-3 m-auto d-flex flex-column col-md-8">



                                                         <textarea class="text-center" name="footer" placeholder="Please pay the invoice before the due date. You can pay the invoice by logging in to your account from our client portal." id="footer_label" oninput="saveTextarea(this)" rows="2" required="" cols="20">© All Right Reserved | Gogrades.org <?php echo date('Y')?> | Official Invoice</textarea>

                                                      </div>

                                                   </div>

                                                </footer>

                                             </div>

                                          </div>







                                          <div class="col-md-2">

                                             <class="invoice-info">

                                                <div class="download-btn">

                                                   <button id="download_invoice" type="button" name="gen" disabled>

                                                      <i class="fa-solid fa-plus"></i> Create Invoice

                                                   </button>





                                                </div>

                                                <label for="currency"> Currency : </label><br>

                                                <select name="currency" id="currency" oninput="price()">



                                                   <option value="$" selected="selected" label="USD ($)">USD ($)</option>

                                                   <option value="€" label="EUR (€)">EUR (€)</option>

                                                   <option value="£" label="GBP (£)">GBP (£)</option>

                                                   <option value="₹" label="INR (₹)">INR (₹)</option>

                                                   <option value="¥" label="JPY (¥)">JPY (¥)</option>

                                                   <option value="A$" label="AUD (A$)">AUD (A$)</option>

                                                   <option value="C$" label="CAD (C$)">CAD (C$)</option>

                                                   <option value="CHF" label="CHF (CHF)">CHF (CHF)</option>

                                                   <option value="¥" label="CNY (¥)">CNY (¥)</option>

                                                   <option value="MX$" label="MXN (MX$)">MXN (MX$)</option>

                                                   <option value="R$" label="BRL (R$)">BRL (R$)</option>

                                                   <option value="NZ$" label="NZD (NZ$)">NZD (NZ$)</option>

                                                   <option value="R" label="ZAR (R)">ZAR (R)</option>

                                                   <option value="₹" label="INR (₹)">INR (₹)</option>

                                                   <option value="S$" label="SGD (S$)">SGD (S$)</option>

                                                   <option value="kr" label="SEK (kr)">SEK (kr)</option>

                                                   <option value="₩" label="KRW (₩)">KRW (₩)</option>

                                                   <option value="HK$" label="HKD (HK$)">HKD (HK$)</option>

                                                   <option value="د.إ" label="AED (د.إ)">AED (د.إ)</option>

                                                   <option value="₺" label="TRY (₺)">TRY (₺)</option>

                                                   <option value="zł" label="PLN (zł)">PLN (zł)</option>

                                                   <option value="Rp" label="IDR (Rp)">IDR (Rp)</option>

                                                   <option value="฿" label="THB (฿)">THB (฿)</option>

                                                   <option value="₽" label="RUB (₽)">RUB (₽)</option>

                                                   <option value="$" label="USD ($)">USD ($)</option>

                                                   <option value="USN" label="USN">USN</option>

                                                   <option value="UYI" label="UYI">UYI</option>





                                                </select>



                                                <label for="status"> Status: </label><br>

                                                <select name="status" id="status" onchange="toggleUrlField()">

                                                   <option disabled >Select Status</option>

                                                   <option selected value="paid">paid</option>

                                                   <option value="unpaid">unpaid</option>

                                                </select>









                                          </div>

                                       </div>







                                    </div>

                              </div>







                           </div>

                           </form>



                        </div>





                        <script src="script.js"></script>

                        <script type="text/javascript">
                           window.FontAwesomeConfig = {

                              autoReplaceSvg: false

                           }
                        </script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"

                           integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ=="

                           crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </div>

      <script>
         document.addEventListener('DOMContentLoaded', function() {

            const form = document.querySelector('form');

            const clientName = document.getElementById('clientName');

            const clientEmail = document.getElementById('clientEmail');

            const submitButton = document.getElementById('download_invoice');

            const billToField = document.getElementById('invoice-to');



            // Function to enable or disable the submit button based on input values

            function toggleSubmitButton() {

               const nameValue = clientName.value.trim();

               const emailValue = clientEmail.value.trim();

               submitButton.disabled = !(nameValue && emailValue); // Disable if either is empty

            }



            // Add input event listeners to trigger submit button enable/disable

            clientName.addEventListener('input', toggleSubmitButton);

            clientEmail.addEventListener('input', toggleSubmitButton);



            // Initial check in case the form is pre-filled

            toggleSubmitButton();



            // Automatically fill out client fields when dropdown changes

            document.getElementById('existingClients').addEventListener('change', function() {

               const selectedOption = this.options[this.selectedIndex];

               const selectedName = selectedOption.dataset.name || '';

               const selectedEmail = selectedOption.dataset.email || '';



               // Populate fields with the selected client's information

               clientName.value = selectedName;

               clientEmail.value = selectedEmail;



               // Update Bill To field with client name

               billToField.value = selectedName; // Automatically populate 'Bill To' with client name



               // Trigger the input event for validation

               clientName.dispatchEvent(new Event('input'));

               clientEmail.dispatchEvent(new Event('input'));

            });



            // Update the Bill To field with the client name when clientName changes manually

            clientName.addEventListener('input', function() {

               // Set Bill To with client name and ensure it doesn't get overwritten by email

               billToField.value = clientName.value.trim(); // Set Bill To with client name

            });



            // Submit the form on button click

            submitButton.addEventListener('click', function(e) {

               e.preventDefault(); // Prevent default submission



               const nameValue = clientName.value.trim();

               const emailValue = clientEmail.value.trim();



               if (!nameValue || !emailValue) {

                  alert('Please fill out both Client Name and Client Email fields.');

                  return; // Stop form submission

               }



               form.submit(); // Submit the form if validations pass

            });

         });
      </script>

      <script>
         function formatDate(date) {

            const year = date.getFullYear();

            const month = ('0' + (date.getMonth() + 1)).slice(-2); // Ensure 2 digits for month

            const day = ('0' + date.getDate()).slice(-2); // Ensure 2 digits for day

            return `${year}-${month}-${day}`;

         }



         window.onload = function() {

            const today = new Date();

            const pakistanOffset = 5 * 60; // Pakistan Standard Time (UTC +5 hours)

            today.setMinutes(today.getMinutes() + today.getTimezoneOffset() + pakistanOffset); // Adjust for Pakistan time



            const tomorrow = new Date(today);

            tomorrow.setDate(today.getDate() + 1); // Set due date to one day after



            document.getElementById('date').value = formatDate(today); // Set today's date

            document.getElementById('duedate').value = formatDate(tomorrow); // Set tomorrow's date

         };
      </script>



      <script>
         document.addEventListener('DOMContentLoaded', function() {

            const formElements = document.querySelectorAll('.Invoice input, .Invoice textarea');



            // Get the "Clear Form" button

            const clearButton = document.getElementById('clear-form-btn');



            // Add event listener to the "Clear Form" button

            clearButton.addEventListener('click', function() {

               // Clear all form inputs and textareas

               formElements.forEach(element => {

                  // Reset value for inputs and textareas

                  if (element.type !== 'file') {

                     element.value = ''; // Clear the value of the field

                  } else if (element.type === 'file') {

                     // Clear file input

                     element.value = null;

                     document.getElementById('img-preview').innerHTML = ''; // Clear image preview if present

                  }

               });



               localStorage.clear();



               document.getElementById('currency').value = '$'; // Reset the currency to default if needed

            });

         });
      </script>



      <script>
         const statusDropdown = document.getElementById('status');

         const urlContainer = document.getElementById('url_container');

         const pay_link = document.getElementById('pay_link');



         statusDropdown.addEventListener('change', function() {

            if (this.value === 'unpaid') {

               urlContainer.style.display = 'block';

               pay_link.style.display = 'block';

            } else {

               urlContainer.style.display = 'none';

               pay_link.style.display = 'none';

            }

         });



         if (statusDropdown.value === 'unpaid') {

            urlContainer.style.display = 'block';

            pay_link.style.display = 'block';

         } else {

            urlContainer.style.display = 'none';

            pay_link.style.display = 'none';

         }
      </script>



      <script>
         function saveTextarea(textarea) {

            const url = textarea.value;

            localStorage.setItem('urlTextarea', JSON.stringify(url));

         }



         document.getElementById("download_invoice").addEventListener("click", function(e) {

            e.preventDefault();

            const invoiceHtml = document.getElementById("invoice_section").outerHTML;

            document.getElementById("invoice_html").value = invoiceHtml;

            e.target.closest("form").submit();

         });
      </script>

      <script>
         let itemCounter = 1;



         // Add event listener for the "append" button to add new items

         document.getElementById('append-btn').addEventListener('click', function(e) {

            e.preventDefault();



            itemCounter++; // Increment item counter

            const container = document.getElementById('append-container'); // Get the container



            const newField = `

         <div class="append" id="field-${itemCounter}">

            <div>

                <input data-id="${itemCounter}" type="text" name="item-des[]" id="item-des-${itemCounter}" 

                       placeholder="Description of service or product..." value="">

            </div>

            <div>

                <input data-id="${itemCounter}" type="number" name="quantity[]" id="quantity-${itemCounter}" 

                       value="1" oninput="updatePrice(this)">

            </div>

            <div>

                <span class="Rate">

                    <span class="currencySymbol"></span>

                    <input type="number" value="0" data-id="${itemCounter}" name="rate[]" id="rate-${itemCounter}" 

                           oninput="updatePrice(this)">

                </span>

            </div>

            <p class="Amount"><span class="currencySymbol"></span> 

                <span class="amount" id="currency-${itemCounter}">0</span>

            </p>

            <i class="remove-btn icon ni ni-cross-round" data-id="${itemCounter}" onclick="removeLine(this)"></i>

        </div>`;



            container.insertAdjacentHTML('beforeend', newField); // Add new item field at the end of the container



            // Recalculate totals after adding a new field

            calculateTotals();



            // Add event listener dynamically for the new quantity and rate fields

            document.getElementById(`quantity-${itemCounter}`).addEventListener('input', updatePrice);

            document.getElementById(`rate-${itemCounter}`).addEventListener('input', updatePrice);

         });



         // Function to remove a line

         function removeLine(el) {

            const id = el.getAttribute('data-id');

            const field = document.getElementById(`field-${id}`);

            if (field) field.remove();

            calculateTotals(); // Recalculate after removing a line

         }



         // Function to update the price for the individual row

         function updatePrice(el) {

            const id = el.getAttribute('data-id'); // Get the unique data-id for the line item

            const quantity = document.getElementById(`quantity-${id}`).value || 0; // Get the quantity value

            const rate = document.getElementById(`rate-${id}`).value || 0; // Get the rate value

            const total = parseFloat(quantity) * parseFloat(rate); // Calculate the total price for this item

            document.getElementById(`currency-${id}`).innerText = total.toFixed(2); // Update the total amount for this row



            // Recalculate overall totals after the price update

            calculateTotals();

         }



         // Function to calculate subtotal, total, and balance due

         function calculateTotals() {

            const quantityFields = document.querySelectorAll('input[name="quantity[]"]');

            const rateFields = document.querySelectorAll('input[name="rate[]"]');

            const discountField = document.getElementById('discount');

            const taxField = document.getElementById('tax');

            const shippingField = document.getElementById('shipping');

            const paidField = document.getElementById('paid');

            const balanceDueField = document.getElementById('balancedue'); // Ensure correct ID selection



            const discount = parseFloat(discountField?.value || 0);

            const tax = parseFloat(taxField?.value || 0);

            const shipping = parseFloat(shippingField?.value || 0);

            const paid = parseFloat(paidField.value) || 0; // Fix: Ensure valid number parsing



            let subtotal = 0;



            // Loop through each row and calculate the individual row total

            quantityFields.forEach((qtyInput, index) => {

               const qty = parseFloat(qtyInput.value || 0);

               const rate = parseFloat(rateFields[index]?.value || 0);

               const lineTotal = qty * rate;

               subtotal += lineTotal;



               // Update the individual row amount in the table

               const lineTotalElement = document.getElementById(`currency-${index + 1}`);

               if (lineTotalElement) lineTotalElement.textContent = lineTotal.toFixed(2);

            });



            // Update the subtotal element in the UI

            document.getElementById('subtotal').textContent = subtotal.toFixed(2);



            // Apply discount and tax to calculate the total

            const discountedTotal = subtotal - discount;

            const taxedTotal = discountedTotal + tax;

            const totalBeforePaid = taxedTotal + shipping;



            // Update the total amount in the UI (before subtracting paid)

            document.getElementById('total').textContent = totalBeforePaid.toFixed(2);



            // Now subtract the 'paid' amount from the total

            const balanceDue = totalBeforePaid - paid;

            // **Fixing Live Update for Balance Due**
            balanceDueField.textContent = balanceDue.toFixed(2); // Ensure UI update
            balanceDueField.style.color = balanceDue < 0 ? "red" : "black"; // Optional: Show negative balance in red


         }
         document.getElementById('paid').addEventListener('input', calculateTotals);






         // Add event listeners to the inputs on initial load

         document.addEventListener('DOMContentLoaded', function() {

            const quantityFields = document.querySelectorAll('input[name="quantity[]"]');

            const rateFields = document.querySelectorAll('input[name="rate[]"]');

            const discountField = document.getElementById('discount');

            const taxField = document.getElementById('tax');

            const shippingField = document.getElementById('shipping');

            const paidField = document.getElementById('paid');



            // Add input event listeners to trigger price calculation

            quantityFields.forEach(input => input.addEventListener('input', calculateTotals));

            rateFields.forEach(input => input.addEventListener('input', calculateTotals));

            discountField.addEventListener('input', calculateTotals);

            taxField.addEventListener('input', calculateTotals);

            shippingField.addEventListener('input', calculateTotals);

            paidField.addEventListener('input', calculateTotals);

         });



         // Handle the download of the invoice

         document.getElementById('download_invoice').addEventListener('click', function(e) {

            e.preventDefault();



            // Ensure all calculations are done before submission

            calculateTotals();



            const subtotal = document.getElementById('subtotal').textContent || 0;

            const total = document.getElementById('total').textContent || 0;

            const balanceDue = document.getElementById('balancedue').textContent || 0;



            // Validate client information before submitting the form

            if (document.getElementById('clientName').value === '' || document.getElementById('clientEmail').value === '') {

               alert('Client Name and Email are required.');

               return;

            }



            // Insert the calculated values into hidden inputs before submission

            document.getElementById('invoice_html').value = document.querySelector('.invoice-div').outerHTML;



            const form = document.querySelector('form');

            form.insertAdjacentHTML(

               'beforeend',

               `

            <input type="hidden" name="subtotal" value="${subtotal}">

            <input type="hidden" name="total" value="${total}">

            <input type="hidden" name="balance_due" value="${balanceDue}">

         `

            );



            // Submit the form

            form.submit();

         });
      </script>
      <script>
         document.getElementById('logoutForm').addEventListener('submit', function(e) {

            e.stopPropagation(); // Prevent conflict with other forms

            e.preventDefault(); // Optional: Handle logout form as needed

         });

         document.getElementById('logoUpload').addEventListener('change', function(event) {

            const reader = new FileReader();

            reader.onload = function(e) {

               document.getElementById('logo_img').src = e.target.result; // Update the logo image source with the selected file

            };

            reader.readAsDataURL(event.target.files[0]); // Read the selected file as a data URL

         });
      </script>

      <script>
         // JavaScript to preview the selected image

         function previewImage(event) {

            var file = event.target.files[0]; // Get the selected file

            var reader = new FileReader();



            // When the file is loaded, update the img src

            reader.onload = function(e) {

               document.getElementById('logo_img').src = e.target.result;

            };



            // Read the selected file as a data URL

            if (file) {

               reader.readAsDataURL(file);

            }

         }

         function previewWatermark(event) {

            var file = event.target.files[0]; // Get the selected file

            var reader = new FileReader();



            reader.onload = function(e) {

               document.getElementById('watermark_img').src = e.target.result;

            };

            if (file) {

               reader.readAsDataURL(file);

            }

         }
      </script>


      <script>
         function generateInvoiceNumber() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const invoiceNumber = `${hours}${minutes}${seconds}`;
            document.getElementById("invoice-no-label").value = invoiceNumber;
         }

         // Generate invoice number when the page loads
         window.addEventListener('DOMContentLoaded', generateInvoiceNumber);
      </script>
      <script>
         document.getElementById('clear-form-btn').addEventListener('click', function() {
            const form = document.getElementById('invoiceForm');

            // Reset and clear localStorage
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
               const isLabel = input.id?.includes('label') || input.name?.includes('label');
               const isLogo = input.id === 'logoUpload' || input.id === 'watermarkUpload';

               if (!isLabel && !isLogo && input.type !== 'hidden') {
                  if (input.type === 'checkbox' || input.type === 'radio') {
                     input.checked = false;
                  } else if (input.tagName === 'SELECT') {
                     input.selectedIndex = 0;
                  } else {
                     input.value = '';
                  }

                  const key = `invoice_${input.name || input.id}`;
                  localStorage.removeItem(key);
               }
            });

            // Same for textareas
            const textareas = form.querySelectorAll('textarea');
            textareas.forEach(textarea => {
               const isLabel = textarea.id?.includes('label') || textarea.name?.includes('label');
               if (!isLabel) {
                  textarea.value = '';
                  const key = `invoice_${textarea.name || textarea.id}`;
                  localStorage.removeItem(key);
               }
            });

            // Line item reset
            const container = document.getElementById('append-container');
            const firstItem = document.getElementById('field-1');
            container.innerHTML = '';
            container.appendChild(firstItem);
            firstItem.querySelectorAll('input').forEach(inp => inp.value = '');
            firstItem.querySelector('.amount').textContent = '0';

            // Currency/Status reset
            document.getElementById('currency').selectedIndex = 0;
            document.getElementById('status').selectedIndex = 0;
            document.getElementById('subtotal').textContent = '0.00';
            document.getElementById('total').textContent = '0.00';
            document.getElementById('balancedue').textContent = '0.00';
            document.getElementById('tax').value = '0';
            document.getElementById('discount').value = '0';
            document.getElementById('paid').value = '0';

            localStorage.removeItem('invoice_po-input');
            localStorage.removeItem('invoice_invoice-no-label');

            // Re-generate new PO number
            const poNow = new Date();
            const poMonth = String(poNow.getMonth() + 1).padStart(2, '0');
            const poDay = String(poNow.getDate()).padStart(2, '0');
            const poHours = String(poNow.getHours()).padStart(2, '0');
            const poMinutes = String(poNow.getMinutes()).padStart(2, '0');
            const poSeconds = String(poNow.getSeconds()).padStart(2, '0');
            const poRand = Math.floor(Math.random() * 900 + 100);
            const poNumber = `${poMonth}${poDay}-${poHours}${poMinutes}${poSeconds}-${poRand}`;
            document.getElementById('po-input').value = poNumber;
            localStorage.setItem('invoice_po-input', poNumber);

            // Re-generate invoice number
            const invoiceNumber = `${poHours}${poMinutes}${poSeconds}`;
            document.getElementById('invoice-no-label').value = invoiceNumber;
            localStorage.setItem('invoice_invoice-no-label', invoiceNumber);
         });
      </script>


      <script>
         // Save on every change
         document.querySelectorAll('#invoiceForm input, #invoiceForm textarea, #invoiceForm select').forEach(field => {
            const isLabel = field.id?.includes('label') || field.name?.includes('label');
            const isLogo = field.id === 'logoUpload' || field.id === 'watermarkUpload';

            if (!isLabel && !isLogo && field.type !== 'file') {
               const key = `invoice_${field.name || field.id}`;

               // Restore if exists
               const savedValue = localStorage.getItem(key);
               if (savedValue !== null) {
                  field.value = savedValue;
               }

               // Save on change
               field.addEventListener('input', () => {
                  localStorage.setItem(key, field.value);
               });
            }
         });
      </script>

      <?php require_once("./main_components/footer.php") ?>