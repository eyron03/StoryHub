function filterTable() {
    var input, filter, table, tr, tdId, tdPfname, i, txtValueId, txtValuePfname;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("parentTable"); // Add an id to your table: id="parentTable"
    tr = table.getElementsByTagName("tr");
    var found = false; // Flag to track if any matching results are found

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 0; i < tr.length; i++) {
        tdId = tr[i].getElementsByTagName("td")[0]; // Assuming the ID is in the first column
        tdPfname = tr[i].getElementsByTagName("td")[1]; // Assuming the first name (pfname) is in the second column
        if (tdId && tdPfname) {
            txtValueId = tdId.textContent || tdId.innerText;
            txtValuePfname = tdPfname.textContent || tdPfname.innerText;
            if (txtValueId.toUpperCase().indexOf(filter) > -1 || txtValuePfname.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                found = true; // Set the flag to true if at least one matching result is found
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // Show or hide the "not found" message based on the search result
    var notFoundMessage = document.getElementById("notFoundMessage");
    if (found) {
        notFoundMessage.style.display = "none"; // Hide the message if results are found
    } else {
        notFoundMessage.style.display = "block"; // Show the message if no results are found
    }
}

// Attach an event listener to the search input to trigger filtering
document.getElementById("searchInput").addEventListener("keyup", filterTable);
