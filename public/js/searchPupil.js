function filterPupilsTable() {
    var input, filter, table, tr, tdId, tdName, i, txtValueId, txtValueName;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("pupilsTable"); // Make sure your table has id="pupilsTable"
    tr = table.getElementsByTagName("tr");
    var found = false;

    for (i = 0; i < tr.length; i++) {
        tdId = tr[i].getElementsByTagName("td")[0]; // Assuming the Pupil ID is in the first column
        tdName = tr[i].getElementsByTagName("td")[1]; // Assuming the Pupil Name is in the second column
        if (tdId && tdName) {
            txtValueId = tdId.textContent || tdId.innerText;
            txtValueName = tdName.textContent || tdName.innerText;
            if (txtValueId.toUpperCase().indexOf(filter) > -1 || txtValueName.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                found = true;
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    var notFoundMessage = document.getElementById("notFoundMessage");
    if (found) {
        notFoundMessage.style.display = "none";
    } else {
        notFoundMessage.style.display = "block";
    }
}

// Attach event listener to the search input
document.getElementById("searchInput").addEventListener("keyup", filterPupilsTable);
