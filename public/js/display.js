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

function validNewCommentDialog(commentId)
{
    const dialog = document.getElementById('valdidNewCommentDialog');
    const commentIdInput = dialog.querySelector('input[name="commentId"]');
    const closeButton = document.getElementById('commentDialogBtnClose');
    // Injecter l'ID du commentaire dans le champ caché du formulaire
    commentIdInput.value = commentId;
    // Ouvrir le dialogue
    dialog.showModal();
    closeButton.addEventListener("click", () => {
        console.log(dialog);
        console.log(closeButton);
    dialog.close();
    });
}

function updateCommentDialog(commentId, commentText) {
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

function updatePostDialog(postId, message, title)
{
    const dialog = document.getElementById('updatePostDialog');
    const postIdInput = dialog.querySelector('input[name="postId"]');
    const postTitleInput = dialog.querySelector('input[name="postTitle"]');
    const postMessageInput = dialog.querySelector('textarea[name="postMessage"]');
   console.log(postMessageInput);

    //  const closeButton = document.getElementById('DialogBtnClose');
    
    // Injecter l'ID et le texte du commentaire dans les champs du formulaire
    postIdInput.value = postId;
    postTitleInput.value = title;
    postMessageInput.value = message;
    
    // Ouvrir le dialogue
    dialog.showModal();
    
//     closeButton.addEventListener("click", () => {
//         dialog.close();
//     });
}

function deletePostDialog(postId)
{
    const dialog = document.getElementById('deletePostDialog');
    const postIdInput = dialog.querySelector('input[name="postId"]');
    const closeButton = document.getElementById('DialogBtnClose');
      // Injecter l'ID du post dans le champ caché du formulaire
      postIdInput.value = postId;
      // Ouvrir le dialogue
      dialog.showModal();
      closeButton.addEventListener("click", () => {
      dialog.close();
      });

}

document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.tabs'); 
    const content = document.querySelectorAll('.content-dashboard'); 
    let index = 0;
    tabs.forEach(tab => {
        tab.addEventListener('click', ()=>{

            if (tab.classList.contains('active'))
            {
                return;
            }
            else
            {   
                tab.classList.add('active');
            }

            index = tab.getAttribute('data-tab'); 

            for (i=0; i<tabs.length; i++)
            {
                if (tabs[i].getAttribute('data-tab') != index)
                    {
                        tabs[i].classList.remove('active');
                    }
            }

            for (j=0; j<content.length; j++)
            {
                if (content[j].getAttribute('data-tab') === index)
                    {
                        content[j].classList.add('activeContent');
                    }
                else
                    {
                        content[j].classList.remove('activeContent');
                    }
            }

        })
    })
})

