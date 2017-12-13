
<div class="col-md-3 text-justify w3-border-left hidden-xs container">
    <h3 class="text-center">Adverts</h3>
    <?php while($advert = mysqli_fetch_assoc($ad)): ?>
      <div class="row">
              <div class="w3-card-8 w3-margin">
                  <h3 class="text-center"><?= $advert['title'];  ?></h3>
                  <img src="<?=$advert['image'];?>" style="width:100%; height:200px" alt="ad" class="img-thumb">
                  <section class="text-justify">
                    <br>
                    <div class="w3-container">
                      <p>
                          <?=$advert['description'];?>
                      </p>
                      <br />
                    </div>
                  </section>
              </div>

          <br />
      </div>
    <?php endwhile; ?>



</div>
