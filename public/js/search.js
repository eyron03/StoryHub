// Function to perform the search
function search() {
    var searchInput = document.getElementById("searchInput");
    var searchText = searchInput.value.toLowerCase();
    var books = document.querySelectorAll('.book');

    books.forEach(function(book) {
        var bookName = book.querySelector('span').innerText.toLowerCase();
        if (bookName.includes(searchText)) {
            book.style.display = 'block';
        } else {
            book.style.display = 'none';
        }
    });
}

// Optional: Trigger search on pressing "Enter" key
document.getElementById("searchInput").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        search();
    }
});
