$(document).ready(function () {
  $("#myTable").DataTable();
});

// Update Data Functionality
const edits = document.getElementsByClassName("edit");
Array.from(edits).forEach((element) => {
  element.addEventListener("click", (e) => {
    const tr = e.target.parentNode.parentNode;
    const title = tr.getElementsByTagName("td")[0].innerText;
    const description = tr.getElementsByTagName("td")[1].innerText;
    titleEdit.value = title;
    descriptionEdit.value = description;
    noEdit.value = e.target.id;
    console.log(e.target.id);
    $("#mNotesModal").modal("toggle");
  });
});

// Delete Data Functionality

const deletes = document.getElementsByClassName("delete");
Array.from(deletes).forEach((element) => {
  element.addEventListener("click", (e) => {
    const no = e.target.id.substr(1); //Extract id from button
    if (confirm("Are you sure you want to delete?")) {
      window.location = `/learnphp/crud/index.php?delete=${no}`;
    } else {
      console.log("No");
    }
  });
});
