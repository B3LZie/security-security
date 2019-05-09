function CheckGender(val){
  var element=document.getElementById('gender');
  if(val=='Please select a gender'||val=='Other')
    element.style.display='block';
  else
    element.style.display='none';
}
function CheckPrefix(val){
  var element=document.getElementById('prefix');
  if(val=='Please select a prefix' || val=='Other')
    element.style.display='block';
  else
    element.style.display='none';
}
function CheckUsergroup(val){
  var element=document.getElementById('usergroup');
  if(val=='Please select a usergroup' || val=='Other')
    element.style.display='block';
  else
    element.style.display='none';
  }
