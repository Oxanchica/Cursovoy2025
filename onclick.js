function add(event){
    let id = event.target.dataset.value;
    let button = event.target.getAttribute('class');
    let elem = document.getElementById(id);
    let form = document.querySelector(".view");
    if(elem == null && button == 'add'){
        alert('ok');
        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "cams[]");
        input.setAttribute("value", id);
        input.setAttribute('id', id);
        form.prepend(input);
    } else if(elem != null && button == 'remove'){
        alert('not ok');
        form.removeChild(elem);
    }
}

window.onload = function(){
    document.querySelector("table").onclick = add;
}