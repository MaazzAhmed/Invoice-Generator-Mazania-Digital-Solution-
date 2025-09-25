// const currencySelect = document.getElementById("currency");
// const quantity = document.getElementById("quantity");
// const rate = document.getElementById("rate");
// const discount = document.getElementById("discount");
// const tax = document.getElementById("tax");
// const shipping = document.getElementById("shipping");
// const paid = document.getElementById("paid");
// const subTotalInput = document.getElementById("subtotal");
// subTotalInput.textContent = 0;
// const amountInput = document.querySelector(".amount");
// const totalInput = document.getElementById("total");
// totalInput.textContent = 0;
// const balanceDueInput = document.getElementById("balancedue");
balanceDueInput.textContent = 0;

document.addEventListener("DOMContentLoaded", () => {
  updateCurrencySymbol();
   removeBtn();
});

// document.addEventListener("DOMContentLoaded", function() {
//   document.querySelector("#download_invoice").onclick = function () {
//     var element = document.querySelector("#invoice_section");
//     var opt = {
//       margin: 10,
//       filename: 'invoice.pdf',
//       image: { type: 'jpeg', quality: 0.98 },
//       html2canvas: { scale: 2 },
//       jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
//     };
//     html2pdf().from(element).set(opt).outputPdf().then(function (pdf) {
//       // You can open the PDF in a new tab for testing (remove this line in production)
//       pdf.output('dataurlnewwindow');
//     });
//   }
// });

let count =
  parseInt(
    Array.from(document.querySelectorAll(".append")).at(-1).id.split("-").at(-1)
  ) + 1;

//////////////////////////////////////////////////////
// Data definition for saving data in local storage //
let data = {};
let fieldData = {};
let staticItem = {};
/////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// Calculate Price function start ///////////////////////

function updateCurrencySymbol() {
  const currencySymbolSpan = document.querySelectorAll(".currencySymbol");
  const selectedCurrencyOption =
    currencySelect.options[currencySelect.selectedIndex];
  const currencyLabel = selectedCurrencyOption.getAttribute("label");
  const currencySymbol = currencyLabel.includes("(")
    ? currencyLabel.match(/\(([^)]+)\)/)[1]
    : currencyLabel;
  currencySymbolSpan?.forEach((span) => {
    span.textContent = currencySymbol;
  });
  localStorage.setItem("currencySymbol", currencySymbol);
}

