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

