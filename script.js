function confirmation(id){ 
    const confirm=document.getElementById("confirmation")
    confirm.setAttribute("data", "delete.php?id="+id)
}

function trash(){
    const confirm=document.getElementById("confirmation")
    const url=confirm.getAttribute("data")
    window.location.href = url;
}
