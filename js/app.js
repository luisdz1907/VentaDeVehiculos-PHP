 setTimeout(function(){
    $(".error").fadeOut(400);
  },1200)
  
  setTimeout(function(){
    $(".success").fadeOut(400);
  },1200)
  
  $(document).ready(function(){
    $("#eliminar").click(function(){
      location.reload();
    });
  
  })
function selectMarca(){
  var idMarca= $("#marca").val();
  $.ajax({
    type: 'POST',
    url: './model/select.php',
    data: { 'id':idMarca},
    success: function(resp){
        $("#modelo").attr("disabled", false);
        $("#modelo").html(resp);
        console.log(resp)
    }
  })
}
