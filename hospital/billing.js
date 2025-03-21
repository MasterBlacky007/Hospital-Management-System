document.addEventListener("DOMContentLoaded", () => {
    const billingTable = document.getElementById("billingTable");

    // Add a new row
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-add")) {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>
                    <select name="accountName[]" required>
                        <option value="">Select Option</option>
                        <option value="Consultation">Consultation</option>
                        <option value="Medication">Medication</option>
                        <option value="Labtest">Lab test</option>
                    </select>
                </td>
                <td><input type="text" name="description[]" placeholder="Description"></td>
                <td><input type="number" name="quantity[]" min="1" placeholder="Qty" class="qty" oninput="calculateTotal()"></td>
                <td><input type="number" name="price[]" min="0" placeholder="Price" class="price" oninput="calculateTotal()"></td>
                <td><input type="number" name="subtotal[]" placeholder="0.00" class="subtotal" readonly></td>
                <td>
                    <button type="button" class="btn-add">Add</button>
                    <button type="button" class="btn-remove">Remove</button>
                </td>
            `;
            billingTable.appendChild(newRow);
        }
    });

    // Remove a row
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-remove")) {
            const row = e.target.closest("tr");
            if (billingTable.rows.length > 1) {
                row.remove();
                calculateTotal(); // Recalculate total after removing
            } else {
                alert("At least one row must remain!");
            }
        }
    });
});

// Calculate Totals
function calculateTotal() {
    const rows = document.querySelectorAll("#billingTable tr");
    let grandTotal = 0;

    rows.forEach(row => {
        const qty = parseFloat(row.querySelector(".qty").value) || 0;
        const price = parseFloat(row.querySelector(".price").value) || 0;
        const subtotalField = row.querySelector(".subtotal");

        const subtotal = qty * price;
        subtotalField.value = subtotal.toFixed(2); // Update subtotal field
        grandTotal += subtotal; // Add to grand total
    });

    // Update Grand Total field
    document.getElementById("grandTotal").value = grandTotal.toFixed(2);

    // Update Due Amount and Balance fields
    const paidAmount = parseFloat(document.getElementById("paidAmount").value) || 0;

    const dueAmount = grandTotal - paidAmount;
    document.getElementById("dueAmount").value = (dueAmount > 0 ? dueAmount : 0).toFixed(2); // Show due amount if grandTotal > paidAmount

    const balance = paidAmount - grandTotal;
    document.getElementById("balance").value = (balance > 0 ? balance : 0).toFixed(2); // Show balance if paidAmount > grandTotal
}
