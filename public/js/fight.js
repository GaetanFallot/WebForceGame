$(document).ready(function() {

  refreshCombat()

  $('.hit').on('click', function(e) {
    e.preventDefault()
    const hit = $(this).data('hit')
    onHit(hit)
  })

})

function onHit(hit) {
  const pageData = $('#fight-data').data()

  $.ajax({
    type: 'POST',
    url: pageData.hitUrl,
    data: {
      hit: hit
    }
  })
}

function refreshCombat() {
  const pageData = $('#fight-data').data()

  setTimeout(function() {

    $.ajax({
      type: 'GET',
      url: pageData.dataUrl,
    })
      .done(function(response) {
        handleCombatData(response)
      })

    refreshCombat()
  }, 5000)
}

function handleCombatData(data) {
  if (data.status === 'end') {
    alert('LE COMBAT EST TERMINE')
    window.location.href=URLCombatList;
  }

  $('.container_fight_characters .challenger, .container_fight_characters .outsider').removeClass('isNext')
  $('.container_fight_characters .'+data.next).addClass('isNext')

  $('.container_fight_characters .challenger #hp').text(data.challenger.hp)
  $('.container_fight_characters .outsider #hp').text(data.outsider.hp)
}
