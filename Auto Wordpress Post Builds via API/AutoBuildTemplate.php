<?php
/**
* Template Name: AutoBuild
 *
 * @package understrap
 */

 get_header();

 //Delete all current Posts
  $mycustomposts = get_posts( array( 'post_type' => 'jobs', 'numberposts' => -1));
  foreach( $mycustomposts as $mypost ) {
    // Deletes each post.
    wp_delete_post( $mypost->ID, true);
    // Set to False if you want to send them to Trash.
  }
//Stripping any custom code from the API in order to use branded styling from the site. and over ride any
//Strip Tags and replace with spaces
  function rip_tags($string) {

      // ----- remove HTML TAGs -----
      $string = preg_replace ('/<[^>]*>/', ' ', $string);

      // ----- remove control characters -----
      $string = str_replace("\r", '', $string);    // --- replace with empty space
      $string = str_replace("\n", ' ', $string);   // --- replace with space
      $string = str_replace("\t", ' ', $string);   // --- replace with space

      // ----- remove multiple spaces -----
      $string = trim(preg_replace('/ {2,}/', ' ', $string));

      return $string;

  }


//Grab the full body
$svgJobRequest = wp_remote_get( ''//url redacted due to security,
 array(

 'headers' => array(

      'Authorization' => 'Basic c3ZnYXBpdXNlcjp0JmU4KkpzVzM0OzE='
),
));

if( is_wp_error( $svgJobRequest ) ) {
  	return false;
  echo '<div class="container">';
   echo '<h1>';
  echo "something isn't right";// Bail early
   echo '</h1>';
    echo '</div>';

}

$jobBody = json_decode(wp_remote_retrieve_body( $svgJobRequest ));

      foreach($jobBody->searchResults as $job) {
       $jobUrl = $job->portalUrl;
       $jobId = $job->id;
       $jobDate = $job->updatedDate;
       $jobApiUrl =$job->self;

       //Grab the individual job details

       $svgJobListing = wp_remote_get( 'https://urlredacted.com/'.$jobId.'?fields=jobtitle,overview,responsibilities,qualifications,id,positioncategory,positiontype,joblocation',
        array(

        'headers' => array(

             'Authorization' => 'Basic c3ZnYXBpdXNlcjp0JmU4KkpzVzM0OzE='
       ),
       ));

       $jobListingBody = json_decode(wp_remote_retrieve_body( $svgJobListing ));

            // echo '<pre>';
            // print_r($svgJobListing);
            // echo '</pre>';

         $jobName = $jobListingBody->jobtitle;
         $jobResponsibilities= strip_tags($jobListingBody->responsibilities , '<ul> <li>');
         $jobOverview = rip_tags($jobListingBody->overview);
         $jobQualifications = strip_tags($jobListingBody->qualifications, '<ul> <li>');
         $jobPosType = $jobListingBody->positiontype->value;
         $jobIdNumber = $jobListingBody->id;
         $jobLink = $jobUrl;
         $jobDepartment = $jobListingBody->positioncategory->value;


         //Loop through the feed so we can insert each post
           $post_arr = array(
             'post_title' => $jobName, //Title of post -> Name
             'post_type' =>'jobs',
              'post_status' => 'publish',
                'post_category' => array('51', $jobDepartment)



           );


           $post_agent = wp_insert_post($post_arr, true);

           // save values in post - Fields are created using ACF and adding the respective field keys here for data inserts
           $jobName_key = "field_1234";
           $value = $jobName;
           update_field( $jobName_key, $value, $post_agent );

           $jobID_key = "field_12345";
           $value = $jobIdNumber;
           update_field( $jobID_key, $value, $post_agent );

           $jobOverview_key = "field_13456";
           $value = $jobOverview;
           update_field(  $jobOverview_key, $value, $post_agent );

           $jobResponsibilities_key = "field_1234567";
           $value = $jobResponsibilities;
           update_field( $jobResponsibilities_key, $value, $post_agent );

           $jobQualifications_key = "field_12345678";
           $value = $jobQualifications;
           update_field( $jobQualifications_key, $value, $post_agent );

            $jobDepartment_key = "field_123456789";
            $value = $jobDepartment;
            update_field( $jobDepartment_key, $value, $post_agent );

            $jobType_key = "field_1234567890";
            $value = $jobPosType;
            update_field( $jobType_key, $value, $post_agent );

            $jobUrl_key = "field_12345678901";
            $value = $jobLink;
            update_field( $jobUrl_key, $value, $post_agent );





   }


   echo '<h2>All posts have Been Updated. Please close this window, and push to live.  Thank you, and have a great day.</h2>';


   ?>


</div>