function price(amountField) {
  updateCurrencySymbol();
  if (amountField?.id == "rate") {
    let quantityValue = "";
    document.querySelectorAll("#quantity")?.forEach((item) => {
      if (item?.dataset.id == amountField?.dataset.id) {
        quantityValue = item.value;
      }
    });
    data[amountField?.dataset.id] = {
      ...data[amountField?.dataset.id],
      quantity: quantityValue,
      rate: amountField?.value,
    };
    const calculatedPrice = quantityValue * (amountField?.value || 5);
    selectedAmount = document.getElementById(
      `currency-${amountField?.dataset.id}`
    );
    if (selectedAmount) {
      selectedAmount.textContent = calculatedPrice;
    }
    data[amountField?.dataset.id] = {
      ...data[amountField?.dataset.id],
      calculatedPrice,
    };
  } else if (amountField?.id == "quantity") {
    let rateValue = "";
    document.querySelectorAll("#rate")?.forEach((item) => {
      if (item?.dataset.id == amountField?.dataset.id) {
        rateValue = item.value;
      }
    });
    data[amountField?.dataset.id] = {
      ...data[amountField?.dataset.id],
      quantity: amountField?.value,
      rate: rateValue,
    };
    const calculatedPrice = (amountField?.value || 0) * rateValue;
    selectedAmount = document.getElementById(
      `currency-${amountField?.dataset.id}`
    );
    if (selectedAmount) {
      selectedAmount.textContent = calculatedPrice;
    }

    data[amountField?.dataset.id] = {
      ...data[amountField?.dataset.id],
      calculatedPrice,
    };
  }

  let totalSum = 0;
  document.querySelectorAll(".amount").forEach((item) => {
    totalSum += parseInt(item.textContent);
  });

  subTotalInput.textContent = totalSum ? totalSum : 0;

  let taxUpdated;
  let updatedTax = 0;
  let updatedDiscount = 0;
  let taxValue;

  if (tax.type === "number") {
    updatedTax = tax.value;
    taxValue = "false";
  } else {
    updatedTax = (parseFloat(tax.value) / 100) * totalSum;
    taxValue = "true";
  }

  if (taxValue === "true") {
    localStorage.setItem("taxPercentageValue", tax.value);
    taxUpdated = `${parseFloat(tax.value)}%`;
    tax.type = "text";
  } else {
    taxUpdated = tax.value;
    tax.type = "number";
  }

  if (discount.type === "number") {
    updatedDiscount = discount.value;
  } else {
    localStorage.setItem("discountPercentage", discount.value);
    updatedDiscount = (parseFloat(discount.value) / 100) * totalSum;
  }

  updatedDiscount = isNaN(parseFloat(updatedDiscount))
    ? 0
    : parseFloat(updatedDiscount);
  updatedTax = isNaN(parseFloat(updatedTax)) ? 0 : parseFloat(updatedTax);
  updateShipping = isNaN(parseFloat(shipping?.value))
    ? 0
    : parseFloat(shipping?.value);
  updatePaid = isNaN(parseFloat(paid?.value)) ? 0 : parseFloat(paid?.value);

  let afterTaxPrice = totalSum + updatedTax - updatedDiscount + updateShipping;
  let afterPaidPrice = afterTaxPrice - updatePaid;

  afterTaxPrice = isNaN(afterTaxPrice) ? 0 : afterTaxPrice;
  totalInput.textContent = Math.floor(afterTaxPrice);
  balanceDueInput.textContent = Math.floor(afterPaidPrice);

  fieldData = {
    totalSum,
    updatedTax,
    taxUpdated,
    taxValue,
    updatedDiscount,
    updateShipping,
    afterTaxPrice,
    updatePaid,
    afterPaidPrice,
  };

  document.querySelectorAll("#item-des").forEach((item) => {
    item.addEventListener("input", () => {
      data[item.dataset.id] = {
        ...data[item.dataset.id],
        description: item.value,
      };
    });
  });

  saveDataStorage();
}
// Calculate Price function end //////////////////
/////////////////////////////////////////////////

//////////////////////////////////////////////////
// This is for Image Data save in local storage //
// Get the necessary elements
const chooseFile = document.getElementById("choose-file");
const imgPreview = document.getElementById("img-preview");
const fileLabel = document.getElementById("choose-file-label");

// Path to your image in the project folder
const defaultImagePath = "logo/weblogo.png";

// Check if an image is stored in localStorage
const storedImage = localStorage.getItem("selectedImage");

if (storedImage) {
  // If an image is stored in localStorage, display it
  imgPreview.style.display = "block";
  fileLabel.style.display = "none";
  imgPreview.innerHTML =
    '<img id="abc" src="' + storedImage + '" /><i id="cross-icon" class="icon ni ni-cross-round" onclick="toggleImg()"></i>';
} else {
  // If no image is stored, show the default image from your project folder
  imgPreview.style.display = "block";
  fileLabel.style.display = "none";
  imgPreview.innerHTML =
    '<img id="abc" src="' + defaultImagePath + '" /><i id="cross-icon" class="icon ni ni-cross-round" onclick="toggleImg()"></i>';
}

// Handle file input change (for when the user uploads an image)
chooseFile.addEventListener("change", function(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const imageUrl = e.target.result;

      // Store the selected image URL in localStorage
      localStorage.setItem("selectedImage", imageUrl);

      // Display the uploaded image
      imgPreview.style.display = "block";
      fileLabel.style.display = "none";
      imgPreview.innerHTML =
        '<img id="abc" src="' + imageUrl + '" /><i id="cross-icon" class="icon ni ni-cross-round" onclick="toggleImg()"></i>';
    };
    reader.readAsDataURL(file); // Convert the image to a data URL
  }
});

// Function to toggle image (e.g., remove image when clicking the cross icon)
function toggleImg() {
  localStorage.removeItem("selectedImage"); // Remove the image from localStorage
  imgPreview.style.display = "none"; // Hide the image preview
  fileLabel.style.display = "block"; // Show the file input label
}
// 

