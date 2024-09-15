function addCommentDialog()
{
    const dialog = document.getElementById('addCommentDialog');
    const closeButton = document.getElementById('commentDialogBtnClose');
        dialog.showModal();
    closeButton.addEventListener("click", () => {
    dialog.close();
    });
}

function deleteCommentDialog(commentId)
{
    const dialog = document.getElementById('deleteCommentDialog');
    const commentIdInput = dialog.querySelector('input[name="commentId"]');
    const closeButton = document.getElementById('commentDialogBtnClose');
        // Injecter l'ID du commentaire dans le champ caché du formulaire
        commentIdInput.value = commentId;
        // Ouvrir le dialogue
        dialog.showModal();
    closeButton.addEventListener("click", () => {
    dialog.close();
    });
}

function updateCommentDialog(commentId, commentText) {
    console.log(commentId);
    console.log(commentText);
    const dialog = document.getElementById('updateCommentDialog');
    const commentIdInput = dialog.querySelector('input[name="commentId"]');
    const commentContent = document.getElementById('commentContent');
    const closeButton = document.getElementById('commentDialogBtnClose');
    
    // Injecter l'ID et le texte du commentaire dans les champs du formulaire
    commentIdInput.value = commentId;
    commentContent.value = commentText;
    
    // Ouvrir le dialogue
    dialog.showModal();
    
    closeButton.addEventListener("click", () => {
        dialog.close();
    });
}