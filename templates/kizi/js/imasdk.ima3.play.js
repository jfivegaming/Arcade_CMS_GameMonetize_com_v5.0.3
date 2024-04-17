$(document).ready(function() {
    $('.gamePlay-icon, .gamePlay-button').click(function(e) {  
      $("#gamePlay-content").hide();
      $("#game-preloading").show();
	      setTimeout(
	  function() 
	  {
      $("#game-preloading").hide();
	  }, 550);
    });
});