function saveLabel(input) {
  const invoiceLabels = JSON.parse(localStorage.getItem("invoiceLabels")) || {};
  invoiceLabels[input.id] = input.value;
  localStorage.setItem("invoiceLabels", JSON.stringify(invoiceLabels));
}

// Save textarea data to local storage
function saveTextarea(textarea) {
  let invoiceTextarea =
    JSON.parse(localStorage.getItem("invoiceTextarea")) || {};
  invoiceTextarea[textarea.id] = textarea.value;
  localStorage.setItem("invoiceTextarea", JSON.stringify(invoiceTextarea));
}

// Retrieve saved textarea data from local storage based on the textarea's ID
function retrieveTextareaData() {
  const invoiceTextarea =
    JSON.parse(localStorage.getItem("invoiceTextarea")) || {};

  // Loop through the saved data and populate textareas based on their IDs
  for (const id in invoiceTextarea) {
    const textarea = document.getElementById(id);
    if (textarea) {
      textarea.value = invoiceTextarea[id];
    }
  }
}

// Call the retrieveTextareaData function when the page loads to populate the textareas
window.addEventListener("load", retrieveTextareaData);

function retrieveTextarea() {
  const invoiceTextarea =
    JSON.parse(localStorage.getItem("invoiceTextarea")) || {};
  const textarea = document.getElementById("invoice-from");

  if (textarea) {
    textarea.value = invoiceTextarea["invoice-from"] || "Masterminds Enterprises";
  }
}

// Call the retrieveTextarea function when the page loads to populate the textarea
window.addEventListener("load", retrieveTextarea);

function retrieveLabels() {
  const storedJSON = localStorage.getItem("invoiceLabels");
  if (storedJSON) {
    const storedObject = JSON.parse(storedJSON);

    const inputFields = document.querySelectorAll('input[type="text"]');
    inputFields.forEach(function (input) {
      if (storedObject[input.id]) {
        input.value = storedObject[input.id];
      }
    });
  }
}

retrieveLabels();
// Image Data save in local storage End //
//////////////////////////////////////////

////////////////////////////////////////////////////
// Function for datastorage value in LocalStorage //
function saveDataStorage() {
  localStorage.setItem("myData", JSON.stringify(data));
  localStorage.setItem("fieldData", JSON.stringify(fieldData));

  let currencySelector = document.querySelector("#currency").value;
  let date = document.querySelector("#date").value;
  let dueDate = document.querySelector("#duedate").value;
  staticItem = { currencySelector, date, dueDate };
  const items = JSON.stringify(staticItem);
  localStorage.setItem("selectorItems", items);
}

window.addEventListener("beforeunload", () => {
  saveDataStorage();
});
// Function Storage End /////////////////////////
/////////////////////////////////////////////////

