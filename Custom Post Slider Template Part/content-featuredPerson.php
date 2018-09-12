<?php
/**
 * The template for displaying Bootstrap Slider with Custom Post Info-
 *

 * @package understrap
 */
?>
<div id="featuredPeople"></div>
<?php $args = array(
	'post_type' => 'featured_People',
	'tax_query' => array(
		array(
			'category_name' => 'featured-people',
		),
	),
);
$people_query = new WP_Query( $args );

?>
<div id="carousel" class="desktopCarousel">
<div id="carousel-thumb" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
    <!--Slides-->
    <div class="carousel-inner" role="listbox">

<!--Carousel Wrapper-->
<?php while($people_query->have_posts()) : $people_query->the_post(); $count++;  ?>

      <div id="slider-<?php echo $count; ?>" class="carousel-item   <?php if($count == 1) { echo ' active'; } ?>" >
        <div class="row">
           <div class="employeeImage col-6">
      <img class="d-block w-100" src=" <?php the_field('people_image') ?>  " alt="image slide of <?php the_field('people_name') ?> ">
     </div>
     <div class="caption col-6 ">
     <h1>Featured People</h1>
     <h5 class="text-uppercase "><?php the_field('people_name') ?><span class="harvestGold">&nbsp;&nbsp;/&nbsp;&nbsp;</span><span class="lightText"><?php the_field('people_role') ?></span> </h5>
     <div class="PeopleBio wow fadeInUp ">
       <?php the_field('people_interview') ?>
     </div>

      </div>
     </div>
     </div>
     <?php $currentCount = $count; ?>
<?php  endwhile;?>
    </div>
    <!--/.Slides-->
        <ol class="carousel-indicators peopleNav PeopleNav">
          <?php $currentCount = 0;
          while($people_query -> have_posts()) : $people_query->the_post(); ?>
            <li>
             <a data-target="#carousel-thumb" data-slide-to="<?php echo $currentCount; ?>"  style="background-image: url('<?php the_field('people_thumbnail_image') ?>');" class="hvr-grow featuredIconLink"></a>

            </li>
            <?php $currentCount++; ?>
            <?php endwhile; ?>
       </ol>
		 </div>
   </div>

<div id="featuredPeople"></div>
	 <?php $args = array(
	 	'post_type' => 'featured_People',
	 	'tax_query' => array(
	 		array(
	 			'category_name' => 'featured-people',
	 		),
	 	),
	 );
	 $mobilepeople_query = new WP_Query( $args );

	 ?>
	 <div id="carousel" class="swiper-container mobileCarousel" style="padding-left:25px; padding-right:25px;">
	 <div id="carousel-thumbs" class="carousel carousel-thumbnails" >
	     <!--Slides-->
	     <div class="carousel-inner" role="listbox">
				 <div class="titleRow col-12 text-center">
				 <h1>svg People</h1>
				 <div id="peopleMv" class="col-12" style="padding-top:15px; padding-bottom:15px;">
				</div>
			 </div>
	 <!--Carousel Wrapper-->
	 <?php while($mobilepeople_query->have_posts()) : $mobilepeople_query->the_post(); $countMobile++;  ?>

	       <div id="slider-<?php echo $countMobile; ?>" class="carousel-item <?php if($countMobile == 1) { echo ' active'; } ?>" >

					 <div class="row">
						 <div class=" col-4">
							 <div class="employeeImageMobile">
 			 			<img class="d-block h-100 w-100" style="border-radius:50%; border:3px #fcb426 solid ;" src=" <?php the_field('people_thumbnail_image') ?>  " alt="image slide of <?php the_field('people_name') ?> ">
					</div>
						</div>
	      <div class="captionMobileTitle col-8 p-10">
				<h5 class="text-uppercase "><?php the_field('people_name') ?><span class="harvestGold"><br></span><span class="harvestGold"><?php the_field('people_role') ?></span> </h5>
			</div>

				<div class="captionMobile col-12">
	      <div class="l wow fadeInUp " style="padding-right:10px; padding-top:20px;">
	        <?php the_field('people_interview') ?>
	      </div>

	       </div>
	      </div>
	      </div>
	      <?php $currentCount = $countMobile; ?>
	 <?php  endwhile;?>
	     </div>
	     <!--/.Slides-->
			 <div id="peopleDD" class="dropdown">
<button data-boundary="peopleDD" data-dropup-auto="false" data-display="static" data-flip="false" style="border-radius:5px; padding-left:5px; padding-right:5px;" class="btn svgButtonMain dropdown-toggle" type="button" id="dropdownMenuButton"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Meet The Team
</button>
<div class="dropdown-menu" x-placement="bottom-end"  style="position:relative !important; width:50%; transform:none !important;" data-dropup-auto="false" data-display="static" data-flip="false" aria-labelledby="dropdownMenuButton">
	<?php $currentCount = 0;
	while($mobilepeople_query -> have_posts()) : $mobilepeople_query->the_post(); ?>
<a class="dropdown-item" data-target="#carousel-thumbs" data-slide-to="<?php echo $currentCount; ?>"><?php the_field('people_name') ?></a>
<?php $currentCount++; ?>
<?php endwhile; ?>
</div>
</div>
	 		 </div>
	    </div>
    <?php wp_reset_postdata(); // reset the query ?>
