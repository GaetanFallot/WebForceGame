const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener( 'click', function() {
        card.classList.toggle('is-flipped');
    });
  })


  $(document).ready(function() {
      let formData = {};
      $("form input, form select").on("input",function(){
        $("form input, form select").each(function(){
            const name = $(this).attr("name").replace("characters[","").replace("]","")
            const value = $(this).val()
            if (name === "profession") {
                console.log($(this).text())
                value = ""
            }
            
            
            formData[name] = value
        })
        for(const name in formData){
            const value = formData[name]
            $("#display-character-"+ name).text(value)

        }
      });
  })