////////////////////////////
// Data load from storage //
// This code runs when the webpage (window) has finished loading
window.addEventListener("load", () => {
  // Parse and retrieve data from local storage
  document.querySelector("#quantity").value = 1;    
  const savedData = JSON.parse(localStorage.getItem("myData"));
  const dataString = JSON.parse(localStorage.getItem("fieldData"));
  const selectorItems = JSON.parse(localStorage.getItem("selectorItems"));

  // Check if there is data in 'savedData' object
  if (Object.keys(savedData).length !== 0) {
    // Clear the contents of an HTML element with class "append-container"
    let parent = document.querySelector(".append-container");
    parent.innerHTML = "";

    // Set 'data' to the contents of 'savedData'
    data = savedData;

    // Loop through 'savedData' and add tags to the 'parent' element
    for (let key in savedData) {
      value = savedData[key];
      addTags(key, value, parent);
    }

    // Calculate the 'count' value based on the last ID of elements with class "append"
    count =
      parseInt(
        Array.from(document.querySelectorAll(".append"))
          .at(-1)
          .id.split("-")
          .at(-1)
      ) + 1;

    // Calculate the 'totalSum' of calculatedPrice from 'data'
    let totalSum = 0;
    for (let key in data) {
      if (data.hasOwnProperty(key)) {
        value = data[key];
        totalSum += value.calculatedPrice;
      }
    }

    // Set the 'textContent' of an element with an ID of "subTotalInput" to 'totalSum'
    subTotalInput.textContent = totalSum || 1;


    // Set values of specific input fields from 'selectorItems'
    document.querySelector("#currency").value = selectorItems.currencySelector;
    document.querySelector("#date").value = selectorItems.date;
    document.querySelector("#duedate").value = selectorItems.dueDate;

    // Retrieve and set values from 'dataString' object
    let totalInputValue = dataString?.afterTaxPrice || 0;
    totalInput.textContent = Math.floor(totalInputValue);
    let afterPaidPriceValue = dataString?.afterPaidPrice || 0;
    balanceDueInput.textContent = Math.floor(afterPaidPriceValue);

    // Set values of 'discount', 'tax', 'shipping', and 'paid' input fields from 'dataString'
    discount.value = dataString.updatedDiscount;
    tax.value = dataString.updatedTax;
    shipping.value = dataString.updateShipping;
    paid.value = dataString.updatePaid;

    // Update 'fieldData' by combining existing properties with new properties
    fieldData = dataString;
    fieldData = { ...fieldData, totalInputValue, afterPaidPriceValue };

    // Call the 'price' and 'deleteField' functions
    price();

    if (JSON.parse(localStorage.getItem("discoutPercentage"))) {
      document.querySelector("#discount").type = "text";
      document.querySelector("#discount").value =
        localStorage.getItem("discountPercentage");
    }

    if (JSON.parse(localStorage.getItem("taxPercentage"))) {
      document.querySelector("#tax").type = "text";
      document.querySelector("#tax").value =
        localStorage.getItem("taxPercentageValue");
    }
  }
});
// Data load from storage end //
///////////////////////////////

////////////////////////////////
// Append Tags Event Function //
document.getElementById("append-btn").addEventListener("click", function () {
  // Add fields start //
  var parent = document.querySelector(".append-container");
  const value = {
    description: "",
    rate: 0,
    quantity: 1,
    calculatedPrice: 0,
  };
  // Add Field End //

  // Delete fields start //
  // Delete Option is enable when user enter new field //
  // Delete Fields End //

  // count of fields
  count += 1;

  addTags((key = count), value, parent);
  deleteField();
   removeBtn();
  price();
});

// Append Tags Event Function end //
////////////////////////////////////

//////////////////////////////////////////
/// Add tags method start ////////////////
function addTags(key, value, parent) {
  // Create a div element to hold the entire line item
  divTagAppend = document.createElement("div");
  divTagAppend.classList.add("append");
  divTagAppend.setAttribute("id", `field-${key}`);

  // Create a div for the item description field
  div1 = document.createElement("div");
  input1 = document.createElement("input");
  input1.setAttribute("type", "text");
  input1.setAttribute("name", "item-des");
  input1.setAttribute("id", "item-des");
  input1.setAttribute("data-id", key);
  input1.value = value.description || "";
  input1.setAttribute("placeholder", "Description of service or product...");
  div1.appendChild(input1);

  // Create a div for the quantity field
  div2 = document.createElement("div");
  label2 = document.createElement("input");
  input2 = document.createElement("input");
  input2.setAttribute("type", "number");
  input2.setAttribute("name", "quantity");
  input2.setAttribute("id", "quantity");
  input2.setAttribute("value", 1);
  input2.setAttribute("data-id", key);
  input2.value = value.quantity;
  input2.setAttribute("oninput", "price(this)");
  div2.appendChild(input2);

  // Create a div for the rate field
  div3 = document.createElement("div");
  spanRate = document.createElement("span");
  spanRate.classList.add("Rate");
  spanSymbol = document.createElement("span");
  spanSymbol.classList.add("currencySymbol");
  spanRate.appendChild(spanSymbol);
  input3 = document.createElement("input");
  input3.setAttribute("type", "number");
  input3.setAttribute("name", "rate");
  input3.setAttribute("id", "rate");
  input3.setAttribute("value", 0);
  input3.setAttribute("data-id", key);
  input3.value = value.rate;
  input3.setAttribute("oninput", "price(this)");
  spanRate.appendChild(input3);
  div3.appendChild(spanRate);

  // Create a paragraph for displaying the calculated amount
  pTag = document.createElement("p");
  pTag.setAttribute("class", "Amount");
  pTag.innerHTML = `<span class="currencySymbol"></span> <span id="currency-${key}" class="amount">${value.calculatedPrice}</span>`;

  // Create a button to remove the line item
  buttonTag = document.createElement("i");
  buttonTag.classList.add("remove-btn", "fa", "fa-close");
  buttonTag.setAttribute("data-id", key);

  // Append all the elements to the main div
  divTagAppend.appendChild(div1);
  divTagAppend.appendChild(div2);
  divTagAppend.appendChild(div3);
  divTagAppend.appendChild(pTag);
  divTagAppend.appendChild(buttonTag);

  // Append the main div to the parent container
  parent.appendChild(divTagAppend);

  deleteField();

}

