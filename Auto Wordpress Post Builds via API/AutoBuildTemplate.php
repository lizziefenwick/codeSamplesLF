<?php
/**
* Template Name: AutoBuild
 *
 * @package understrap
 */

 get_header();

 //Delete all current Posts
  $mycustomposts = get_posts( array( 'post_type' => 'datas', 'numberposts' => -1));
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
$yourdataRequest = wp_remote_get( ''//url redacted due to security,
 array(

 'headers' => array(

      'Authorization' => 'Basic c3ZnYXBpdXNlcjp0JmU4KkpzVzM0OzE='
),
));

if( is_wp_error( $yourdataRequest ) ) {
  	return false;
  echo '<div class="container">';
   echo '<h1>';
  echo "something isn't right";// Bail early
   echo '</h1>';
    echo '</div>';

}

$dataBody = json_decode(wp_remote_retrieve_body( $yourdataRequest ));

      foreach($dataBody->searchResults as $data) {
       $dataUrl = $data->portalUrl;
       $dataId = $data->id;
       $dataDate = $data->updatedDate;
       $dataApiUrl =$data->self;

       //Grab the individual data details

       $yourdataListing = wp_remote_get( 'https://urlredacted.com/'.$dataId.'?fields=datatitle,overview,responsibilities,qualifications,id,positioncategory,positiontype,datalocation',
        array(

        'headers' => array(

             'Authorization' => 'Basic c3ZnYXBpdXNlcjp0JmU4KkpzVzM0OzE='
       ),
       ));

       $dataListingBody = json_decode(wp_remote_retrieve_body( $yourdataListing ));

            // echo '<pre>';
            // print_r($yourdataListing);
            // echo '</pre>';

         $dataName = $dataListingBody->datatitle;
         $dataResponsibilities= strip_tags($dataListingBody->responsibilities , '<ul> <li>');
         $dataOverview = rip_tags($dataListingBody->overview);
         $dataQualifications = strip_tags($dataListingBody->qualifications, '<ul> <li>');
         $dataPosType = $dataListingBody->positiontype->value;
         $dataIdNumber = $dataListingBody->id;
         $dataLink = $dataUrl;
         $dataDepartment = $dataListingBody->positioncategory->value;


         //Loop through the feed so we can insert each post
           $post_arr = array(
             'post_title' => $dataName, //Title of post -> Name
             'post_type' =>'datas',
              'post_status' => 'publish',
                'post_category' => array('51', $dataDepartment)



           );


           $post_agent = wp_insert_post($post_arr, true);

           // save values in post - Fields are created using ACF and adding the respective field keys here for data inserts
           $dataName_key = "field_1234";
           $value = $dataName;
           update_field( $dataName_key, $value, $post_agent );

           $dataID_key = "field_12345";
           $value = $dataIdNumber;
           update_field( $dataID_key, $value, $post_agent );

           $dataOverview_key = "field_13456";
           $value = $dataOverview;
           update_field(  $dataOverview_key, $value, $post_agent );

           $dataResponsibilities_key = "field_1234567";
           $value = $dataResponsibilities;
           update_field( $dataResponsibilities_key, $value, $post_agent );

           $dataQualifications_key = "field_12345678";
           $value = $dataQualifications;
           update_field( $dataQualifications_key, $value, $post_agent );

            $dataDepartment_key = "field_123456789";
            $value = $dataDepartment;
            update_field( $dataDepartment_key, $value, $post_agent );

            $dataType_key = "field_1234567890";
            $value = $dataPosType;
            update_field( $dataType_key, $value, $post_agent );

            $dataUrl_key = "field_12345678901";
            $value = $dataLink;
            update_field( $dataUrl_key, $value, $post_agent );





   }


   echo '<h2>All posts have Been Updated. Please close this window, and push to live.  Thank you, and have a great day.</h2>';


   ?>


</div>
