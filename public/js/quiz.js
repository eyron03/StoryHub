// Updating file
function updateQuestion(id) {
    $("#updateQuestionModal").modal("show");

    let updateQuizID = $("#quizID-" + id).text();
    let updateQuestion = $("#quizQuestion-" + id).text();
    let updateOptionA = $("#optionA-" + id).text();
    let updateOptionB = $("#optionB-" + id).text();
    let updateOptionC = $("#optionC-" + id).text();
    let updateOptionD = $("#optionD-" + id).text();
    let updateCorrectAnswer = $("#correctAnswer-" + id).text();

    $("#updateQuizID").val(updateQuizID);
    $("#updateQuestion").val(updateQuestion);
    $("#updateOptionA").val(updateOptionA);
    $("#updateOptionB").val(updateOptionB);
    $("#updateOptionC").val(updateOptionC);
    $("#updateOptionD").val(updateOptionD);
    $("#updateCorrectAnswer").val(updateCorrectAnswer);
}

// Deleting question
function deleteQuestion(id) {
    if (confirm("Do you want to delete this question?")) {
        window.location = "./endpoint/delete-question.php?question=" + id;
    }
}

// Deleting result
function deleteResult(id) {
    if (confirm("Do you want to delete this result?")) {
        window.location = "./endpoint/delete-result.php?result=" + id;
    }
}
