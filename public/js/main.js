$(document).ready(function () {
//for all 
const content= document.getElementById('table-content');
if(content){
    content.addEventListener('click',(e)=>{
        if(e.target.className === 'btn btn-danger delete-content'){
            if(!confirm('Are you sure to delete?')){
                e.preventDefault();
                //e.target.click();
            }
        }
    })
}

});