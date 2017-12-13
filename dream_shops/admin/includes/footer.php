</body>
<script>
   function get_child_options(){
       var parentID = jQuery('#parent').val();
       jQuery.ajax({
          url: '/dream_shops/admin/parsers/child_categories.php',
          type: 'POST',
          data: { parentID : parentID },
          success: function(data){
           jQuery('#child').html(data);
       },
          error: function(){alert("Something went wrong with the child options")},
       });
   }
   jQuery('select[name="parent"]').change(get_child_options);
</script>


<footer class="container-fluid text-center">
	  <a href="#Home" title="To Top">
	    <span class="glyphicon glyphicon-chevron-up"></span>
	  </a>
      <h4>Howdie! Admin!</h4>
	  <p>&copy; Copyright 2016-<?php echo date("Y"); ?> Online Express Store</a></p>
</footer>
