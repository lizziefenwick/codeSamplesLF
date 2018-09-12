The code here is used to pull data from an external API and use the data to automatically create posts within a custom post type on wordpress using JSON data arrays from an external API 
This depends on there being a custom post type for the posts, and using Advanced Custom Fields in order to create the fields for the data to be input. 

Ideally this is ran as a cron job rather than a template, but this is to show that it can be a template assigned to a hidden page in order to delete, update and create posts on demand if the cron job fails. 
