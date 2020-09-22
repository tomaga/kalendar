function dayClicked(elem){
    data.post_its.current_post_it_id = elem.dataset.uid;
    currentDayHasANote(elem.dataset.uid);
    openModal(2);
}

function openPostIt(){
    document.getElementById("make-note").removeAttribute("hidden");

    if(!data.post_its.current_post_it_new){
        document.getElementById("edit-post-it").value = post_its[data.post_its.current_post_it_index].note;
    }
}


function submitPostIt(){
    const value = document.getElementById("edit-post-it").value;
    document.getElementById("edit-post-it").value = "";
    let rando = getRandom(1, 6);
    let post_it = {
        id: data.post_its.current_post_it_id,
        note_num: rando,
        note: value
    }
    if(data.post_its.current_post_it_new){
        post_its.push(post_it);
        ajax({new_note_uid: post_it.id, new_note_color: post_it.note_num, new_note_text: post_it.note});
    }else{
        post_its[data.post_its.current_post_it_index].note = post_it.note;
        ajax({update_note_uid: post_its[data.post_its.current_post_it_index].id, update_note_text: post_it.note});    
    }

    fillInCalendar();
    document.getElementById("make-note").setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}

function getRandom(min, max){
    return Math.floor(Math.random() * (max - min) + min);
}     


function currentDayHasANote(uid){
    for(let i = 0; i < post_its.length; i++){
        if(post_its[i].id == uid){
            data.post_its.current_post_it_new = false;
            data.post_its.current_post_it_index = i;
            return;
        }
    }
    data.post_its.current_post_it_new = true;
}

function deleteNote(){
    document.getElementById("edit-post-it").value = "";
    let indexToDel;

    if(!data.post_its.current_post_it_new){
        indexToDel = data.post_its.current_post_it_index;              
    }
    if(indexToDel != undefined){
        ajax({delete_note_uid: post_its[indexToDel].id});
        post_its.splice(indexToDel, 1);
    }

    fillInCalendar();
    document.getElementById("make-note").setAttribute("hidden", "hidden");
    modal.classList.add("fade-out");
}