function removeBtn() {
const removeBtns = document.querySelectorAll(".remove-btn");

  if (removeBtns.length === 1) {
removeBtns[0].style.display = "none";
} else {
removeBtns.forEach((item) => {
item.style.display = "block";
});
}
}




////// Add tags method end ///////////////
//////////////////////////////////////////

////////////////////////////////////////////
////// Field Delete Method start ////////////////////
function deleteField() {
  document.querySelectorAll(".remove-btn").forEach((item) => {
    item.addEventListener("click", () => {
       removeBtn();
      if (document.querySelectorAll(".remove-btn").length !== 1) {
        const fieldId = item.dataset.id;
        const fieldElement = document.querySelector(`#field-${fieldId}`);
        
        // Remove the field element if it exists
        if (fieldElement) {
          fieldElement.remove();
          delete data[fieldId];
        }
        
        // Calculate the total sum
        const totalSum = Object.values(data).reduce(
          (acc, value) => acc + value.calculatedPrice,
          0
          );
          subTotalInput.textContent = totalSum ? totalSum : 0;
          

          // Helper function to calculate updated values based on type
        const calculateUpdatedValue = (input) =>
        input.type === "number"
            ? input.value
            : (parseFloat(input.value) / 100) * totalSum;

        // Calculate updated tax and discount
        const updatedTax = calculateUpdatedValue(tax);
        const updatedDiscount = calculateUpdatedValue(discount);

        // Calculate the after-tax price
        const afterTaxPrice =
          totalSum +
          parseFloat(updatedTax) -
          parseFloat(updatedDiscount) +
          parseFloat(shipping.value);
        totalInput.textContent = Math.floor(afterTaxPrice);

        // Calculate the balance due
        const afterPaidPrice = afterTaxPrice - parseFloat(paid.value);
        balanceDueInput.textContent = Math.floor(afterPaidPrice);

        // Update the fieldData object
        fieldData = {
          ...fieldData,
          totalSum,
          updatedTax,
          updatedDiscount,
          afterTaxPrice,
          afterPaidPrice,
        };

        saveDataStorage();
      }
    });
  });
}

deleteField();
removeBtn();
//////// Delete field method end ///////////////
////////////////////////////////////////////////

////////////////////////////////////////////////////////////
/// Toggle Functions start //////////////////////////////////////

// Define a function called toggleInputType
function toggleInputType() {
  // Get a reference to an HTML element with the ID "tax" and store it in the taxInput variable
  const taxInput = document.getElementById("tax");

    // Define a regular expression pattern that matches characters that are allowed in the input (digits and '%')
    const taxAllowed = /^[0-9%]*$/;

  // Toggle the input type attribute of the taxInput element between "text" and "number"
  taxInput.type = taxInput.type === "text" ? "number" : "text";

  // Set the input value based on the input type
  // If the input type is "text," set the value to "0%"
  // If the input type is "number," set the value to "0"
  taxInput.value = taxInput.type === "text" ? "0%" : "0";

  // Add an event listener to the taxInput element for the "input" event
  taxInput.addEventListener("input", () => {
    // In the input event handler, replace any characters that are not digits (0-9) or '%' with an empty string
    taxValue = taxInput.value;

    // Check if the current value matches the allowed pattern (contains only digits and '%')
    if (taxValue.match(taxAllowed)) {
      // If the value is valid, replace any characters that are not digits or '%' with an empty string
      taxInput.value = taxValue.replace(/[^0-9%]/g, "");
    } else {
      // If the value is not valid, retain the original value
      taxInput.value = taxValue;
    }

        // Find the index of the '%' character in the value
        const taxIndex = taxValue.indexOf("%");

        // If '%' is found, truncate the input value to include only characters before and including the '%'
        if (taxIndex !== -1) {
          taxInput.value = taxValue.substring(0, taxIndex + 1);
        }
      });

  // Edited - Mustafa Abbas
  if (taxInput.type != "number") {
    localStorage.setItem("taxPercentage", true);
  } else {
    localStorage.setItem("taxPercentage", false);
  }

  price();
}

