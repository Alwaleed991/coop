<?php                                                                                                      
   
  return [                                                                                                   
      'host' => env('ELASTICSEARCH_HOST', 'elasticsearch_service'),
      'port' => env('ELASTICSEARCH_PORT', 9200),
  ];