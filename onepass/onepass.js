$(function(){
  if($("form").length){
    let i = 0;
    $(".form-group.pass_show").each(function(){
      i++
      if(i==2){
        $(this).hide()
        $("input[name=password]").on("input",function(){
          $("input[name=passwordConfirm]").val($(this).val())
        })
      }
    })
  }
})