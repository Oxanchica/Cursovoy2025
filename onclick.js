function add(event){
    let input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "cams[]");
    input.setAttribute("value", event.target.dataset.value);
    document.querySelector(".view").prepend(input);
}

window.onload = function(){
    let camsTable = document.querySelector("table");
    camsTable.onclick = add;
}