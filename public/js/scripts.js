const cards = document.querySelectorAll('.card');

cards.forEach(card => {
    card.addEventListener( 'click', function() {
        card.classList.toggle('is-flipped');
    });
  })


  $(document).ready(function() {
      $("form input, form select").on("input",function(){
        $("form input, form select").each(function(){
            const name = $(this).attr("name").replace("characters[","").replace("]","")
            let value = $(this).val()
            if (name === "profession") {
              value = $('select[name="characters[profession]"] option[value='+value+']').text()
            }
          $("#display-character-"+ name).text(value)
        })
      });

      const imgInp = $('input[name="characters[image]"]')[0]
      if (imgInp) {
        imgInp.onchange = () => {
          const [file] = imgInp.files
          if (file) {
            $('#display-character-image')[0].src = URL.createObjectURL(file)
          }
        }
      }
  })