// Define a function called toggleDiscount
function toggleDiscount() {
  // Get a reference to an HTML element with the ID "discount" and store it in the input variable
  const input = document.getElementById("discount");

  // Define a regular expression pattern that matches characters that are allowed in the input (digits and '%')
  const allowed = /^[0-9%]*$/;

  // Toggle the input type attribute of the input element between "text" and "number"
  input.type = input.type === "text" ? "number" : "text";

  // Set the input value based on the input type
  // If the input type is "text," set the value to "0%"
  // If the input type is "number," set the value to "0"
  input.value = input.type === "text" ? "0%" : "0";

  // Add an event listener to the input element for the "input" event
  input.addEventListener("input", () => {
    // Get the current value of the input
    const value = input.value;

    // Check if the current value matches the allowed pattern (contains only digits and '%')
    if (value.match(allowed)) {
      // If the value is valid, replace any characters that are not digits or '%' with an empty string
      input.value = value.replace(/[^0-9%]/g, "");
    } else {
      // If the value is not valid, retain the original value
      input.value = value;
    }

    // Find the index of the '%' character in the value
    const index = value.indexOf("%");

    // If '%' is found, truncate the input value to include only characters before and including the '%'
    if (index !== -1) {
      input.value = value.substring(0, index + 1);
    }
  });

  // Edited - Mustafa Abbas
  if (input.type != "number") {
    localStorage.setItem("discoutPercentage", true);
  } else {
    localStorage.setItem("discoutPercentage", false);
  }

  price();
}

//////// Toggle Functions End ////////////////////////////////
////////////////////////////////////////////////////////////

// Get all input elements of type number
const numberInputs = document.querySelectorAll('input[type="number"]');

// Set the default value of each input to 0 and add event listeners
numberInputs.forEach((input) => {
  input.value = 0;

  // Add a keypress event to prevent the input of negative symbols
  input.addEventListener("keypress", (event) => {
    if (event.key === "-") {
      // Prevent the input of the negative sign if the input is 0
      event.preventDefault();
    }
  });

  // Add an input event to handle empty and negative values
  input.addEventListener("input", (event) => {
    const inputValue = parseFloat(input.value);

    // Check if the input is negative or empty
    if (inputValue < 0 || input.value.trim() === "") {
      // Set the input value to 0
      input.value = "";
    }
  });
});

// input Type Date Older Date Does't Select

const today = new Date().toISOString().split("T")[0];
document.getElementById("date").min = today;
document.getElementById("duedate").min = today;

// discount , Tax , Shipping Toggle .

const elements = ['discountDiv', 'shippingDiv', 'taxDiv'];
const buttons = ['addDiscount', 'removeDiscount', 'addShipping', 'removeShipping', 'addTax', 'removeTax'];

elements.forEach((element, index) => {
  const el = document.getElementById(element);
  const addBtn = document.getElementById(buttons[index * 2]);
  const removeBtn = document.getElementById(buttons[index * 2 + 1]);

  addBtn.addEventListener('click', () => updateDisplay(el, addBtn, removeBtn));
  removeBtn.addEventListener('click', () => updateDisplay(el, addBtn, removeBtn));

			// Set initial display states
			if (element === 'taxDiv') {
				el.style.display = 'flex';
				addBtn.style.display = 'none';
				removeBtn.style.display = 'block';
			} else {
				el.style.display = 'none';
				addBtn.style.display = 'block';
				removeBtn.style.display = 'none';
			}
		});
	
		function updateDisplay(element, addButton, removeButton) {
			element.style.display = element.style.display === 'none' ? 'flex' : 'none';
			addButton.style.display = element.style.display === 'none' ? 'block' : 'none';
			removeButton.style.display = element.style.display === 'flex' ? 'block' : 'none';
}

