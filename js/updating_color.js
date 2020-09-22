function renderFavColorPicker(){
    var template = document.getElementById("fav-color");
    template.removeAttribute("hidden");
}

//Tohle se vola kdyz se klikne na barvu
function updateColorData(name){
    removeCheckmarks();
    color_data.forEach(function(arr_data){
        if(name == arr_data.name){
            data.current_color.color = arr_data.color_code;
            data.current_color.off_color = arr_data.off_color_code;
            data.current_color.color_name = arr_data.name;
        }
    });
    addCheckmarkToCurrentColor();
}


function changeColor(){

    ajax({color: data.current_color.color_name});
    
    var elements;

    elements = document.getElementsByClassName("color");              
    for(let i = 0; i < elements.length; i++){
        elements[i].style.backgroundColor = data.current_color.color;    
    }
    elements = document.getElementsByClassName("border-color");           
    for(let i = 0; i < elements.length; i++){
        elements[i].style.borderColor = data.current_color.color;    
    }
    elements = document.getElementsByClassName("off-color");           
    for(let i = 0; i < elements.length; i++){
        elements[i].style.color = data.current_color.off_color;    
    } 
}

function updateColorClicked(){
    changeColor();
    document.getElementById("fav-color").setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}

function removeCheckmarks(){
    var checkmarks = document.getElementsByClassName("checkmark");
    for(let i = 0; i < checkmarks.length; i++){
        checkmarks[i].parentNode.removeChild(checkmarks[i]);
    }

}

function addCheckmarkToCurrentColor(){
    colorPreviews = document.getElementsByClassName("color-preview");
    for(let i = 0; i < colorPreviews.length; i++){
        if(colorPreviews[i].id == data.current_color.color_name){
            colorPreviews[i].innerHTML = "<i class='fas fa-check checkmark'></i>";
        }
    }


}

