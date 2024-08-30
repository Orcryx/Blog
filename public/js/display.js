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

function updateCommentDialog()
{
    const dialog = document.getElementById('addCommentDialog');
    const closeButton = document.getElementById('deleteCommentIcon');
        dialog.showModal();
    closeButton.addEventListener("click", () => {
    dialog.close();
    });
}
