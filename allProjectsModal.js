

//define modal behavior
(function handleModal(){
    //force scroll to top after page refresh
    const scrollTimer = setTimeout(function(){
       window.scrollTo(0,0);
        clearTimeout(scrollTimer);
    }, 100);
    const mainBody = document.querySelector("body");
    const modal = document.querySelector(".project-modal");
    const closeBtn = document.querySelector((".continue-btn"));
     
    //prevent scrolling of the main content behind modal
    mainBody.classList.add("no-scroll");
  
    closeBtn.addEventListener("click", function(){
        modal.classList.add("opace");
        mainBody.classList.remove("no-scroll");
        modalOpen = false;
        //change modal to display none after slight delay
        const timer = setTimeout(function(){
            modal.classList.add("noner");
            clearTimeout(timer);
        }, 600);
    });
   
})();


(function handleImproveSection(){
    const improveBtn = document.querySelector(".improve-btn");
    const improveText = document.querySelector(".improve-text");
    const improveTitle = document.querySelector(".improve-title");

    improveBtn.addEventListener("click", function(){
        //expand the improvement text box.
        //improveText.classList.add("expand-text");
        improveText.classList.toggle("expand");
        improveTitle.classList.add("marg-b");
    });

})();