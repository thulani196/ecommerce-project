<!-- Full Images Modal -->
	<div id="m01" class="w3-modal" onclick="this.style.display='none'">
			  <span class="w3-closebtn w3-hover-red w3-container w3-padding-16 w3-display-topright">×</span>
			  <img class="w3-modal-content w3-animate-zoom" id="img01" style="width:30%">
	</div>
	<script>
			function onClick(element) {
			  document.getElementById("img01").src = element.src;
			  document.getElementById("m01").style.display = "block";
			}
	</script>
<!-- Image footer ends -->
